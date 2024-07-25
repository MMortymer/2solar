<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'stock'];

    public function systems()
    {
        return $this->belongsToMany(System::class)->withPivot('quantity');
    }
}
