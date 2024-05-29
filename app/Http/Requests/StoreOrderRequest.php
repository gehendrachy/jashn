<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->request);
        return [
            'billing_name' => 'required|max:255',
            'billing_phone' => 'required|max:225',
            'billing_email' => 'required|email|max:225',
            'billing_country_name' => 'required_if:billing_country_id,0|max:225',
            'billing_country_id' => 'required_unless:billing_country_id,0|max:225',
            'billing_state_name' => 'required_if:billing_country_id,0|max:225',
            'billing_state_id' => 'required_unless:billing_country_id,0|max:225',
            'billing_district_name' => 'required_if:billing_country_id,0|max:225',
            'billing_district_id' => 'required_unless:billing_country_id,0|max:225',
            'billing_city_name' => 'required_if:billing_country_id,0|max:225',
            'billing_city_id' => 'required_unless:billing_country_id,0|max:225',
            'billing_street_address_1' => 'required|max:225',

            'shipping_name' => 'required_unless:same_address,1|max:225',
            'shipping_phone' => 'required_unless:same_address,1|max:225',
            'shipping_email' => 'required_unless:same_address,1|email|max:225',
            // 'shipping_country_name' => 'max:225|'.
            //                             Rule::requiredIf(function(){
            //                                 return !isset($this->request->same_address);
            //                             }),
            'shipping_country_id' => 'required_unless:same_address,1|max:225',
            // 'shipping_state_name' => 'max:225|'.
            //                             Rule::requiredIf(function(){
            //                                 return !isset($this->request->same_address);
            //                             }),
            'shipping_state_id' => 'required_unless:same_address,1|max:225',
            // 'shipping_district_name' => 'max:225|'.
            //                             Rule::requiredIf(function(){
            //                                 return !isset($this->request->same_address);
            //                             }),
            'shipping_district_id' => 'required_unless:same_address,1|max:225',
            // 'shipping_city_name' => 'max:225|'.
            //                             Rule::requiredIf(function(){
            //                                 return !isset($this->request->same_address);
            //                             }),
            'shipping_city_id' => 'required_unless:same_address,1|max:225',
            'shipping_street_address_1' => 'required_unless:same_address,1|max:225',
            'payment_method' => 'required'
        ];
    }
}
