<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Contact $contact): array
    {
        
        //dd($contact->email);
        return [
            'type'              => 'required',
            'first_name'        => 'required|min:2',
            'last_name'         => 'required|min:2',
            'phone'             => 'nullable',            
            'email'             => ['nullable',Rule::unique('contacts', 'email')->ignore($contact->id) ],
            'address'           => 'nullable|min:3',
            'city'              => 'nullable',
            'location'          => 'nullable',
            'birthdate'         => 'nullable',
            'info'              => 'nullable|min:3'
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Select one type.',
            'email.unique' => 'Email usado',

        ];
    }
}
