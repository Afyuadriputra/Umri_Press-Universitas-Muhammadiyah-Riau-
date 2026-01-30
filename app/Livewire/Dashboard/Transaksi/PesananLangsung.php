<?php

namespace App\Livewire\Dashboard\Transaksi;

use App\Actions\CalculateRoyaltyAction;
use App\Models\DirectOrder;
use Livewire\Component;
use Livewire\WithPagination;

class PesananLangsung extends Component
{
    use WithPagination;

    public const STATUS_LABELS = [
        'pending' => 'Menunggu Konfirmasi',
        'verified' => 'Terverifikasi',
        'processing' => 'Diproses',
        'shipped' => 'Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    public string $statusFilter = '';
    public string $search = '';
    public ?DirectOrder $selectedOrder = null;
    public string $statusUpdate = '';
    public ?string $catatan_admin = null;

    protected $rules = [
        'statusUpdate'   => 'required|string|in:pending,verified,processing,shipped,completed,cancelled',
        'catatan_admin'  => 'nullable|string',
    ];

    protected $listeners = ['refresh-orders' => '$refresh'];

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function showDetail(int $orderId): void
    {
        $this->selectedOrder = DirectOrder::with(['buku', 'paymentMethod'])->findOrFail($orderId);
        $this->statusUpdate   = $this->selectedOrder->status;
        $this->catatan_admin  = $this->selectedOrder->catatan_admin;
        $this->dispatch('open-modal', 'order-detail');
    }

    public function updateOrder(): void
    {
        $this->validate();

        if (! $this->selectedOrder) {
            return;
        }

        $this->selectedOrder->update([
            'status'        => $this->statusUpdate,
            'catatan_admin' => $this->catatan_admin,
        ]);

        if ($this->statusUpdate === DirectOrder::STATUS_COMPLETED) {
            app(CalculateRoyaltyAction::class)->execute($this->selectedOrder->fresh());
        }

        $this->dispatch('notify', message: 'Status pesanan diperbarui.', type: 'success');
        $this->dispatch('close-modal', 'order-detail');

        $this->reset(['selectedOrder', 'statusUpdate', 'catatan_admin']);
        $this->resetPage();
    }

    public function render()
    {
        $orders = $this->orderQuery()->latest()->paginate(15);

        return view('livewire.dashboard.transaksi.pesanan-langsung', [
            'orders'   => $orders,
            'statuses' => self::STATUS_LABELS,
        ]);
    }

    protected function orderQuery()
    {
        return DirectOrder::with(['buku', 'paymentMethod'])
            ->when($this->statusFilter, fn ($query) => $query->where('status', $this->statusFilter))
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('recipient_name', 'like', "%{$this->search}%")
                        ->orWhere('recipient_email', 'like', "%{$this->search}%")
                        ->orWhereHas('buku', fn ($buku) => $buku->where('judul', 'like', "%{$this->search}%"));
                });
            });
    }
}
