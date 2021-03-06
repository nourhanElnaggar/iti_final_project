<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    use HasFactory;
    protected $table='order_items';
    public $timestamps=false;
    protected $fillable = [
        'order_id',
        'product_id',
        'color',
        'size',
        'qty',
        'price'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
