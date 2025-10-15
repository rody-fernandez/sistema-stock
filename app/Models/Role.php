<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    /**
     * Known labels for the administrator role.
     */
    public const ADMIN_NAMES = ['admin', 'Administrador', 'administrador', 'administrator'];

    /**
     * Known labels for the regular user role.
     */
    public const USER_NAMES = ['user', 'Usuario', 'usuario'];

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Normalize a list of role names for comparisons.
     */
    public static function normalizeNames(array $names): array
    {
        $normalized = array_map(
            static fn ($name) => Str::of($name ?? '')->trim()->lower()->value(),
            $names
        );

        return array_values(array_filter(
            array_unique($normalized),
            static fn ($name) => $name !== ''
        ));
    }

    /**
     * Attempt to locate the first role matching any of the provided names.
     */
    public static function findMatching(array $names): ?self
    {
        $normalized = static::normalizeNames($names);

        return static::query()
            ->get(['id', 'name'])
            ->first(static function (self $role) use ($normalized) {
                return in_array($role->normalizedName(), $normalized, true);
            });
    }

    /**
     * Ensure a role exists by name, considering provided aliases.
     */
    public static function ensureExists(string $preferredName, array $aliases = []): self
    {
        $candidates = array_merge([$preferredName], $aliases);

        return static::findMatching($candidates)
            ?? static::create(['name' => $preferredName]);
    }

    /**
     * Determine if the role matches any of the provided names.
     */
    public function matchesName(array|string $names): bool
    {
        $names = is_array($names) ? $names : func_get_args();

        return in_array($this->normalizedName(), static::normalizeNames($names), true);
    }

    /**
     * Determine if the current role corresponds to an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->matchesName(static::ADMIN_NAMES);
    }

    protected function normalizedName(): string
    {
        return Str::of($this->name)->trim()->lower()->value();
    }
}
