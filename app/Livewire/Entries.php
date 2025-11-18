<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use App\Models\User;
use App\Services\EntryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Entries extends Component
{
    use WithPagination;

    // Dependency Injection to use the Service
    protected EntryService $entryService;     
    
    // order and pagination
    public $orderColumn = 'entries.id';
    public $sortOrder = 'desc';
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';
    public $perPage = 25;

    // search
    public $showSearch = 1;
    public $search = '';
    public $searchType = 'title';

       
    // small or full view of the entry table
    public $smallView = false;

    // font size table
    public $smallFont = true;

    // filters    
    public $showFilters = 0;

    //public $types = 2;

    public $dateFrom = '';
    public $initialDateFrom;
    public $dateTo = '';
    public $initialDateTo;

    public $cat = 0;
    public $tag = 0;
    public $selectedTags = [];
    public $tagNames = [];

    // multiple batch selections
    public $selections = [];       
    public $listEntriesIds = [];
    public $okselections = [];

    // CRITERIA
    public $criteria = [];

    public function boot(
        EntryService $entryService,
    ) {
        $this->entryService = $entryService;
    }

    public function updated()
    {
        $this->resetPage();

        // Check if the selection exists in the current filtered entries
        if($this->selections != [])
        {
            // convert string to integer values in the array of IDs selected            
            foreach($this->selections as $key => $selection)
            {                   
                $this->selections[$key] = intval($selection);
                
            }            
        }

        // CRITERIA         
        if($this->search != '')
        {
            $this->criteria['search'] = $this->search;     
            
            switch ($this->searchType) {
                case 'entries.id':
                    $this->criteria['searchType'] = 'Id';
                    break;                                
                default:
                    $this->criteria['searchType'] = $this->searchType;
                    break;
            }

        }else{
            unset($this->criteria['search']);
            unset($this->criteria['searchType']);
        }              

        if($this->initialDateTo != $this->dateTo || $this->initialDateFrom != $this->dateFrom )
        {
            $this->criteria['date'] = date('d-m-Y', strtotime($this->dateFrom)) . ' to ' . date('d-m-Y', strtotime($this->dateTo));
        }
        else{
            unset($this->criteria['date']);
        }        

        if($this->cat != 0)
        {
            $this->criteria['category'] = $this->cat;
        } 
        else{
            unset($this->criteria['category']);
        }            

        if(!in_array('0', $this->selectedTags) && count($this->selectedTags) != 0)
        {
            $this->tagNames = $this->entryService->getTagNames($this->selectedTags);
            $this->criteria['tags'] = implode(', ', $this->tagNames);
        }
        else{
            unset($this->criteria['tags']);
        }  
    }

    public function mount() {       

        $this->InitializeDataUser();
    }

    public function InitializeDataUser()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('entries.date')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('entries.date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('entries.date')));
        $this->initialDateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('entries.date')));        
    }   

    public function activateSmallView(bool $activate)
    {
        $this->smallView = $activate;
    }

    public function activateSmallFont(bool $activate)
    {
        $this->smallFont = $activate;
    }

    public function activateSearch()
    {
        $this->showSearch++;
    }
    
    public function activateFilter()
    {
        $this->showFilters++;
    }

    // Clear Filters

    public function clearFilters()
    {
        $this->clearFiltersUser();
    }

    public function clearFiltersUser()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('entries.date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('entries.date')));        
        $this->cat = 0;
        $this->tag = 0;
        $this->selectedTags = [];
        $this->criteria = [];
    }    

    public function clearSearch()
    {
        $this->search = '';
        $this->searchType = 'title';
        unset($this->criteria['search']);
        unset($this->criteria['searchType']);
    }   

    public function clearFilterDate()
    {
        $this->clearFilterDateUser();
    }
    
    public function clearFilterDateUser()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->min('entries.date')));
        $this->dateTo = date('Y-m-d', strtotime(Entry::where('user_id', Auth::id())->max('entries.date')));
        unset($this->criteria['date']);
    }             

    public function clearFilterCategory()
    {
        $this->cat = 0;
        unset($this->criteria['category']);
    }
   
    public function clearFilterTag()
    {
        $this->tag = 0;
        $this->selectedTags = [];
        unset($this->criteria['tags']);
    }
 
    
    // Bulk Actions

    public function bulkClear()
    {
        $this->selections = [];
    }

    public function bulkDelete()
    {
        foreach ($this->selections as $selection) {
            $element = Entry::find($selection);
            $element->delete();
        }
        
        return to_route('entries.index')->with('message', 'Entries deleted.');
    }

    public function resetAll()
    {
        $this->clearFilters();
        $this->clearSearch();
        $this->bulkClear();
    }

    public function sorting($columnName = '')
    {
        $caretOrder = 'up';
        if ($this->sortOrder == 'asc') {
            $this->sortOrder = 'desc';
            $caretOrder = 'down';
        } else {
            $this->sortOrder = 'asc';
            $caretOrder = 'up';
        }

        $this->sortLink = '<i class="fa-solid fa-caret-' . $caretOrder . '"></i>';
        $this->orderColumn = $columnName;
    }

    public function render()
    {
       
        $found = 0;

        $categories = Category::orderby('name', 'ASC')->get();
        $tags = Tag::orderby('name', 'ASC')->get();
        
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
            ->orderby($this->orderColumn, $this->sortOrder)
            ->where('entries.user_id', '=', Auth::id());         
       
        //dd($data->count());
        /* -------------------------------- FILTERS --------------------------- */
       
        // interval date filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $data = $data->whereDate('entries.date', '>=', $this->dateFrom)
                ->whereDate('entries.date', '<=', $this->dateTo);
            }
            else {
                //dd('errorcito');
            }
        }       

        // category filter
        if ($this->cat != 0) {
            $data = $data->where('categories.name', '=', $this->cat);            
        }        

        // tag filter
        if ($this->tag != 0) {
            //TODO: TAG FILTER, filter but not show the tag name
             $data = $data
             ->join('entry_tag', 'entries.id', '=', 'entry_tag.entry_id')
             ->where('entry_tag.tag_id', '=', $this->tag);
        }                    

        // tags filter        
        if (!in_array('0', $this->selectedTags) && (count($this->selectedTags) != 0)) {
            $data = $data->whereIn('entry_tag.tag_id', $this->selectedTags);
        }

        
        // Search
        if (!empty($this->search)) {
            // trim search in case copy paste or start the search with whitespaces
            // search by id or name
            //$entries->orWhere('id', "like", "%" . $this->search . "%");
            //->orWhere('location', "like", "%" . $this->search . "%")
            $data = $data->where($this->searchType, "like", "%" . trim($this->search) . "%");
            $found = $data->count();
        }

        $total = $data->count();
        $dataRaw =  clone $data;       

        // TEST SELECTIONS IN FILTERS
        $dataEntriesIds = clone $data;

        $this->listEntriesIds = $dataEntriesIds->pluck('id')->toArray();

        $this->okselections = array_intersect($this->listEntriesIds, $this->selections);
        
        // PAGINATION
        $data = $data->paginate($this->perPage);

        //dd($data->count());
        return view('livewire.entries', [
            // Styles            
            'bgMenuColor'           => 'bg-slate-800',
            'underlineMenu'         => 'border-b-2 border-b-yellow-400',
            'bgNewColor'            => 'bg-yellow-400',
            'newText'               => 'text-black text-sm',
            'bgFilterColor'         => 'bg-lime-600',
            'filterCategory'        => 'text-indigo-600',
            'filterTag'             => 'text-teal-600',
            'filterDate'            => 'text-amber-800',
            'bgSearchColor'         => 'bg-sky-600',
            'bgCriteriaColorOn'     => 'bg-amber-600',
            'bgCriteriaColorOff'    => 'bg-slate-400',
            'criteriaSearch'        => 'bg-sky-600 p-2 rounded-sm border-1 border-sky-600',
            'criteriaCategory'      => 'bg-indigo-600 p-2 rounded-sm border-1 border-indigo-600',
            'criteriaTag'           => 'bg-teal-600 p-2 rounded-sm border-1 border-teal-600',
            'criteriaDate'          => 'bg-amber-800 p-2 rounded-sm border-1 border-amber-800',
            'iconShow'              => 'text-amber-600',
            'iconUpload'            => 'text-violet-600',
            'iconEdit'              => 'text-teal-600',
            'iconDelete'            => 'text-red-600',
            'iconUnselect'          => 'text-blue-600',
            'iconExcel'             => 'text-green-600',
            'iconClose'             => 'text-red-600 hover:text-red-500',
            'textError'             => 'text-red-500',
            'tableHighlight'        => 'hover:bg-yellow-200',
            'tableSelected'         => 'bg-teal-100',
            'tableHeaderSelected'   => 'text-yellow-400',
            'tableCellSelected'     => 'bg-blue-100 font-bold text-black transition-all duration-1000',
            
            // Data
            'listEntriesIds'    => $this->listEntriesIds,
            'okselections'      => $this->okselections,
            'entriesRaw'        => $dataRaw,
            'entries'           => $data,
            'categories'        => $categories,
            'tags'              => $tags,
            'found'             => $found,
            'column'            => $this->orderColumn,
            'total'             => $total,
            'tagNames'          => $this->tagNames,
        ]);
    }

    
}
