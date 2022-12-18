<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_no', 'order_date', 'person_order_id', 'contact_first_name', 'contact_last_name', 'contact_email', 'contact_phone',
        'contact_address', 'note', 'status', 'reason_for_cancel_order', 'total_quantity', 'total_price',
        'warehouse_pickup', 'shipping_code', 'transporter', 'shipping_status', 'total_weight',
        'delivery_date', 'delivered_date', 'receive_order_date', 'confirm_complete_order_date', 
        'created_at', 'updated_at'
    ];
}
