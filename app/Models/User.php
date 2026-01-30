<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'can_access_surat',
        'role',
        'surat_permissions',
        'dashboard_permissions',
        'author_permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'can_access_surat' => 'boolean',
            'surat_permissions' => 'array',
            'dashboard_permissions' => 'array',
            'author_permissions' => 'array',
        ];
    }

    public function hasSuratPermission(string $permission): bool
    {
        if ($this->isAdminRole()) {
            return true;
        }

        $permissions = $this->surat_permissions ?? [];
        $rolePermissions = $this->getRolePermissions('surat');

        return in_array($permission, $permissions, true) || in_array($permission, $rolePermissions, true);
    }

    public function hasDashboardPermission(string $permission): bool
    {
        if ($this->isAdminRole()) {
            return true;
        }

        $permissions = $this->dashboard_permissions ?? [];
        $rolePermissions = $this->getRolePermissions('dashboard');

        return in_array($permission, $permissions, true) || in_array($permission, $rolePermissions, true);
    }

    public function hasAuthorPermission(string $permission): bool
    {
        if ($this->isAdminRole()) {
            return true;
        }

        $permissions = $this->author_permissions ?? [];
        $rolePermissions = $this->getRolePermissions('author');

        return in_array($permission, $permissions, true) || in_array($permission, $rolePermissions, true);
    }

    public function author()
    {
        return $this->hasOne(Authors::class, 'user_id');
    }

    public function roleRecord(): ?Role
    {
        if (! $this->role) {
            return null;
        }

        if ($this->relationLoaded('roleRelation')) {
            return $this->roleRelation;
        }

        return Role::where('key', $this->role)->first();
    }

    public function roleRelation(): HasOne
    {
        return $this->hasOne(Role::class, 'key', 'role');
    }

    public function isAdminRole(): bool
    {
        if (($this->role ?? null) === 'admin') {
            return true;
        }

        $role = $this->roleRecord();

        return (bool) ($role?->is_admin ?? false);
    }

    public function canAccessSurat(): bool
    {
        if ($this->isAdminRole()) {
            return true;
        }

        if ($this->can_access_surat) {
            return true;
        }

        $role = $this->roleRecord();

        return (bool) ($role?->can_access_surat ?? false);
    }

    protected function getRolePermissions(string $type): array
    {
        $role = $this->roleRecord();

        if (! $role) {
            return [];
        }

        return match ($type) {
            'surat' => $role->surat_permissions ?? [],
            'dashboard' => $role->dashboard_permissions ?? [],
            'author' => $role->author_permissions ?? [],
            default => [],
        };
    }
}
