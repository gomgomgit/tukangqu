<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkerRequest extends FormRequest
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
        return [
            'name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'email' => 'required|email',
            'phone_number' => 'required|unique:workers,phone_number, ' . $this->id,
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'worker_kind_id' => 'required',
            'specialist_id' => 'required',
            'experience' => 'required',
            'skill' => 'required|array',
            'self_photo' => 'required|image',
            'id_card_photo' => 'required|image',
        ];
    }
}
