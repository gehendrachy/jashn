<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
                    'name', 'slug', 'offer_type', 'shipping_condition', 'minimum_quantity', 'minimum_spend', 'maximum_discount', 'discount_percentage', 'start_date', 'expire_date', 'start_time', 'expire_time', 'discount_on', 'discount_items', 'display', 'created_by', 'updated_by'
                ];

    protected $hidden = ['created_by','updated_by','created_at','updated_at'];

    public function category_offers()
    {
        return $this->hasMany(CategoryOffer::class, 'offer_id');
    }

    public function product_offers()
    {
        return $this->hasMany(ProductOffer::class, 'offer_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_offers');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_offers');
    }


    public static $discount_on = [1 => 'Selected Categories', 2 => 'Selected Products', 3 => 'All Products', 4 => 'Pre Payment'];

    public static function check_offer($ordered_quantity, $sub_total, $product_id)
    {
        // $cart = (array)session()->get("cart");
        // $cart_product_ids = collect($cart)->pluck('product_id');
        // $offer = Offer::find(4);
        // $array = [11,12,15,20,21];
        // echo "<pre>";
        // for ($i=1; $i <= count($array); $i++) { 
            
        //     $output = Self::sampling($array, $i);
        //     var_dump($output);
        // }
        // dd(collect($array)->crossJoin($array));
        // // dd($offer->products->pluck('id'));

        // // dd($cart_product_ids->diff($offer->products->pluck('id')));

        // $offers = Self::where([
        //                         ['start_date', '<=', date('Y-m-d')], 
        //                         ['expire_date', '>=', date('Y-m-d')],
        //                         ['offer_type', '!=', 3]
        //                     ])->orWhere([
        //                         ['start_date', '<=', date('Y-m-d')],
        //                         ['expire_date', '>=', date('Y-m-d')],
        //                         ['offer_type', '!=', 3]
        //                     ])->get();

        // dd($offers);

        // $selected_offer = [];
        // $discount_percentage = 0;
        // $total_discount_amount = 0;

        // foreach ($offers as $key => $offer) {

        //     if ($offer->discount_on == 3) {

        //         $total_ordered_qty = collect($cart)->sum('ordered_qty');
        //         $total_ordered_sub_total = collect($cart)->sum('sub_total');

        //         if ($offer->offer_type == 1 && $offer->minimum_quantity >= $total_ordered_qty) {

        //             $temp_discount = $offer->discount_percentage * $total_ordered_sub_total;
        //             $temp_discount = round($temp_discount);
        //         }

        //         if ($offer->offer_type == 2 && $offer->minimum_spend >= $total_ordered_sub_total) {

        //             $temp_discount = $offer->discount_percentage * $total_ordered_sub_total;
        //             $temp_discount = round($temp_discount);
        //         }

        //         $total_discount_amount = $temp_discount;

        //     }elseif ($offer->discount_on == 2) {


        //         $offerExists = $offer->whereHas('products', function(Builder $query) use ($cart_product_ids){
        //             $query->whereIn('id', $cart_product_ids);
        //         })->exists();
               
        //         if ($offerExists) {

        //             if ($offer->discount_percentage > $discount_percentage) {

        //                 $selected_offer = $offer;
        //                 $discount_percentage = $offer->discount_percentage;
        //             }
        //         }

        //     }elseif ($offer->discount_on == 1) {

        //        $offerExists = $offer->whereHas('categories', function(Builder $query) use ($product_id){
        //             $query->whereHas('products', function(Builder $query) use ($product_id){
        //                 $query->where('id', $product_id);
        //             });
        //         })->exists();
               
        //        if ($offerExists) {

        //             if ($offer->discount_percentage > $discount_percentage) {

        //                 $selected_offer = $offer;
        //                $discount_percentage = $offer->discount_percentage;
        //            }
        //        }

        //     }
        // }

        // if ($discount_percentage == 0) {

        //     $final_offer = ['has_offer' => 0];
        // }else{

        //     $final_offer = ['has_offer' => 1, 'offer' => $selected_offer];
        // }











        $offers = Self::where([
                                ['minimum_quantity', '<=', $ordered_quantity],
                                ['start_date', '<=', date('Y-m-d')], 
                                ['expire_date', '>=', date('Y-m-d')],
                                ['offer_type', '!=', 3]
                            ])->orWhere([
                                ['minimum_spend', '<=', $sub_total],
                                ['start_date', '<=', date('Y-m-d')],
                                ['expire_date', '>=', date('Y-m-d')],
                                ['offer_type', '!=', 3]
                            ])->get();

        $selected_offer = [];
        $discount_percentage = 0;
        foreach ($offers as $key => $offer) {

            if ($offer->discount_on == 3) {

                if ($offer->discount_percentage > $discount_percentage) {

                    $selected_offer = $offer;
                    $discount_percentage = $offer->discount_percentage;
                }

            }elseif ($offer->discount_on == 2) {

                $offerExists = $offer->whereHas('products', function(Builder $query) use ($product_id){
                    $query->where('id', $product_id);
                })->exists();
               
                if ($offerExists) {

                    if ($offer->discount_percentage > $discount_percentage) {

                        $selected_offer = $offer;
                        $discount_percentage = $offer->discount_percentage;
                    }
                }

            }elseif ($offer->discount_on == 1) {

               $offerExists = $offer->whereHas('categories', function(Builder $query) use ($product_id){
                    $query->whereHas('products', function(Builder $query) use ($product_id){
                        $query->where('id', $product_id);
                    });
                })->exists();
               
               if ($offerExists) {

                    if ($offer->discount_percentage > $discount_percentage) {

                        $selected_offer = $offer;
                       $discount_percentage = $offer->discount_percentage;
                   }
               }

            }
        }

        if ($discount_percentage == 0) {

            $final_offer = ['has_offer' => 0];
        }else{

            $final_offer = ['has_offer' => 1, 'offer' => $selected_offer];
        }
        
        return $final_offer;

        // $offers = Self::where([
        //                     ['start_date', '<=', date('Y-m-d')], 
        //                     ['expire_date', '>=', date('Y-m-d')],
        //                     ['discount_on', 3],
        //                     ['offer_type','!=', 3],
        //                     ['minimum_quantity', '<=', $ordered_quantity],
        //                     ['minimum_spend', '<=', $sub_total]
        //                 ])
        //                 ->where([
        //                     ['start_date', '<=', date('Y-m-d')], 
        //                     ['expire_date', '>=', date('Y-m-d')],
        //                     ['discount_on', 3],
        //                     ['offer_type','!=', 3],
        //                     ['minimum_spend', '<=', $sub_total]
        //                 ])
        //                 ->orWhereHas('products', function(Builder $query) use ($product_id, $ordered_quantity, $sub_total){

        //                     $query->where('id', $product_id)
        //                             ->whereHas('offers', function(Builder $query) use ($ordered_quantity, $sub_total){

        //                                 $query->where([
        //                                         ['start_date', '<=', date('Y-m-d')], 
        //                                         ['expire_date', '>=', date('Y-m-d')],
        //                                         ['discount_on', 2],
        //                                         ['offer_type', 1],
        //                                         ['minimum_quantity', '<=', $ordered_quantity]
        //                                     ])
        //                                     ->orWhere([
        //                                         ['start_date', '<=', date('Y-m-d')], 
        //                                         ['expire_date', '>=', date('Y-m-d')],
        //                                         ['discount_on', 2],
        //                                         ['offer_type', 2],
        //                                         ['minimum_spend', '<=', $sub_total]
        //                                     ]);
        //                             });
        //                 })
        //                 ->orWhereHas('categories', function(Builder $query) use ($product_id, $ordered_quantity, $sub_total){

        //                     $query->whereHas('products', function(Builder $query) use ($product_id, $ordered_quantity, $sub_total){
        //                                 $query->where('id', $product_id);
        //                             })
        //                             ->whereHas('offers', function(Builder $query) use ($ordered_quantity, $sub_total){
        //                                 $query->where([
        //                                         ['start_date', '<=', date('Y-m-d')], 
        //                                         ['expire_date', '>=', date('Y-m-d')],
        //                                         ['discount_on', 1],
        //                                         ['offer_type', 1],
        //                                         ['minimum_quantity', '<=', $ordered_quantity]
        //                                     ])
        //                                     ->orWhere([
        //                                         ['start_date', '<=', date('Y-m-d')], 
        //                                         ['expire_date', '>=', date('Y-m-d')],
        //                                         ['discount_on', 1],
        //                                         ['offer_type', 2],
        //                                         ['minimum_spend', '<=', $sub_total]
        //                                     ]);
        //                             });
        //                 })->pluck('id')->all();
        //                 echo "string";
        // dd($offers);






        // =========================================================================================================
        // $offers = Self::where([['start_date', '<=', date('Y-m-d')], ['expire_date', '>=', date('Y-m-d')]])->get();

        // if ($offers->count() > 0) {

        //     $offers = Self::where('minimum_quantity', '<=', $ordered_quantity)->orWhere('minimum_spend', '<=', $sub_total)->get();

        //     if ($offers->count()) {
                
        //         $offers = Self::where([['minimum_quantity', '<=', $ordered_quantity],['discount_on', 3],['offer_type', '!=', 3]])->orWhere([['minimum_spend', '<=', $sub_total],['discount_on', 3],['offer_type', '!=', 3]])->get();
                

        //         // if ($offers->count() > 0) {
        //         //     $offers = Self::where([['minimum_quantity', '<=', $ordered_quantity],['discount_on','<=', 3],['offer_type', '!=', 3]])
        //         //                 ->orWhere([['minimum_spend', '<=', $sub_total],['discount_on','<=', 3],['offer_type', '!=', 3]])
        //         //                 ->whereHas('products', function(Builder $query) use ($product_id){
        //         //                         $query->where('id', $product_id);
        //         //                     })
        //         //                     ->orWhereHas('categories', function(Builder $query) use ($product_id){
        //         //                         $query->whereHas('products', function(Builder $query) use ($product_id){
        //         //                             $query->where('id', $product_id);
        //         //                         });
        //         //                     })->get();
        //         //     dd($offers);
        //         // }



        //         if ($offers->count() == 0) {

        //             $offers = Self::where([['minimum_quantity', '<=', $ordered_quantity],['start_date', '<=', date('Y-m-d')], ['expire_date', '>=', date('Y-m-d')]])
        //                             ->orWhere([['minimum_spend', '<=', $sub_total],['start_date', '<=', date('Y-m-d')], ['expire_date', '>=', date('Y-m-d')]])
        //                             ->WhereHas('products', function(Builder $query) use ($product_id){
        //                                 $query->where('id', $product_id);
        //                             })
        //                             ->orWhereHas('categories', function(Builder $query) use ($product_id){
        //                                 $query->whereHas('products', function(Builder $query) use ($product_id){
        //                                     $query->where('id', $product_id);
        //                                 });
        //                             })->get();

        //             if ($offers->count() > 0) {
                        
        //                 $valid_offer = Self::where([['minimum_quantity', '<=', $ordered_quantity]])->orWhere([['minimum_spend', '<=', $ub_total]])
        //                                 ->WhereHas('products', function(Builder $query) use ($product_id){
        //                                     $query->where('id', $product_id);
        //                                 })
        //                                 ->orWhereHas('categories', function(Builder $query) use ($product_id){
        //                                     $query->whereHas('products', function(Builder $query) use ($product_id){
        //                                         $query->where('id', $product_id);
        //                                     });
        //                                 })->orderBy('discount_percentage', 'desc')->first();
        //             }
                    
                    
        //         }else{
                    
        //             $valid_offer = Self::where([['minimum_quantity', '<=', $ordered_quantity],['discount_on', '<=', 3],['offer_type', '!=', 3]])->orWhere([['minimum_spend', '<=', $sub_total],['discount_on', '<=', 3],['offer_type', '!=', 3]])->orderBy('discount_percentage','desc')->first();
        //         }
        //     }

            

        //     // if ($offers->count() > 0) {
                
        //     //     $valid_offer = Self::where([['discount_on', 3],['offer_type', '!=', 3]])
        //     //                         ->orWhereHas('products', function(Builder $query){
        //     //                             $query->where('id', 12);
        //     //                         })
        //     //                         ->orWhereHas('categories', function(Builder $query){
        //     //                             $query->whereHas('products', function(Builder $query){
        //     //                                 $query->where('id', 12);
        //     //                             });
        //     //                         })->orderBy('discount_percentage', 'desc')->pluck('id')->all();
                
        //     // }
        // }

        // if (isset($valid_offer)) {
            
        //     $offer = ['has_offer' => 1, 'offer' => $valid_offer];
        // }else{
        //     $offer = ['has_offer' => 0];
        // }
        // // $valid_offer =  ? $valid_offer : 0;

        // return $offer;
    }

    public static function check_shipping_offer($ordered_quantity, $sub_total, $product_id)
    {

        $offers = Self::where([
                                ['start_date', '<=', date('Y-m-d')], 
                                ['expire_date', '>=', date('Y-m-d')],
                                ['offer_type', 3]
                            ])->get();

        $selected_offer = [];
        $valids_offer = 0;
        $has_free_shipping = 0;
        
        foreach ($offers as $key => $offer) {

            if ($offer->shipping_condition == 1) {

                $valids_offer = 1;

            }elseif ($offer->shipping_condition == 2) {

                if ($sub_total >= $offer->minimum_spend ) {
                    $valids_offer = 1;
                }
            }elseif ($offer->shipping_condition == 3) {

                if ($ordered_quantity >= $offer->minimum_quantity) {

                    $valids_offer = 1;
                }
            }
            
            if ($valids_offer == 1) {

                if ($offer->discount_on == 3) {

                    $has_free_shipping = 1;

                }elseif ($offer->discount_on == 2) {

                    $offerExists = $offer->whereHas('products', function(Builder $query) use ($product_id){
                        $query->where('id', $product_id);
                    })->exists();
                    
                    if ($offerExists) {

                        $has_free_shipping = 1;
                    }

                }elseif ($offer->discount_on == 1) {

                   $offerExists = $offer->whereHas('categories', function(Builder $query) use ($product_id){
                        $query->whereHas('products', function(Builder $query) use ($product_id){
                            $query->where('id', $product_id);
                        });
                    })->exists();
                   
                    if ($offerExists) {

                        $has_free_shipping = 1;
                    }
                }

            }

        }

        if ($has_free_shipping == 0) {

            $final_offer = ['has_offer' => 0];
        }else{

            $final_offer = ['has_offer' => 1];
        }
        
        return $final_offer;

    }

    public static function sampling($chars, $size, $combinations = array()) {

        # if it's the first iteration, the first set 
        # of combinations is the same as the set of characters
        if (empty($combinations)) {
            $combinations = $chars;
        }

        # we're done if we're at size 1
        if ($size == 1) {
            return $combinations;
        }

        # initialise array to put new values in
        $new_combinations = array();

        # loop through existing combinations and character set to create strings
        foreach ($combinations as $combination) {
            foreach ($chars as $char) {
                $new_combinations[] = $combination .' - '. $char;
            }
        }

        # call same function again for the next iteration
        return Self::sampling($chars, $size - 1, $new_combinations);

    }

    

}
