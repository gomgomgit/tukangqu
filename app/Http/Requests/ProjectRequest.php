<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        if ($this->get('client') == 1) {
            return [
                'name_new_client' => 'required',
                'order_date' => 'required',
                'phone_number' => 'required',
                'client_address' => 'required',
                'address' => 'required',
                'kind_work' => 'required',
                'kind_project' => 'required',
                'client_province_id' => 'required',
                'client_city_id' => 'required',
                'province_id' => 'required',
                'city_id' => 'required'
            ];
        } else {
            return [
                'name_old_client' => 'required',
                'order_date' => 'required',
                'address' => 'required',
                'kind_work' => 'required',
                'kind_project' => 'required',
                'province_id' => 'required',
                'city_id' => 'required'
            ];
        }
    }
}
