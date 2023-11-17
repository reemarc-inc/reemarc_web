<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Actions\Fortify\PasswordValidationRules;

use App\Models\Clinic;
use Auth;

class ClinicRequest extends FormRequest
{
    use PasswordValidationRules;
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
//            'name' => ['required', 'string', 'max:255'],
            'name' => ['string'],
            'address' => ['string'],
            'description' => ['string'],
            'latitude' => ['string'],
            'longitude' => ['string'],
            'region' => ['string'],
            'tel' => ['string'],
            'duration' => ['string'],
        ];
    }
}
