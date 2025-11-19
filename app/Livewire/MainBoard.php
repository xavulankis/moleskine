<?php

namespace App\Livewire;

use App\Models\Entry;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MainBoard extends Component
{
    public function render()
    {
        // Main Selection, Join tables entries, categories and entry_tag
        $data = Entry::select(
            'entries.id as id',
            'categories.name as category_name',
            'entries.title as title',
            'entries.description as description',
            'entries.url as url',
            'entries.place as place',
            'entries.value as value',
            'entries.autor as autor',
            'entries.date as date',
            'entries.info as info',
            'entries.created_at as created_at',
        )
            ->join('categories', 'entries.category_id', '=', 'categories.id')
            ->join('entry_tag', 'entries.id', '=', 'entry_tag.entry_id')
            ->distinct('entries.id')            
            ->where('entries.user_id', '=', Auth::id());

        //dd($data->count());  
        
        $notifications = Entry::where('date', '>=', today())->orderby('date', 'ASC')->get();

        return view('livewire.main-board',[
            // Styles
            'iconShow'              => 'text-black',
            // Data
            'entries'               => $data,
            'notifications'         => $notifications,
        ]);
    }
}
