<?php

namespace App\Livewire;

use App\Livewire\Texteditor\Quill;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Http\Request;
use Livewire\Component;
use Exception;

class EntriesCreate extends Component
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

    public function mount()
    {
        $this->date = date('Y-m-d');
       
        $this->category_id = Category::orderBy('name', 'asc')->pluck('id')->first();      
          
        // var_dump($this->balance_id);
        // dd($this->balance_id);

    }

    public function save(Request $request)
    {
        //dd($request);
        $validated = $this->validate();
        $validated['user_id'] = $request->user()->id;
        // TODO: CHECK WHY GET balance_id come as string and not as int like category_id
        //$validated['balance_id'] = intval($validated['balance_id']);
        
        // test error
        // $validated['user_id'] = null;

        try {
            $entry = Entry::create($validated);
            $entry->tags()->sync($validated['selectedTags']); 
            return to_route('entries.index', $entry)->with('message', 'Entry ID (' . $entry->id . ') created successfully');
        } catch (Exception $e) {
            return to_route('entries.index')->with('error', 'Error (' . $e->getCode() . ') failed when create a new entry');            
        }
    }


    public function render()
    {
        // Using Eloquent Collection Methods
        $categories     = Category::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);    
        $tags           = Tag::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);

        return view('livewire.entries-create', [
            'categories'        => $categories,
            'tags'              => $tags,
        ]);
    }
}

