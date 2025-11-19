<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactsShow extends Component
{
    public Contact $contact;   

    public function mount(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function render()
    {                      

        return view('livewire.contacts-show', [
            // Styles            
            'bgMenuColor'       => 'bg-amber-600',
            'underlineMenu'     => 'border-b-2 border-b-yellow-400',
            'iconPDF'           => 'text-amber-600',
            'iconEdit'          => 'text-teal-600',
            'iconDelete'        => 'text-red-600',
            'actionsBadge'      => 'uppercase font-bold text-xs text-black bg-yellow-300 rounded-sm border-1 border-black p-1',
            // Data
            'contact'           => $this->contact
        ]);
    }    
   
}
