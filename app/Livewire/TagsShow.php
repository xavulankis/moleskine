<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Component;

class TagsShow extends Component
{
    public Tag $tag;

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function render()
    {
        return view('livewire.tags-show', [
            'tag' => $this->tag
        ]);
    }    
}
