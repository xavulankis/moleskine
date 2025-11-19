<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-col bg-green-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('message') }}</span>
                <a href="/contacts/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex flex-col bg-red-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('error') }}</span>
                <a href="/contacts/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-row justify-between items-center gap-2 p-2 font-bold uppercase {{ $bgMenuColor }} text-white rounded-sm">
        
        <div>
            <a href="/contacts" class="{{ $underlineMenu}}">Contacts</a> 
        </div>

        <div>
            <a href="{{ route('contacts.create') }}"
                class="capitalize {{ $newText }} rounded-sm p-1 {{ $bgNewColor }} hover:text-slate-600 transition duration-1000 ease-in-out"
                title="Create New Contact">new contact</a>
        </div>
    </div>

    <div class="overflow-hidden py-2 bg-zinc-200">

            <!-- FILTERS-->
            <div class="flex flex-col {{ $bgFilterColor }} mx-auto">
                
                <div class="flex flex-row justify-between items-center w-full text-white">
                    <span class="capitalize text-lg px-2">
                        <a wire:click="activateFilter" class="cursor-pointer" title="{{($showFilters % 2 != 0) ? 'Close Filters' : 'Open Filters'}}">filters</a>
                    </span>
                    <!-- Open/Close Buttons -->
                    <div class="p-2">
                        @if ($showFilters % 2 != 0)
                            <a wire:click="activateFilter" class="cursor-pointer" title="Close Filters">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @else
                            <a wire:click="activateFilter" class="cursor-pointer" title="Open Filters">
                                <i class="fa-solid fa-caret-down"></i>
                            </a>
                        @endif
                    </div>
                </div>

                @if ($showFilters % 2 != 0)
                <!-- Filters Options -->    
                <div class="flex flex-col bg-zinc-200 opacity-95 py-2">

                    <!-- 2 ROW FILTER -->
                    <div class="flex flex-col md:flex-row p-1 my-1">                        

                        <!-- Type -->
                        <div class="flex flex-row justify-between w-full md:w-1/2 my-2 md:my-0">
                                
                            <div class="w-5/12 px-1">
                                <span><i class="fa fa-address-book"></i></span>
                                <span class="{{$filterType}}">Type <span
                                    class="text-xs">({{ $types->count() }})</span></span>                            
                            </div>                        
                            <div class="flex flex-row w-6/12 justify-end">                            
                                <select wire:model.live="typ" class="w-full rounded-sm bg-gray-100 text-end text-green-800 cursor-pointer">
                                    <option value="0">All</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->type }}">{{ $type->type }}</option>
                                @endforeach
                                </select>
                                                            
                            </div>
                            <div class="w-1/12">
                            @if ($typ != 0)
                                <a wire:click.prevent="clearFilterType" title="Reset Filter Type" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-1"><i
                                            class="fa-solid fa-circle-xmark"></i></span>
                                </a>
                            @endif
                            </div>

                        </div>                
                
                    </div>
                
                </div> 
                @endif

            </div>   

            <!-- SEARCH -->
            <div class="flex flex-col {{ $bgSearchColor }} mx-auto my-2 text-black">

                <div class="flex flex-row justify-between items-center w-full text-white">
                    <span class="capitalize text-lg px-2">
                        <a wire:click="activateSearch" class="cursor-pointer" title="{{($showSearch % 2 != 0) ? 'Close Search' : 'Open Search'}}">search</a>
                    </span>
                    <!-- Open/Close Buttons -->
                    <div class="p-2">
                        @if ($showSearch % 2 != 0)
                            <a wire:click="activateSearch" class="cursor-pointer" title="Close Search">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @else
                            <a wire:click="activateSearch" class="cursor-pointer" title="Open Search">
                                <i class="fa-solid fa-caret-down"></i>
                            </a>
                        @endif
                    </div>
                </div>                            

                @if ($showSearch % 2 != 0)

                <div class="flex flex-col bg-zinc-200 pt-1 pb-6 my-0">

                    <div class="flex flex-wrap md:flex-row justify-start items-start gap-2 text-sm w-full mb-0">
                        <div class="flex flex-row p-2 ml-2 items-center gap-2">
                            <i class="fa-solid fa-user"></i>
                            <span class="capitalize">first name</span>    
                            <input type="radio" wire:model.live="searchType" value="first_name" class="cursor-pointer">
                        </div>
                        <div class="flex flex-row p-2 ml-2 items-center gap-2">
                            <i class="fa-solid fa-people-group"></i>
                            <span class="capitalize">last name</span>    
                            <input type="radio" wire:model.live="searchType" value="last_name" class="cursor-pointer">
                        </div>
                        <div class="flex flex-row p-2 items-center gap-2">
                            <i class="fa-solid fa-mobile"></i>
                            <span class="capitalize">phone</span>    
                            <input type="radio" wire:model.live="searchType" value="phone" class="cursor-pointer">
                        </div>
                        <div class="flex flex-row p-2 items-center gap-2">
                            <i class="fa-solid fa-at"></i>
                            <span class="capitalize">email</span>    
                            <input type="radio" wire:model.live="searchType" value="email" class="cursor-pointer">
                        </div>         
                    </div>
                    <!-- Search Word -->
                    <div class="relative w-full px-4">
                        <div class="absolute top-1 bottom-0 left-5 text-gray-600">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input wire:model.live="search" type="search"
                            class="w-full bg-gray-100 rounded-sm pl-8 py-1 text-zinc-800 text-sm placeholder-zinc-800 focus:outline-none focus:ring-0 focus:border-zinc-600 border-2 border-zinc-800"
                            placeholder="Search by {{ ($searchType == 'balances.name') ? 'account' : $searchType }}">
                        @if ($search != '')
                        <div class="absolute top-1 bottom-0 right-5 text-slate-700">
                            <a wire:click.prevent="clearSearch" title="Clear Search" class="cursor-pointer">
                                <span class="{{ $iconClose }} hover:text-red-400">
                                    <i class="fa-sm fa-solid fa-xmark"></i>
                                </span>
                            </a>
                        </div>
                        @endif
                    </div>

                </div>

                @endif

            </div>

            
            <!-- CRITERIA -->                                 
                
            <div class="flex flex-col my-2">
                                
                <!-- HEADER - Filters and Search Criteria -->
                <div class="flex flex-row justify-between items-center p-2 text-white {{(count($criteria) > 0) ? $bgCriteriaColorOn : $bgCriteriaColorOff }}">
                    <span class="text-lg capitalize">filters & search criteria</span>
                    <!-- Clear ALL Criteria for search and filters -->
                    @if (count($criteria) > 0)
                        <div>
                            <a wire:click.prevent="resetAll" title="Clear all filters">
                                <i class="fa-solid fa-xmark cursor-pointer"></i>
                            </a>
                        </div>
                    @endif
                </div>
                               
                
                    <!-- Filters and Search Criteria -->
                    <div class="flex flex-col bg-zinc-200 py-0 my-0">

                        @if (count($criteria) > 0)

                            <div class="flex flex-wrap text-white text-xs capitalize w-full p-2 gap-3 sm:gap-4">
                                <!-- Search -->
                                @if ($search != '')
                                    <div class="flex relative">                                
                                        <div
                                            class="{{$bgSearchColor}} p-2 rounded-sm border-1 border-blue-600">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <span class="uppercase font-bold">search</span>
                                            <span>({{ $criteria['searchType'] }})</span>
                                        </div>
                                        <a wire:click.prevent="clearSearch" title="Clear Search" class="cursor-pointer">
                                            <span class="{{ $iconClose }} px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>
                                @endif   
                                <!-- Type -->
                                @if ($typ != 0)
                                    <div class="flex relative">                                
                                        <div
                                            class="{{ $criteriaType }} p-2 rounded-sm border-1 border-green-600">
                                            <i class="fa-solid fa-address-book"></i>
                                            <span class="uppercase font-bold">type</span>
                                            <span>({{ $criteria['type'] }})</span>
                                        </div>
                                        <a wire:click.prevent="clearFilterType" title="Clear Filter Type" class="cursor-pointer">
                                            <span class="text-red-600 hover:text-red-500 px-2 absolute -top-2 -right-5"><i
                                                    class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                        </a>
                                    </div>                            
                                @endif                                            

                            </div>
                        
                        @else

                            <span class="font-normal text-sm italic p-2">No filters or search active.</span>

                        @endif
                    
                    </div>

            </div>


            <!-- TABLE CONTACTS HEADER AND BULK ACTIONS -->
            @if($total > 0)

                <div class="flex flex-row justify-between md:items-end {{ $bgMenuColor }} text-white mt-4">

                    <!-- Contacts Found -->
                    <div class="p-2">
                        <span class="text-lg">Contacts Found ({{ $search != '' ? $found : $total }})</span>
                    </div>       
                    
                    <!-- Pagination -->
                    <div class="flex flex-row justify-center items-center p-2 gap-4">
                        
                        <i class="fa-solid fa-book-open" title="Pagination"></i>
                        <select wire:model.live="perPage"
                            class="w-full bg-gray-200 rounded-sm text-black text-end focus:outline-none focus:ring-0 focus:border-gray-400 border-2 border-zinc-200 "
                            title="Contacts per Page">
                            <option value="3">3</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>

                    </div>
                    
                </div>  

                <!-- TABLE INFO / FONT / EXPORT ALL / BULK ACTIONS -->
                <div class="flex flex-col justify-between p-2 text-xs bg-zinc-200">

                    <!-- TABLE INFO / FONT / EXPORT ALL -->
                    <div class="flex flex-row">                    

                        <!-- TABLE INFO / FONT -->
                        <div class="flex flex-col w-full">
                            <div class="flex flex-col md:flex-row justify-start gap-0 md:gap-7">
                                <div class="flex flex-row gap-5 md:gap-5">
                                    <span class="capitalize font-bold">table info</span>
                                    @if($smallView)                                
                                        <a wire:click="activateSmallView({{0}})" 
                                            class="hover:text-green-600 transition duration-1000 ease-in-out cursor-pointer"
                                            title="See more Info"> 
                                            <span class="px-1">more</span><i class="fa-solid fa-up-right-and-down-left-from-center"></i>                            
                                        </a>                               
                                            @else                                    
                                            <a wire:click="activateSmallView({{1}})" 
                                                class="hover:text-green-600 transition duration-1000 ease-in-out cursor-pointer"
                                                title="See less Info">
                                                <span class="px-1">less</span><i class="fa-solid fa-down-left-and-up-right-to-center"></i>                           
                                            </a> 
                                    @endif
                                </div>
                                <div class="flex flex-row gap-5 md:gap-5">
                                    <span class="capitalize font-bold">table font</span>
                                    @if($smallFont)
                                            <a wire:click="activateSmallFont({{0}})" 
                                                class="hover:text-green-600 transition duration-1000 ease-in-out cursor-pointer"
                                                title="Big Font"> 
                                                <span class="px-0">big</span><i class="fa-lg fa-solid fa-a"></i>                            
                                            </a>
                                            @else
                                                <a wire:click="activateSmallFont({{1}})" 
                                                    class="hover:text-green-600 transition duration-1000 ease-in-out cursor-pointer"
                                                    title="Small Font">
                                                    <span class="px-0">small</span><i class="fa-solid fa-a"></i>                           
                                                </a>
                                        @endif
                                </div>    
                            </div>
                        </div>
                        <!-- EXPORT ALL -->
                        

                    </div>    

                    <!-- BULK ACTIONS -->
                    <div class="flex flex-row justify-between md:justify-start py-2 gap-2">
                        @if (count($okselections) > 0)

                            <div class="flex flex-row gap-2">                            
                                <span class="font-bold capitalize">bulk actions </span>
                                <span>selected ({{ count($okselections) }})</span>
                            </div>

                            <div class="flex flex-row gap-2">                            
                                <!-- Unselect -->
                                <a wire:click.prevent="bulkClear" class="cursor-pointer" title="Unselect Entries">
                                    <i class="fa-solid fa-rotate-right {{ $iconUnselect }}"></i>
                                </a>
                                <!-- Delete -->
                                <a wire:click.prevent="bulkDelete" wire:confirm="Are you sure you want to delete this contacts?"
                                    class="cursor-pointer" title="Delete Selected">
                                    <i class="fa-solid fa-trash {{ $iconDelete }}"></i>
                                </a>
                                <!-- Export Excel -->
                                
                            </div> 
                                
                            @else
                                <div class="flex flex-row gap-2">
                                    <span class="font-bold capitalize">Bulk actions</span>
                                    <span class="italic text-xs font-normal"> no selections</span>
                                </div>
                            @endif
                    </div>


                </div>
                      

            @endif
               
            @if ($entries->count())
            <!-- TABLE -->
            <div class="{{ $bgMenuColor }} text-white my-0">
                <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <!-- TABLE HEADER -->
                            <thead>
                                <tr class="text-left text-sm font-normal capitalize">
                                    <th></th>                                    
                                    <th wire:click="sorting('id')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'id' ? $tableHeaderSelected : '' }}">
                                        id {!! $sortLink !!}</th>                                    
                                    <th wire:click="sorting('first_name')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'first_name' ? $tableHeaderSelected : '' }}">
                                        First Name {!! $sortLink !!}</th>                                    
                                    <th wire:click="sorting('last_name')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'last_name' ? $tableHeaderSelected : '' }}">
                                        Last Name {!! $sortLink !!}</th>
                                    <th wire:click="sorting('phone')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'phone' ? $tableHeaderSelected : '' }}">
                                        phone {!! $sortLink !!}</th>
                                    <th wire:click="sorting('email')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'email' ? $tableHeaderSelected : '' }}">
                                        email {!! $sortLink !!}</th>
                                    <th wire:click="sorting('birthdate')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'birthdate' ? $tableHeaderSelected : '' }}">
                                        birthdate {!! $sortLink !!}</th> 
                                    @if(!$smallView)
                                    <th wire:click="sorting('address')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'address' ? $tableHeaderSelected : '' }}">
                                        address {!! $sortLink !!}</th>
                                    <th wire:click="sorting('city')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'city' ? $tableHeaderSelected : '' }}">
                                        city {!! $sortLink !!}</th>                                    
                                    <th wire:click="sorting('location')" scope="col"
                                        class="p-2 hover:cursor-pointer {{ $column == 'location' ? $tableHeaderSelected : '' }}">
                                        location {!! $sortLink !!}</th>                                                                                                          
                                    @endif                                                                       
                                    <th scope="col" class="p-2 text-center">actions</th>
                                </tr>
                            </thead>
                            <!-- TABLE BODY -->
                            <tbody>
                                @foreach ($entries as $entry)
                                    <tr
                                        class="text-black {{$smallFont ? 'text-xs' : 'text-sm'}} leading-6 {{in_array($entry->id, $okselections) ? $tableSelected : 'even:bg-zinc-100 odd:bg-zinc-50'}} transition-all duration-1000 {{ $tableHighlight }}">
                                                
                                        <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ intval($entry->id) }} 
                                                id={{ $entry->id }}
                                                {{ in_array($entry->id, $selections) ? 'checked' : '' }}
                                                >
                                        </td>
                                        <td class="p-2 pr-12 {{ $column == 'id' ? $tableCellSelected : '' }}">{{ $entry->id }}</td>                                       
                                        <td class="p-2 pr-12 {{ $column == 'first_name' ? $tableCellSelected : '' }}">{{ $entry->first_name }}</td>                                       
                                        <td class="p-2 pr-12 {{ $column == 'last_name' ? $tableCellSelected : '' }}">{{ $entry->last_name }}</td>                                       
                                        <td class="p-2 pr-12 {{ $column == 'phone' ? $tableCellSelected : '' }}">{{ $entry->phone }}</td>                                       
                                        <td class="p-2 pr-12 {{ $column == 'email' ? $tableCellSelected : '' }}">{{ $entry->email }}</td>                                       
                                        <td class="p-2 pr-16 {{ $column == 'birthdate' ? $tableCellSelected : '' }}">{{ !empty($entry->birthdate) ? date('d-m-Y', strtotime($entry->birthdate)) : '-' }}</td>
                                                                                                                  
                                        @if(!$smallView)
                                        <td class="p-2 pr-12 {{ $column == 'address' ? $tableCellSelected : '' }}">{{ !empty($entry->address) ? $entry->address : '-' }}</td>
                                        <td class="p-2 pr-12 {{ $column == 'city' ? $tableCellSelected : '' }}">{{ !empty($entry->city) ? $entry->city : '-' }}</td>
                                        <td class="p-2 pr-16 {{ $column == 'location' ? $tableCellSelected : '' }}">{{ !empty($entry->location) ? $entry->location : '-' }}</td>
                                        @endif   
                                        
                                        
                                        <!-- ACTIONS --> 
                                        <td class="p-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <!-- Show -->
                                                <a href="{{ route('contacts.show', $entry) }}" title="Show">
                                                    <i
                                                        class="fa-solid fa-circle-info {{ $iconShow}} hover:text-slate-800 transition duration-1000 ease-in-out"></i>
                                                </a>                                                
                                                <!-- Edit -->
                                                <a href="{{ route('contacts.edit', $entry) }}" title="Edit">                                                    
                                                    <i
                                                        class="fa-solid fa-pen-to-square {{ $iconEdit}} hover:text-slate-800 transition duration-1000 ease-in-out"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form action="{{ route('contacts.destroy', $entry) }}" method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Are you sure you want to delete the contact: {{ $entry->first_name }}?')"
                                                        title="Delete this contact"
                                                        class="cursor-pointer">                                                        
                                                        <i
                                                            class="fa-solid fa-trash {{ $iconDelete}} hover:text-slate-800 transition-all duration-500 cursor-pointer"></i>
                                                    </button>
                                                </form>                                              
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                </div>

            </div>
            @else
                <div
                    class="flex flex-row justify-between items-center bg-black text-white rounded-sm w-full mx-auto p-4">
                    <span>No entries found in the system.</span>
                    <a wire:click.prevent="resetAll" title="Reset">
                        <i
                            class="fa-lg fa-solid fa-circle-xmark cursor-pointer px-2 {{ $iconClose }} transition duration-1000 ease-in-out"></i>
                    </a>
                    </span>
                </div>            
            @endif       


            <!-- Pagination Links -->
            <div class="py-2 px-4">
                {{ $entries->links() }}
            </div>

            <!-- To the Top Button -->
            <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                    class="fa-solid fa-angle-up"></i></button>                    

    </div>

    <!-- Footer -->
    <div class="flex flex-row justify-center items-center p-2 mt-4 {{ $bgMenuColor }} rounded-sm">
        <span class="font-bold text-xs text-white">xavulankis 2025</span>
    </div>

</div>




