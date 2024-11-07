<?php

// App\Models\Register.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    protected $table = 'register';

    protected $fillable = [
        'ProductId',
        'BaseId',
        'Count',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId');
    }
}
