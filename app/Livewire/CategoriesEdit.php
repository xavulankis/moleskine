<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoriesEdit extends Component
{
    public Category $category;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        return view('livewire.categories-edit', [
            'category' => $this->category
        ]);
    }
}
