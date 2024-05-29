<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestProduct extends Model
{
    use HasFactory;

    protected $fillable = [
		    'customer_id',
            'return_request_no',
            'ordered_product_id',
            'product_id',
            'product_color_id',
            'product_size_id',
            'weight',
            'quantity',
            'sub_total',
            'reason',
            'image',
            'status',
            'remarks',
            'created_by',
            'updated_by'
		];

	protected $hidden = [
        'customer_id', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function ordered_product()
    {
    	return $this->belongsTo(OrderedProduct::class, 'ordered_product_id');
    }

    public static function return_status()
    {
        $return_status = [   
                            '0' => ['Requested', 'warning'],
                            '1' => ['Accepted', 'success'],
                            '2' => ['Rejected', 'danger']
                        ];

        return $return_status;
    }
}
