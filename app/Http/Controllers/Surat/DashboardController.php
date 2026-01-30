<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\LetterTemplate;
use App\Models\OutgoingLetter;
use App\Models\SuratNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $incomingStatusOrder = ['baru', 'diproses', 'selesai', 'arsip'];
        $outgoingStatusOrder = ['draft', 'approved', 'sent', 'archived'];
        $dispositionStatusOrder = ['baru', 'diproses', 'selesai'];

        $incomingStatusRaw = IncomingLetter::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $outgoingStatusRaw = OutgoingLetter::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $dispositionStatusRaw = Disposition::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $incomingStatus = $this->mapStatusCounts($incomingStatusOrder, $incomingStatusRaw);
        $outgoingStatus = $this->mapStatusCounts($outgoingStatusOrder, $outgoingStatusRaw);
        $dispositionStatus = $this->mapStatusCounts($dispositionStatusOrder, $dispositionStatusRaw);

        $startMonth = Carbon::now()->startOfMonth()->subMonths(5);
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $months[] = $startMonth->copy()->addMonths($i)->format('Y-m');
        }

        $incomingMonthExpr = $this->monthExpression('received_at');
        $outgoingMonthExpr = $this->monthExpression('sent_at');

        $incomingMonthlyRaw = IncomingLetter::selectRaw("{$incomingMonthExpr} as ym, count(*) as total")
            ->whereNotNull('received_at')
            ->where('received_at', '>=', $startMonth->copy()->toDateString())
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym')
            ->all();

        $outgoingMonthlyRaw = OutgoingLetter::selectRaw("{$outgoingMonthExpr} as ym, count(*) as total")
            ->whereNotNull('sent_at')
            ->where('sent_at', '>=', $startMonth->copy()->toDateString())
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym')
            ->all();

        $incomingMonthly = $this->mapMonthCounts($months, $incomingMonthlyRaw);
        $outgoingMonthly = $this->mapMonthCounts($months, $outgoingMonthlyRaw);

        return view('dashboard-surat.index', [
            'title' => 'Dashboard Surat',
            'summary' => [
                'incoming' => IncomingLetter::count(),
                'outgoing' => OutgoingLetter::count(),
                'dispositions' => Disposition::count(),
                'templates' => LetterTemplate::count(),
                'users' => User::count(),
                'unreadNotifications' => SuratNotification::where('user_id', auth()->id())
                    ->whereNull('read_at')
                    ->count(),
            ],
            'incomingStatus' => $incomingStatus,
            'outgoingStatus' => $outgoingStatus,
            'dispositionStatus' => $dispositionStatus,
            'incomingMonthly' => $incomingMonthly,
            'outgoingMonthly' => $outgoingMonthly,
            'recentIncoming' => IncomingLetter::latest()->take(5)->get(),
            'recentOutgoing' => OutgoingLetter::latest()->take(5)->get(),
        ]);
    }

    private function mapStatusCounts(array $order, array $raw): array
    {
        $result = [];
        foreach ($order as $status) {
            $result[$status] = (int) ($raw[$status] ?? 0);
        }

        return $result;
    }

    private function mapMonthCounts(array $months, array $raw): array
    {
        $result = [];
        foreach ($months as $month) {
            $result[$month] = (int) ($raw[$month] ?? 0);
        }

        return $result;
    }

    private function monthExpression(string $column): string
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            return "strftime('%Y-%m', {$column})";
        }

        if ($driver === 'pgsql') {
            return "to_char({$column}, 'YYYY-MM')";
        }

        return "DATE_FORMAT({$column}, '%Y-%m')";
    }
}
