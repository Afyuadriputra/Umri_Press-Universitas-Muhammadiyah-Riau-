<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SemuaUsers extends Component
{
    use WithPagination;

    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $search = '';
    public $sortBy = 'newest';
    public $selectedId;
    public $can_access_surat = false;
    public $role = 'user';
    public $surat_permissions = [];
    public $dashboard_permissions = [];
    public $author_permissions = [];
    public $roles = [];
    public $suppressRoleAutofill = false;

    public array $availablePermissions = [
        'incoming.view' => 'Surat Masuk: lihat',
        'incoming.create' => 'Surat Masuk: tambah',
        'incoming.update' => 'Surat Masuk: edit',
        'incoming.delete' => 'Surat Masuk: hapus',
        'incoming.export' => 'Surat Masuk: export',
        'incoming.disposition' => 'Surat Masuk: disposisi',
        'outgoing.view' => 'Surat Keluar: lihat',
        'outgoing.create' => 'Surat Keluar: tambah',
        'outgoing.update' => 'Surat Keluar: edit',
        'outgoing.delete' => 'Surat Keluar: hapus',
        'outgoing.export' => 'Surat Keluar: export',
        'outgoing.approve' => 'Surat Keluar: approve',
        'outgoing.send' => 'Surat Keluar: kirim',
        'disposisi.view' => 'Disposisi Saya: lihat',
        'disposisi.update' => 'Disposisi Saya: update status',
        'template.manage' => 'Template Surat: kelola',
        'settings.manage' => 'Pengaturan Surat: kelola',
        'notifications.view' => 'Notifikasi Surat: lihat',
        'audit.view' => 'Audit Log: lihat',
        'users.manage' => 'Manajemen User: kelola',
    ];

    public array $availableDashboardPermissions = [
        'dashboard.view' => 'Dashboard: lihat',
        'buku.view' => 'Buku: lihat',
        'buku.create' => 'Buku: tambah',
        'buku.update' => 'Buku: edit',
        'buku.trash' => 'Buku: tempat sampah',
        'buku.category.view' => 'Kategori Buku: lihat',
        'authors.manage' => 'Penulis: kelola',
        'artikel.view' => 'Artikel: lihat',
        'artikel.create' => 'Artikel: tambah',
        'artikel.update' => 'Artikel: edit',
        'artikel.trash' => 'Artikel: tempat sampah',
        'artikel.category.manage' => 'Kategori Artikel: kelola',
        'tim.view' => 'Tim: lihat',
        'tim.create' => 'Tim: tambah',
        'tim.update' => 'Tim: edit',
        'tim.trash' => 'Tim: tempat sampah',
        'tim.structure.update' => 'Tim: update struktur',
        'tim.adminwa.update' => 'Tim: update admin WA',
        'sertifikat.manage' => 'Sertifikat: kelola',
        'harga.view' => 'Harga Paket: lihat',
        'harga.create' => 'Harga Paket: tambah',
        'harga.update' => 'Harga Paket: edit',
        'harga.trash' => 'Harga Paket: tempat sampah',
        'pembayaran.manage' => 'Metode Pembayaran: kelola',
        'transaksi.view' => 'Transaksi: lihat',
        'transaksi.detail' => 'Transaksi: detail',
        'transaksi.update' => 'Transaksi: update status',
        'royalty.manage' => 'Royalti Penulis: kelola',
        'payouts.manage' => 'Pencairan Penulis: kelola',
        'users.manage' => 'Pengguna: kelola',
        'settings.manage' => 'Pengaturan Web: kelola',
        'komentar.manage' => 'Komentar Buku: kelola',
        'roles.manage' => 'Role: kelola',
    ];

    public array $availableAuthorPermissions = [
        'author.dashboard.view' => 'Dashboard Author: lihat',
        'author.sales.view' => 'Penjualan: lihat',
        'author.payouts.view' => 'Pencairan: lihat',
        'author.payouts.create' => 'Pencairan: ajukan',
        'author.settings.view' => 'Pengaturan: lihat',
        'author.settings.update' => 'Pengaturan: ubah',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'newest']
    ];

    public function mount()
    {
        $this->roles = Role::orderBy('name')->get();
    }

    protected function rules()
    {
        $roleKeys = collect($this->roles)->pluck('key')->toArray();

        $rules = [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email',
            'can_access_surat' => 'boolean',
            'role' => ['required', Rule::in($roleKeys)],
            'surat_permissions' => 'array',
            'dashboard_permissions' => 'array',
            'author_permissions' => 'array',
        ];

        if (!$this->userId) {
            // Rules for new user
            $rules['email'] .= '|unique:users';
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        } else {
            // Rules for existing user - make password optional
            if ($this->password) {
                $rules['password'] = ['required', 'confirmed', Password::defaults()];
            }
        }

        return $rules;
    }

    public function getUsers()
    {
        $query = User::with('roleRelation')->when($this->search, function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        });

        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query->paginate(10);
    }

    public function openCreateModal()
    {
        $this->suppressRoleAutofill = true;
        $this->resetForm();
        $this->suppressRoleAutofill = false;
        $this->dispatch('open-modal', 'userModal');
    }

    public function edit($id)
    {
        $this->suppressRoleAutofill = true;
        $this->resetForm();
        $this->userId = $id;
        $user = User::find($id);

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->can_access_surat = (bool) $user->can_access_surat;
            $this->role = $user->role ?? 'user';
            $this->surat_permissions = $user->surat_permissions ?? [];
            $this->dashboard_permissions = $user->dashboard_permissions ?? [];
            $this->author_permissions = $user->author_permissions ?? [];
        }

        $this->suppressRoleAutofill = false;
        $this->dispatch('open-modal', 'userModal');
    }

    public function updatedRole($value): void
    {
        if ($this->suppressRoleAutofill) {
            return;
        }

        $this->applyRoleDefaults($value);
    }

    public function resetRoleDefaults(): void
    {
        $this->applyRoleDefaults($this->role);
    }

    private function applyRoleDefaults(?string $roleKey): void
    {
        if (! $roleKey) {
            return;
        }

        $role = $this->roles->firstWhere('key', $roleKey);

        if (! $role) {
            return;
        }

        $this->can_access_surat = (bool) $role->can_access_surat;

        if ($role->is_admin || $roleKey === 'admin') {
            $this->surat_permissions = [];
            $this->dashboard_permissions = [];
            $this->author_permissions = [];
            return;
        }

        $this->surat_permissions = $role->surat_permissions ?? [];
        $this->dashboard_permissions = $role->dashboard_permissions ?? [];
        $this->author_permissions = $role->author_permissions ?? [];
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'can_access_surat' => (bool) $this->can_access_surat,
                'role' => $this->role ?: 'user',
                'surat_permissions' => $this->role === 'admin' ? [] : array_values($this->surat_permissions),
                'dashboard_permissions' => $this->role === 'admin' ? [] : array_values($this->dashboard_permissions),
                'author_permissions' => $this->role === 'admin' ? [] : array_values($this->author_permissions),
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            User::updateOrCreate(
                ['id' => $this->userId],
                $data
            );

            $this->dispatch('notify', message: $this->userId ? 'Admin berhasil diperbarui!' : 'Admin berhasil ditambahkan!', type: 'success');
            $this->dispatch('close-modal', 'userModal');
            $this->resetForm();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan: ' . $e->getMessage(), type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        $user = User::find($id);

        if ($user->id === Auth::id()) {
            $this->dispatch('notify', message: 'Tidak dapat menghapus akun yang sedang login!', type: 'error');
            return;
        }

        if ($user->email === 'umripres@umri.ac.id') {
            $this->dispatch('notify', message: 'Tidak dapat menghapus admin utama!', type: 'error');
            return;
        }

        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmDelete');
    }

    public function delete()
    {
        $user = User::find($this->selectedId);

        if ($user && $user->id !== Auth::id() && $user->email !== 'umripres@umri.ac.id') {
            $user->delete();
            $this->dispatch('notify', message: 'Admin berhasil dihapus!', type: 'success');
        }

        $this->dispatch('close-modal', 'confirmDelete');
    }

    private function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->can_access_surat = false;
        $this->role = 'user';
        $this->surat_permissions = [];
        $this->dashboard_permissions = [];
        $this->author_permissions = [];
    }

    public function render()
    {
        return view('livewire.dashboard.users.semua-users', [
            'users' => $this->getUsers()
        ]);
    }
}
