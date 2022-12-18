<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_no', 'product_id', 'product_quantity', 'product_total_price', 'status', 'created_at', 'updated_at'
    ];

    /**
     * Get the product that owns the order line.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
