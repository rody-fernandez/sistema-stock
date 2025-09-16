<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'contact', 'phone', 'address'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
