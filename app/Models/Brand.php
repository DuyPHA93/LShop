<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProductType;

class Brand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'product_type_id', 'active', 'created_at', 'updated_at'
    ];

    /**
     * Get the product type that owns the brand.
     */
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}
