<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'date',
        'total',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /** 🔹 Relación: una compra tiene muchos detalles */
    public function details(): HasMany
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    /** 🔹 Relación: una compra pertenece a un proveedor */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /** 🔹 Relación: una compra pertenece a un usuario */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
