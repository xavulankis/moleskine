<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-col bg-green-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('message') }}</span>
                <a href="/categories/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex flex-col bg-red-600 p-1 mb-2 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('error') }}</span>
                <a href="/categories/" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-row justify-between items-center gap-2 p-2 font-bold uppercase bg-black text-white rounded-sm">
        
        <div>
            <a href="/categories" class="border-b-2 border-b-yellow-400">categories</a> 
        </div>

        <div>
            <a href="{{route('categories.create')}}"
                class="capitalize text-white text-sm rounded-sm p-1 bg-blue-600 text-black hover:text-white transition duration-1000 ease-in-out"
                title="Create New Account">new</a>
        </div>
    </div>
    
    <!-- MAIN -->
    <div class="overflow-hidden py-2 bg-zinc-200">

        <!-- SEARCH -->
        <div class="flex flex-col bg-blue-800 mx-auto my-2">

            <div class="flex flex-row justify-between items-center w-full text-white">
                <span class="capitalize text-lg p-2">search</span>                    
            </div>


            <div class="flex flex-col bg-zinc-200 py-2">
                
                <!-- Search Word -->
                <div class="relative w-full px-4">
                    <div class="absolute top-1 bottom-0 left-5 text-gray-600">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input wire:model.live="search" type="search"
                        class="w-full bg-gray-100 rounded-sm pl-8 py-1 text-zinc-800 text-sm placeholder-zinc-800 focus:outline-none focus:ring-0 focus:border-zinc-600 border-2 border-zinc-800"
                        placeholder="Search by name">
                    @if ($search != '')
                    <div class="absolute top-1 bottom-0 right-5 text-slate-700">
                        <a wire:click.prevent="clearSearch" title="Clear Search" class="cursor-pointer">
                            <span class="text-red-600 hover:text-red-400">
                                <i class="fa-sm fa-solid fa-xmark"></i>
                            </span>
                        </a>
                    </div>
                    @endif
                </div>

            </div>

        </div>

        <!-- Category Info -->
        <div class="flex flex-row justify-between md:items-end bg-slate-900 text-white mt-4">

                <!-- Category Found -->
                <div class="p-2">
                    <span class="text-lg">Categories Found ({{ $total }})</span>
                </div>       
                
                <!-- Pagination -->
                <div class="flex flex-row justify-center items-center p-2 gap-4">
                    
                    <i class="fa-solid fa-book-open" title="Pagination"></i>
                    <select wire:model.live="perPage"
                        class="w-full bg-gray-200 rounded-sm text-black text-end focus:outline-none focus:ring-0 focus:border-gray-400 border-2 border-zinc-200 "
                        title="Entries per Page">
                        <option value="3">3</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                </div>
                
        </div>

        <!-- Bulk Actions -->
        <div class="flex flex-row justify-between md:justify-start text-sm p-2 gap-2">
            @if (count($okselections) > 0)
                    
                    <div class="flex flex-row gap-2">                            
                        <span class="font-bold capitalize">bulk actions </span>
                        <span>selected ({{ count($okselections) }})</span>
                    </div>

                    <div class="flex flex-row gap-2">                            
                        <a wire:click.prevent="bulkClear" class="cursor-pointer" title="Unselect Entries">
                            <i class="fa-solid fa-rotate-right text-blue-600"></i>
                        </a>
                                            
                        <a wire:click.prevent="bulkDelete" wire:confirm="Are you sure you want to delete this items?"
                            class="cursor-pointer" title="Delete Selected">
                            <i class="fa-solid fa-trash text-red-600"></i>
                        </a>
                    </div>                                                    

            @else
                <div class="flex flex-row gap-2">
                    <span class="font-bold capitalize">Bulk actions</span>
                    <span>no selections</span>
                </div>
            @endif
        </div>

            
        @if ($categories->count())    
            <!-- TABLE -->
            <div class="bg-black text-white my-0">
                <div class="overflow-x-auto">
                    
                    <table class="min-w-full ">
                        <!-- TABLE HEADER -->
                        <thead>
                                <tr class="text-left text-sm font-normal capitalize">
                                <th></th>
                                <th wire:click="sorting('id')" scope="col"
                                    class="p-2 hover:cursor-pointer {{ $column == 'id' ? 'text-yellow-600' : '' }}">
                                    id {!! $sortLink !!}</th>
                                <th wire:click="sorting('name')" scope="col"
                                    class="p-2 hover:cursor-pointer {{ $column == 'name' ? 'text-yellow-600' : '' }}">
                                    name {!! $sortLink !!}</th>
                                <th wire:click="sorting('created_at')" scope="col"
                                    class="p-2 hover:cursor-pointer {{ $column == 'created_at' ? 'text-yellow-600' : '' }}">
                                    created {!! $sortLink !!}</th>
                                <th wire:click="sorting('updated_at')" scope="col"
                                    class="p-2 hover:cursor-pointer {{ $column == 'updated_at' ? 'text-yellow-600' : '' }}">
                                    updated {!! $sortLink !!}</th>
                                <th scope="col" class="p-2 text-center capitalize">actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($categories as $category)
                                <tr
                                    class="text-black text-sm leading-6 {{in_array($category->id, $okselections) ? 'bg-green-200' : 'even:bg-zinc-100 odd:bg-zinc-50'}} transition-all duration-1000 hover:bg-yellow-200">                                        
                                    <td class="p-2 text-center"><input wire:model.live="selections" type="checkbox"
                                            class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                            value={{ $category->id }}
                                            id={{ $category->id }}
                                            {{ in_array($category->id, $selections) ? 'checked' : '' }}
                                            ></td>
                                    <td class="p-2 {{ $column == 'id' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ $category->id }}</td>
                                    <td class="p-2 {{ $column == 'name' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}"> <a
                                            href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                                    </td>
                                    <td class="p-2 {{ $column == 'created_at' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ date('d-m-Y', strtotime($category->created_at)) }}</td>
                                    <td class="p-2 {{ $column == 'updated_at' ? 'bg-yellow-300 font-bold text-black transition-all duration-1000' : '' }}">{{ date('d-m-Y', strtotime($category->updated_at)) }}</td>
                                    
                                    <td class="p-2">
                                        <div class="flex justify-center items-center gap-2">
                                            <!-- Show -->
                                            <a href="{{ route('categories.show', $category) }}" title="Show">
                                                <i
                                                    class="fa-solid fa-circle-info text-amber-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                            </a>
                                            <!-- Edit -->
                                            <a href="{{ route('categories.edit', $category) }}" title="Edit">
                                                
                                                <i
                                                    class="fa-solid fa-pen-to-square text-green-600 hover:text-black transition duration-1000 ease-in-out"></i>
                                            </a>
                                            <!-- Delete -->
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                @csrf
                                                <!-- Dirtective to Override the http method -->
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Are you sure you want to delete the category: {{ $category->name }}?')"
                                                    title="Delete">                                                        
                                                    <i
                                                        class="fa-solid fa-trash text-red-600 hover:text-black transition duration-1000 ease-in-out"></i>
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
                class="flex flex-row justify-between items-center bg-black text-white rounded-lg p-4 mx-2 sm:mx-0">
                <span>No categories found in the system.</span>
                <a wire:click.prevent="clearSearch" title="Reset">
                    <i
                        class="fa-lg fa-solid fa-circle-xmark cursor-pointer px-2 text-red-600 hover:text-red-400 transition duration-1000 ease-in-out"></i>
                </a>
                </span>
            </div>
        @endif

                
        <!-- Pagination Links -->
        <div class="py-2 px-4">
            {{ $categories->links() }}
        </div>

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-black rounded-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>        

    </div>

</div>


