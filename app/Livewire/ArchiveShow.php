<?php

namespace App\Livewire;

use App\Models\Entry;
use Livewire\Component;

class ArchiveShow extends Component
{   
   
    public int $entryID;

    public function mount(int $archive)
    {
        $this->entryID = $archive;
    }

    public function render()
    {
        $data = Entry::onlyTrashed()->get();
        $entry = $data->where('id', '=', $this->entryID)->first();

        return view('livewire.archive-show', [
            'archive' => $entry
        ]);
    }    
      
}
