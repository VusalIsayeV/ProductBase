<?php

//App\Models\Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'ProductName',
        'Category',
        'Unit',
        'Status',
        'Barcode',
    ];

    public function registers()
    {
        return $this->hasMany(Register::class, 'ProductId');
    }
}
