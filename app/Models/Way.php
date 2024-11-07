<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Way extends Model
{
    use HasFactory;
    protected $table = 'way';
    protected $fillable = [
        'product_id',
        'ToBase',
        'FromBase',
        'SendNum',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
