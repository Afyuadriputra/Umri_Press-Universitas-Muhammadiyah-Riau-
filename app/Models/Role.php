<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'key',
        'name',
        'description',
        'is_system',
        'is_admin',
        'can_access_surat',
        'surat_permissions',
        'dashboard_permissions',
        'author_permissions',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_admin' => 'boolean',
        'can_access_surat' => 'boolean',
        'surat_permissions' => 'array',
        'dashboard_permissions' => 'array',
        'author_permissions' => 'array',
    ];
}
