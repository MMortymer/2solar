<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['quantity'];

    public function systems()
    {
        return $this->belongsToMany(System::class)->withPivot('quantity');
    }
}
