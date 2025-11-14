<?php

namespace App\Livewire;

use App\Livewire\Texteditor\Quill;
use App\Models\Balance;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use App\Services\EntryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Exception;

class EntriesEdit extends Component
{
    public $description;
    public $title;
    public $date;
    public $url;
    public $value;
    public $place;
    public $autor;
    public $info;
    public $category_id;    
    public $selectedTags = [];

    protected $rules = [
        'description'       => 'nullable',
        'title'             => 'required|min:3',
        'date'              => 'nullable|after:01/01/2015',
        'url'               => 'nullable|min:3',
        'value'             => 'nullable|numeric|min:0',                
        'place'             => 'nullable|min:3',
        'autor'             => 'nullable|min:3',
        'info'              => 'nullable|min:3',        
        'category_id'       => 'required',        
        'selectedTags'      => 'required',        
    ];

    protected $messages = [
        'category_id.required' => 'Select one category.',
        'selectedTags.required' => 'At least 1 tag must be selected.',
    ];

    /* Quill Editor - removing spaces  */
 
    public $listeners = [
        Quill::EVENT_VALUE_UPDATED
    ];
    
    public function quill_value_updated($value){

       // Remove more than 2 consecutive whitespaces
       if ( preg_match( '/(\s){2,}/s', $value ) === 1 ) {
           $value = preg_replace( '/(\s){2,}/s', '', $value );           
       }
       
       // Because Quill Editor includes <p><br></p> in case you type and then leave the input blank
       if($value == "<p><br></p>" || $value == "<h1><br></h1>" || $value == "<h2><br></h2>" || $value == "<h3><br></h3>" || $value == "<p></p>" || $value == "<p> </p>") { 
           $value = null;
       }
       
       $this->info = $value;

    }

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

        $this->date = $this->entry->date;        
        $this->category_id = $this->entry->category_id;
        $this->selectedTags = $this->entry->tags->pluck('id');
        $this->title = $this->entry->title;
        $this->description = $this->entry->description;
        $this->url = $this->entry->url;        
        $this->place = $this->entry->place;
        $this->autor = $this->entry->autor;
        $this->value = $this->entry->value;
        $this->info = $this->entry->info;
        
    }

    public function save(Request $request)
    {
        $validated = $this->validate();
        $validated['user_id'] = $request->user()->id;

        // test error
        //$validated['user_id'] = null;
        //dd($validated);

        try {
            $this->entry->update($validated);
            $this->entry->tags()->sync($validated['selectedTags']); 
            return to_route('entries.show', $this->entry)->with('message', 'Entry updated successfully');
        } catch (Exception $e) {
            return to_route('entries.show', $this->entry)->with('error', 'Error(' . $e->getCode() . ') Entry updated failed');            
        }
    }

    public function render()
    {
        // Using Eloquent Collection Methods
        $categories     = Category::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);    
        $tags           = Tag::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        
        return view('livewire.entries-edit', [
            'categories'        => $categories,
            'tags'              => $tags,
        ]);
    }
}
