<?php

namespace App\Livewire\Dashboard\Roles;

use App\Models\Role;
use Livewire\Component;
use Illuminate\Validation\Rule;

class RoleManager extends Component
{
    public $roles;
    public $roleId;
    public $role_key = '';
    public $name = '';
    public $description = '';
    public $can_access_surat = false;
    public $is_admin = false;
    public $is_system = false;
    public $surat_permissions = [];
    public $dashboard_permissions = [];
    public $author_permissions = [];

    public array $availableSuratPermissions = [
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

    public function mount()
    {
        $this->loadRoles();
    }

    public function loadRoles(): void
    {
        $this->roles = Role::orderBy('name')->get();
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'roleModal');
    }

    public function edit(int $id): void
    {
        $this->resetForm();
        $role = Role::findOrFail($id);

        $this->roleId = $role->id;
        $this->role_key = $role->key;
        $this->name = $role->name;
        $this->description = $role->description ?? '';
        $this->can_access_surat = (bool) $role->can_access_surat;
        $this->is_admin = (bool) $role->is_admin;
        $this->is_system = (bool) $role->is_system;
        $this->surat_permissions = $role->surat_permissions ?? [];
        $this->dashboard_permissions = $role->dashboard_permissions ?? [];
        $this->author_permissions = $role->author_permissions ?? [];

        $this->dispatch('open-modal', 'roleModal');
    }

    public function save(): void
    {
        $rules = [
            'role_key' => ['required', 'string', 'max:50', 'regex:/^[a-z0-9_-]+$/', Rule::unique('roles', 'key')->ignore($this->roleId)],
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'can_access_surat' => 'boolean',
            'surat_permissions' => 'array',
            'dashboard_permissions' => 'array',
            'author_permissions' => 'array',
        ];

        $this->validate($rules);

        $data = [
            'key' => $this->role_key,
            'name' => $this->name,
            'description' => $this->description ?: null,
            'can_access_surat' => (bool) $this->can_access_surat,
            'surat_permissions' => array_values($this->surat_permissions ?? []),
            'dashboard_permissions' => array_values($this->dashboard_permissions ?? []),
            'author_permissions' => array_values($this->author_permissions ?? []),
        ];

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);
            if ($role->is_system) {
                unset($data['key']);
            }
            $role->update($data);
        } else {
            $data['is_system'] = false;
            $data['is_admin'] = false;
            Role::create($data);
        }

        $this->dispatch('notify', message: 'Role berhasil disimpan.', type: 'success');
        $this->dispatch('close-modal', 'roleModal');
        $this->resetForm();
        $this->loadRoles();
    }

    public function confirmDelete(int $id): void
    {
        $this->roleId = $id;
        $this->dispatch('open-modal', 'confirmDelete');
    }

    public function delete(): void
    {
        $role = Role::find($this->roleId);

        if (! $role) {
            $this->dispatch('notify', message: 'Role tidak ditemukan.', type: 'error');
            return;
        }

        if ($role->is_system || $role->is_admin) {
            $this->dispatch('notify', message: 'Role sistem tidak dapat dihapus.', type: 'error');
            return;
        }

        $hasUsers = \App\Models\User::where('role', $role->key)->exists();
        if ($hasUsers) {
            $this->dispatch('notify', message: 'Role masih dipakai oleh pengguna.', type: 'error');
            return;
        }

        $role->delete();
        $this->dispatch('notify', message: 'Role berhasil dihapus.', type: 'success');
        $this->dispatch('close-modal', 'confirmDelete');
        $this->loadRoles();
    }

    private function resetForm(): void
    {
        $this->roleId = null;
        $this->role_key = '';
        $this->name = '';
        $this->description = '';
        $this->can_access_surat = false;
        $this->is_admin = false;
        $this->is_system = false;
        $this->surat_permissions = [];
        $this->dashboard_permissions = [];
        $this->author_permissions = [];
    }

    public function render()
    {
        return view('livewire.dashboard.roles.role-manager', [
            'roles' => $this->roles,
        ]);
    }
}
