<?php

namespace App\Livewire\Dashboard\Pembayaran;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MetodePembayaran extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $methodId;
    public $name = '';
    public $type = 'bank';
    public $account_name = '';
    public $account_number = '';
    public $instructions = '';
    public $logo;
    public $is_active = true;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:120',
        'type' => 'required|string|max:50',
        'account_name' => 'nullable|string|max:120',
        'account_number' => 'nullable|string|max:60',
        'instructions' => 'nullable|string',
        'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        'is_active' => 'boolean',
    ];

    public function updatingSearch()
    {
    }

    public function edit($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $this->methodId = $method->id;
        $this->name = $method->name;
        $this->type = $method->type;
        $this->account_name = $method->account_name;
        $this->account_number = $method->account_number;
        $this->instructions = $method->instructions;
        $this->is_active = $method->is_active;
        $this->logo = null;
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->logo) {
            $data['logo_path'] = $this->logo->store('payment-methods', 'public');
        }

        $method = PaymentMethod::updateOrCreate(
            ['id' => $this->methodId],
            $data
        );

        if ($this->logo && $method->wasChanged('logo_path')) {
            $original = $method->getOriginal('logo_path');
            if ($original && Storage::disk('public')->exists($original)) {
                Storage::disk('public')->delete($original);
            }
        }

        $this->dispatch('notify', message: 'Metode pembayaran berhasil disimpan.', type: 'success');
        $this->resetForm();
    }

    public function delete($id)
    {
        $method = PaymentMethod::find($id);
        if ($method) {
            if ($method->directOrders()->exists()) {
                $this->dispatch('notify', message: 'Metode ini sudah dipakai transaksi. Nonaktifkan saja agar tidak digunakan lagi.', type: 'warning');
                return;
            }
            if ($method->logo_path && Storage::disk('public')->exists($method->logo_path)) {
                Storage::disk('public')->delete($method->logo_path);
            }
            $method->delete();
            $this->dispatch('notify', message: 'Metode pembayaran berhasil dihapus.', type: 'success');
        }
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'methodId',
            'name',
            'type',
            'account_name',
            'account_number',
            'instructions',
            'logo',
        ]);
        $this->is_active = true;
    }

    public function render()
    {
        $methods = PaymentMethod::query()
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('name', 'like', "%{$this->search}%")
                        ->orWhere('type', 'like', "%{$this->search}%")
                        ->orWhere('account_number', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.dashboard.pembayaran.metode-pembayaran', [
            'methods' => $methods,
        ]);
    }
}
