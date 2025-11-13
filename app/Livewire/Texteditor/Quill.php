<?php

namespace App\Livewire\Texteditor;

use Livewire\Component;

class Quill extends Component
{
    
    const EVENT_VALUE_UPDATED = 'quill_value_updated';

    // you can pass any value as you wish like this -> @livewire('quill', ['value' => 'Hello <strong>Buddy!</strong>'])
    public $value;
    // to create multiple editors on the same page
    public $quillId;

    public function mount($value = ''){

        $this->value = $value;
        $this->quillId = 'quill-'.uniqid();
        //dd($this->quillId);
        /* var_dump($this->quillId);
        var_dump($this->value); */
    }

    // To check if the data binding is working
    /* public function updatedValue($value){
        dd($value);    
    } */

    public function updatedValue($value) 
    {
        //dd($this->value);
        /* $this->emit(self::EVENT_VALUE_UPDATED, $this->value); */
        //$this->dispatch('EVENT_VALUE_UPDATED', value: $this->value);

        $this->dispatch(self::EVENT_VALUE_UPDATED, $this->value);
    }
    
    public function render()
    {
        return view('livewire.texteditor.quill');
    }
}
