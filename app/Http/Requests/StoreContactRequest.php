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
     * 
     */
    public function rules(bool $type, ?Contact $contact=null): array
    {
        // EDIT
        if ($type) {
            //dd($this)->contact;
            // regex:/^[6-9]\d{9}$/: Ensures the number starts with 6-9 and is followed by 8 digits, totaling 9 digits.
            /*
                regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
                A start with one or more alphanumeric characters, including dots, underscores, and percent, plus, & minus signs.
                An @ symbol.
                A domain name consisting of one or more alphanumeric characters, including hyphens and dots.
                A domain extension of at least two alphabetic characters.
            */
            return [
                'type'              => 'required',
                'first_name'        => 'required|min:2',
                'last_name'         => 'required|min:2',
                //'phone'             => 'bail|required|min:3|string|' . Rule::unique('contacts')->ignore($this->contact),
                //'email'             => 'bail|required|min:3|string|' . Rule::unique('contacts')->ignore($this->contact),
                'phone'             => ['nullable','regex:/^[6-9]\d{8}$/', Rule::unique('contacts', 'phone')->whereNull('deleted_at')->ignore($contact->id) ],
                'email'             => ['nullable','regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', Rule::unique('contacts', 'email')->whereNull('deleted_at')->ignore($contact->id) ],
                'address'           => 'nullable|min:3',
                'city'              => 'nullable',
                'location'          => 'nullable',
                'birthdate'         => 'nullable|date',
                'info'              => 'nullable|min:3'
            ];
        }
        // CREATE
        else {
            return [
                'type'              => 'required',
                'first_name'        => 'required|min:2',
                'last_name'         => 'required|min:2',
                'phone'             => ['nullable', 'regex:/^[6-9]\d{8}$/', Rule::unique('contacts')->whereNull('deleted_at')->ignore($this->contact)],
                'email'             => ['nullable','regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', Rule::unique('contacts')->whereNull('deleted_at')->ignore($this->contact)],
                //'phone'             => ['nullable',Rule::unique('contacts', 'phone')->ignore($contact->id) ],
                //'email'             => ['nullable',Rule::unique('contacts', 'email')->ignore($contact->id) ],
                'address'           => 'nullable|min:3',
                'city'              => 'nullable',
                'location'          => 'nullable',
                'birthdate'         => 'nullable',
                'info'              => 'nullable|min:3'
            ];
        }
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Select one type.',
        ];
    }
}
