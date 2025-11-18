<?php

namespace App\Livewire;

use App\Models\Entry;
use App\Services\EntryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EntriesShow extends Component
{
    public Entry $entry;

    // Dependency Injection to use the Service
    protected EntryService $entryService;

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        EntryService $entryService,
    ) {
        $this->entryService = $entryService;
    }

    public function mount(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function render()
    {                      

        return view('livewire.entries-show', [
            // Styles            
            'bgMenuColor'       => 'bg-slate-800',
            'underlineMenu'     => 'border-b-2 border-b-yellow-400',
            'iconPDF'           => 'text-amber-600',
            'iconEdit'          => 'text-teal-600',
            'iconDelete'        => 'text-red-600',
            'actionsBadge'      => 'uppercase font-bold text-xs text-black bg-yellow-300 rounded-sm border-1 border-black p-1',
            // Data
            'entry'             => $this->entry
        ]);
    }    
   
}
