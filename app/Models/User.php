<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        $role = $this->role;

        if ($role instanceof Role) {
            return $role->isAdmin();
        }

        if (!$this->role_id) {
            return false;
        }

        static $adminRoleIds;

        if ($adminRoleIds === null) {
            $adminRoleIds = Role::query()
                ->get(['id', 'name'])
                ->filter->isAdmin()
                ->map(fn (Role $role) => (int) $role->getKey())
                ->values()
                ->all();
        }

        return in_array((int) $this->role_id, $adminRoleIds, true);
    }
}
