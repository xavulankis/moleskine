<?php

namespace App\Livewire;

use App\Livewire\Texteditor\Quill;
use App\Models\Contact;
use Illuminate\Http\Request;
use Livewire\Component;
use Exception;

class ContactsCreate extends Component
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
        'email'             => 'nullable',
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

    public function mount()
    {
        $this->type = 'personal';
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
            $contact = Contact::create($validated);
            return to_route('contacts.index', $contact)->with('message', 'Contact ID (' . $contact->id . ') created successfully');
        } catch (Exception $e) {
            return to_route('contacts.index')->with('error', 'Error (' . $e->getCode() . ') failed when create a new contact');            
        }
    }


    public function render()
    {
        // TODO: get types from the enum in the DB or a Constant in config
        $types    = ['personal','professional'];

        return view('livewire.contacts-create', [
            // Styles            
            'bgMenuColor'       => 'bg-slate-800',
            'underlineMenu'     => 'border-b-2 border-b-yellow-400',
            // Data
            'types'             => $types,
        ]);
    }
}

