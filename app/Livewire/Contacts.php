<?php

namespace App\Livewire;

use App\Models\Contact;
use App\Models\User;
use App\Services\EntryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Contacts extends Component
{
    use WithPagination;

    // Dependency Injection to use the Service
    protected EntryService $entryService;     
    
    // order and pagination
    public $orderColumn = 'id';
    public $sortOrder = 'desc';
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';
    public $perPage = 25;

    // search
    public $showSearch = 1;
    public $search = '';
    public $searchType = 'first_name';
       
    // small or full view of the entry table
    public $smallView = true;

    // font size table
    public $smallFont = true;

    // filters    
    public $showFilters = 0;

    public $typ = 0;

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
                case 'id':
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
        
        if($this->typ != 0)
        {
            $this->criteria['type'] = $this->typ;
        }
        else{
            unset($this->criteria['type']);
        }

          
    }

    // TABLE VIEW FONT 

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
        $this->typ = 0;
        $this->criteria = [];
    }    

    public function clearSearch()
    {
        $this->search = '';
        $this->searchType = 'first_name';
        unset($this->criteria['search']);
        unset($this->criteria['searchType']);
    }       

    public function clearFilterType()
    {
        $this->typ = 0;
        unset($this->criteria['type']);
    }
 
    
    // Bulk Actions

    public function bulkClear()
    {
        $this->selections = [];
    }

    public function bulkDelete()
    {
        foreach ($this->selections as $selection) {
            $element = Contact::find($selection);
            $element->delete();
        }
        
        return to_route('contacts.index')->with('message', 'Contacts deleted.');
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
        $types = Contact::orderby('type', 'ASC')->select('type')->distinct()->get();

        $data = Contact::orderby($this->orderColumn, $this->sortOrder)->select('*');
                
        /* -------------------------------- FILTERS --------------------------- */
       
        // type filter personal / professional
        if (!empty($this->typ)) {
            $data = $data->where('type', '=', $this->typ);
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
        return view('livewire.contacts', [
            // Styles            
            'bgMenuColor'           => 'bg-amber-600',
            'underlineMenu'         => 'border-b-2 border-b-yellow-400',
            'bgNewColor'            => 'bg-yellow-400',
            'newText'               => 'text-black text-sm',
            'bgFilterColor'         => 'bg-lime-600',
            'filterType'            => 'text-teal-600',
            'bgSearchColor'         => 'bg-sky-600',
            'bgCriteriaColorOn'     => 'bg-violet-600',
            'bgCriteriaColorOff'    => 'bg-slate-400',
            'criteriaSearch'        => 'bg-sky-600 p-2 rounded-sm border-1 border-sky-600',
            'criteriaType'          => 'bg-teal-600 p-2 rounded-sm border-1 border-teal-600',
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
            'types'             => $types,
            'found'             => $found,
            'column'            => $this->orderColumn,
            'total'             => $total,
        ]);
    }

    
}
