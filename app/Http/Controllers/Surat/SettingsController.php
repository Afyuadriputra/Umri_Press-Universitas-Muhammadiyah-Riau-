<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\LetterType;
use App\Models\LetterUnit;
use App\Models\SuratSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('dashboard-surat.settings.index', [
            'title' => 'Pengaturan Surat',
            'settings' => [
                'instansi' => SuratSetting::getValue('instansi', 'UMRIPRESS'),
                'number_format' => SuratSetting::getValue('number_format', '{sequence}/{instansi}/{jenis}/{unit}/{bulan_roman}/{tahun}'),
                'sequence_length' => SuratSetting::getValue('sequence_length', '3'),
            ],
            'units' => LetterUnit::orderBy('name')->get(),
            'types' => LetterType::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'instansi' => ['required', 'string', 'max:50'],
            'number_format' => ['required', 'string', 'max:255'],
            'sequence_length' => ['required', 'integer', 'min:2', 'max:6'],
        ]);

        foreach ($validated as $key => $value) {
            SuratSetting::updateOrCreate(['key' => $key], ['value' => (string) $value]);
        }

        $this->logAction($request->user()->id, 'settings.update', null, $validated);

        return back()->with('success', 'Pengaturan surat berhasil diperbarui.');
    }

    public function storeUnit(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        LetterUnit::create([
            'code' => strtoupper($validated['code']),
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        $this->logAction($request->user()->id, 'unit.create', null, $validated);

        return back()->with('success', 'Unit berhasil ditambahkan.');
    }

    public function destroyUnit(LetterUnit $unit)
    {
        $unit->delete();

        $this->logAction(request()->user()->id, 'unit.delete', $unit->id, [
            'code' => $unit->code,
        ]);

        return back()->with('success', 'Unit berhasil dihapus.');
    }

    public function storeType(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        LetterType::create([
            'code' => strtoupper($validated['code']),
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        $this->logAction($request->user()->id, 'type.create', null, $validated);

        return back()->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function destroyType(LetterType $type)
    {
        $type->delete();

        $this->logAction(request()->user()->id, 'type.delete', $type->id, [
            'code' => $type->code,
        ]);

        return back()->with('success', 'Jenis surat berhasil dihapus.');
    }

    private function logAction(int $userId, string $action, ?int $entityId, array $meta): void
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => SuratSetting::class,
            'entity_id' => $entityId,
            'meta' => $meta,
        ]);
    }
}
