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
            // Styles            
            'bgMenuColor'   => 'bg-indigo-800',
            'underlineMenu'         => 'border-b-2 border-b-amber-600',
            // Data
            'category' => $this->category
        ]);
    }
}
