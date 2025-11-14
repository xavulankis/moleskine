<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-col bg-green-600 p-1 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('message') }}</span>
                <a href="/entries/show/{{ $entry->id }}" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex flex-col bg-red-600 p-1 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('error') }}</span>
                <a href="/entries/show/{{ $entry->id }}" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 p-1 text-sm text-slate-600">
        <a href="/entries" class="hover:text-black">Entries</a> /
        <a href="/entries/show/{{ $entry->id }}" class="font-bold text-black border-b-2 border-b-orange-600">Info</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">
                
        <!-- Header -->
        <div class="flex flex-row text-white font-bold uppercase p-2 bg-amber-600">
            <span>information</span>
        </div>
        <!-- Actions -->
        <div class="flex flex-row w-11/12 mx-auto justify-end items-center p-2 gap-2 border-b-1 border-b-zinc-400">
                                            
                <!-- PDF -->
                <a href="{{ route('entries_pdf.generate', $entry) }}" title="Download as PDF">
                    <i
                        class="fa-solid fa-file-pdf hover:text-amber-600 transition-all duration-500"></i>
                </a>
                <!-- Edit -->
                <a href="{{ route('entries.edit', $entry) }}" title="Edit">
                    <i class="fa-solid fa-pencil hover:text-green-600 transition-all duration-500"></i>
                </a>
                <!-- Delete -->
                <form action="{{ route('entries.destroy', $entry) }}" method="POST">
                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                    @csrf
                    <!-- Dirtective to Override the http method -->
                    @method('DELETE')
                    <button
                        onclick="return confirm('Are you sure you want to delete this entry')"
                        title="Delete">
                        <i
                            class="fa-solid fa-trash hover:text-red-600 transition-all duration-500 cursor-pointer"></i>
                    </button>
                </form>
            
        </div>


        <!-- INFO -->
        <div class="mx-auto w-11/12 mt-4 pb-4 rounded-sm flex flex-col gap-2">

            <!-- Id -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-fingerprint"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">id</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span class="w-full md:w-40 rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">{{$entry->id}}</span>
                </div>

            </div>  

            <!-- Date -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">date</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        {{ $entry->date }}</span>
                </div>

            </div>
            
            <!-- Title -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-pen"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">title</span>
                    </div>
                    <div class="flex flex-row justify-start items-center p-2 md:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Title">
                            <button class="btn" data-clipboard-target="#title" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Title">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <span x-show="show" class="absolute -top-8 -right-6">
                                <span class="bg-green-600 text-white text-xs rounded-lg p-1 opacity-90">Copied!</span>
                            </span>
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-row justify-between items-center w-full">

                    <div class="flex flex-row p-2 bg-zinc-100 w-full">
                        <span 
                        id="title">
                        {{ $entry->title }}</span>
                    </div>

                    <div class="flex flex-row justify-start items-center p-2 max-sm:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Title">
                            <button class="btn cursor-pointer" data-clipboard-target="#title" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Title">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <span x-show="show" class="absolute -top-8 -right-6">
                                <span class="bg-green-600 text-white text-xs rounded-lg p-1 opacity-90">Copied!</span>
                            </span>
                        </span>
                    </div>

                </div>

            </div>

            <!-- Category -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">category</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span class="bg-indigo-600 text-white font-semibold p-2 rounded-sm">{{ $entry->category->name }}</span>
                </div>                

            </div>

            <!-- Tags -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-tags"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">tags</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <div 
                        class="flex flex-wrap gap-2">
                        @foreach ($entry->tags as $tag)
                            <span class="bg-teal-500 text-white font-semibold p-2 rounded-sm">{{ $tag->name }}</span>
                        @endforeach    
                    </div>
                </div>

            </div> 

            <!-- Description -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-align-left"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">description</span>
                    </div>
                    <div class="flex flex-row justify-start items-center p-2 md:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Description">
                            <button class="btn" data-clipboard-target="#description" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Description">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <span x-show="show" class="absolute -top-8 -right-6">
                                <span class="bg-green-600 text-white text-xs rounded-lg p-1 opacity-90">Copied!</span>
                            </span>
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-row justify-between items-center w-full">

                    <div class="flex flex-row p-2 bg-zinc-100 w-full">
                        <span 
                        id="description">
                        {{ $entry->description }}</span>
                    </div>

                    <div class="flex flex-row justify-start items-center p-2 max-sm:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Description">
                            <button class="btn cursor-pointer" data-clipboard-target="#description" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Description">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <span x-show="show" class="absolute -top-8 -right-6">
                                <span class="bg-green-600 text-white text-xs rounded-lg p-1 opacity-90">Copied!</span>
                            </span>
                        </span>
                    </div>

                </div>

            </div>

            <!-- URL -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-link"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">url</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($entry->url))  
                            <span> <a href="{{$entry->url}}" target="_blank" title="Open"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- Place -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">place</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($entry->place))  
                            <span> {{ $entry->place}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- Autor -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">autor</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($entry->autor))  
                            <span> {{ $entry->autor}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- Value -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-eur"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">value</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($entry->value))  
                            <span> {{ $entry->value}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>                  

            <!-- Info -->
            <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-info"></i>
                    </div>                    
                    <div class="w-full">
                            <span class="text-lg font-semibold capitalize">information</span>
                        </div>
                    @if (strip_tags($entry->info) != '')
                    <div class="flex flex-row justify-start items-center p-2 md:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Info">
                            <button class="btn" data-clipboard-target="#info" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Info">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <span x-show="show" class="absolute -top-8 -right-6">
                                <span class="bg-green-600 text-white text-xs rounded-lg p-1 opacity-90">Copied!</span>
                            </span>
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="flex flex-row justify-between items-center w-full">

                    @if (strip_tags($entry->info) != '')
                        <div class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                            <span class="text-md" id="info">{!! $entry->info !!}</span>
                        </div>

                        <div class="flex flex-row justify-start items-start p-2 max-sm:hidden">
                            <span x-data="{ show: false }" class="relative" data-tooltip="Copy Info">
                                <button class="btn cursor-pointer" data-clipboard-target="#info" x-on:click="show = true"
                                    x-on:mouseout="show = false" title="Copy Info">
                                    <i class="fa-solid fa-copy"></i>
                                </button>
                                <span x-show="show" class="absolute -top-8 -right-6">
                                    <span class="bg-green-600 text-white text-xs rounded-lg p-1 opacity-90">Copied!</span>
                                </span>
                            </span>
                        </div>
                    @else
                        <div class="p-2">-</div>
                    @endif

                </div>

            </div>

            <!-- Files -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2 h-full">
                        <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-file"></i>
                    </div>                    
                    <div class="w-full h-full">
                        <span class="text-lg font-semibold capitalize">Files ({{ $entry->files->count() }})</span>
                    </div>                    
                </div>
                
                <div class="flex flex-col justify-start items-center w-full">
                    
                    @if ($entry->files->count() > 0)
                        <!-- FILES TABLE -->
                        <div class="w-full overflow-x-auto">
                        
                            <table class="table-auto w-full border text-sm">
                                <thead class="text-sm text-center text-white bg-black">
                                    <th></th>
                                    <th class="p-2 max-lg:hidden">Filename</th>
                                    <th class="p-2 max-sm:hidden">Created</th>
                                    <th class="p-2 max-sm:hidden">Size <span class="text-xs">(KB)</span></th>
                                    <th class="p-2">Format</th>
                                    <th></th>
                                </thead>

                                @foreach ($entry->files as $file)
                                    <tr class="bg-white border-b text-center">
                                        <td class="p-2">
                                            @include('partials.mediatypes-file', [
                                                'file' => $file,
                                                'iconSize' => 'fa-lg',
                                                'imagesBig' => false,
                                            ])
                                        </td>
                                        <td class="p-2 max-lg:hidden">
                                            {{ $file->original_filename }}
                                        </td>
                                        <td class="p-2 max-sm:hidden">{{ $file->created_at->format('d-m-Y') }}
                                        </td>
                                        <td class="p-2 max-sm:hidden">{{ round($file->size / 1000) }} </td>
                                        <td class="p-2 ">{{ basename($file->media_type) }}</td>
                                        <td class="p-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <!-- Download file -->
                                                
                                                <!-- Delete file -->
                                                <form action="{{ route('files.destroy', [$entry, $file]) }}"
                                                    method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Are you sure you want to delete the file: {{ $file->original_filename }}?')"
                                                        title="Delete file">
                                                        <span
                                                            class="text-red-600 hover:text-red-500 transition-all duration-500 cursor-pointer"><i
                                                                class="fa-lg fa-solid fa-trash"></i></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    @endif

                        <div class="flex flex-row py-2 w-full">
                            @if ($entry->files->count() >= 5)
                                <div class="flex flex-row text-red-600 text-sm italic p-2 ">
                                    <span>Max files (5) reached. Delete some if you want to upload a new File.</span>
                                </div>                
                            @else
                                <!-- Upload file -->
                                <div class="flex flex-col gap-2 w-full">
                                    <div class="flex flex-row text-sm px-2">
                                    @if($entry->files->count() == 0)                                    
                                        <span>No files for this entry</span>                                    
                                    @else
                                        <span>Max files (5). You still can upload {{5 - $entry->files->count()}} more files.</span>        
                                    @endif
                                    </div>
                                    <div class="flex flex-row w-full">
                                        <a href="{{ route('files.upload', $entry) }}"
                                            class="w-full sm:w-1/4 p-2 rounded-sm text-white text-sm text-center bg-black hover:bg-slate-800 transition-all duration-500">
                                            <span class="font-bold uppercase font-bold"> Upload File</span>
                                            <span class="px-2"><i class="fa-solid fa-file-arrow-up"></i></span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                </div>

            </div>

        </div>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa-solid fa-angle-up"></i></button>

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-amber-600 rounded-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>        

    </div>    

</div>

<script>
    new ClipboardJS('.btn');
</script>
