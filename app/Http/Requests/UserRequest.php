<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserModel;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules()
    {

        return [
            'username' => 'required',
            'email' => 'required | email |unique:user_models,useremail,'.$this->get('id'),
            'password' => 'required',
            'contactnumber' => 'required|min:10|max:10',
            'address' => 'required',
            'gender' => 'required',
            'hobbies' => 'required',
            'image' => ($this->id == null ? 'required|image':''),
            'country' => 'required',
            'search' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'The username field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'contactnumber.required' => 'The contactnumber field is required.',
            'contactnumber.min' => 'The contactnumber must be at least 10 characters.',
            'contactnumber.max' => 'The contactnumber may not be greater than 10 characters.',
            'address.required' => 'The address field is required.',
            'gender.required' => 'The gender field is required.',
            'hobbies.required' => 'The hobbies field is required.',
            'country.required' => 'The country field is required.',
            'image.required' => 'The image field is required.',
            'image.image' => 'The image must be a valid image file.',
            'search.required' => 'The search field is required.',

        ];
    }
}
