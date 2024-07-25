<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stock', 'initial_stock', 'low_stock_email_sent'];

    public function systems()
    {
        return $this->belongsToMany(System::class)->withPivot('quantity');
    }
}
