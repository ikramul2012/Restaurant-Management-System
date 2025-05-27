<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    use HasFactory; 

    protected $fillable = [
        'title',
        'detail',
        'price',
        'image',
         
    ];
// In Food.php
public function orders()
{
    return $this->belongsToMany(Order::class, 'food_order')->withPivot('quantity');
}

}
