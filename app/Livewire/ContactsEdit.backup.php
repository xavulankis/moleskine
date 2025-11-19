<?php

namespace App\Livewire;

use App\Livewire\Texteditor\Quill;
use App\Models\Contact;
use Illuminate\Http\Request;
use Livewire\Component;
use Exception;
use Illuminate\Validation\Rule;

class ContactsEdit extends Component
{
    public $type;
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $address;
    public $city;
    public $location;
    public $birthdate;
    public $info;

    protected $rules = [
        'type'              => 'required',
        'first_name'        => 'required|min:2',
        'last_name'         => 'required|min:2',
        'phone'             => 'nullable',
        'email'             => 'nullable|unique:contacts,email',
        //'email'             => 'nullable|' . Rule::unique('contacts')->ignore($contact),
        //'email'             => Rule::unique('contacts', 'email')->ignore($contact->id),
        'address'           => 'nullable',
        'city'              => 'nullable',
        'location'          => 'nullable',
        'birthdate'         => 'nullable',
        'info'              => 'nullable|min:3'
    ];

    protected $messages = [
        'type.required' => 'Select one type.',

    ];

    /* Quill Editor - removing spaces  */
 
    public $listeners = [
        Quill::EVENT_VALUE_UPDATED
    ];

    public function quill_value_updated($value){

       // Remove more than 2 consecutive whitespaces
       if ( preg_match( '/(\s){2,}/s', $value ) === 1 ) {
           $value = preg_replace( '/(\s){2,}/s', '', $value );           
       }
       
       // Because Quill Editor includes <p><br></p> in case you type and then leave the input blank
       if($value == "<p><br></p>" || $value == "<h1><br></h1>" || $value == "<h2><br></h2>" || $value == "<h3><br></h3>" || $value == "<p></p>" || $value == "<p> </p>") { 
           $value = null;
       }
       
       $this->info = $value;

    }

    public Contact $contact;

    public function mount(Contact $contact)
    {
        $this->contact = $contact;

        $this->type = $this->contact->type;
        $this->first_name = $this->contact->first_name;
        $this->last_name = $this->contact->last_name;
        $this->phone = $this->contact->phone;
        $this->email = $this->contact->email;
        $this->address = $this->contact->address;
        $this->city = $this->contact->city;
        $this->location = $this->contact->location;
        $this->birthdate = $this->contact->birthdate;        
        $this->info = $this->contact->info;
    }

    public function save(Request $request)
    {
        //dd($request);
        $validated = $this->validate();
        $validated['user_id'] = $request->user()->id;
        // TODO: CHECK WHY GET balance_id come as string and not as int like category_id
        //$validated['balance_id'] = intval($validated['balance_id']);
        
        // test error
        // $validated['user_id'] = null;

        try {
            $this->contact->update($validated);
            return to_route('contacts.show', $this->contact)->with('message', 'Contact updated successfully');
        } catch (Exception $e) {
            return to_route('contacts.show', $this->contact)->with('error', 'Error (' . $e->getCode() . ') Contact updated failed');            
        }
    }


    public function render()
    {
        // TODO: get types from the enum in the DB or a Constant in config
        $types = ['personal','professional'];

        return view('livewire.contacts-edit', [
            // Styles            
            'bgMenuColor'       => 'bg-slate-800',
            'underlineMenu'     => 'border-b-2 border-b-yellow-400',
            // Data
            'types'             => $types,
        ]);
    }
}

