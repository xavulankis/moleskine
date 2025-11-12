<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Component;

class TagsEdit extends Component
{
    public Tag $tag;

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function render()
    {
        return view('livewire.tags-edit', [
            'tag' => $this->tag
        ]);
    }   
}
