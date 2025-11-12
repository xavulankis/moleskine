<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoriesShow extends Component
{
    public Category $category;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        return view('livewire.categories-show', [
            'category' => $this->category
        ]);
    }
}
