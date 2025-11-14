<div class="w-full sm:max-w-10/12 mx-auto">
    
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 p-1 text-sm text-slate-600">
        <a href="/archive" class="hover:text-black">Archive</a> /
        <a href="/archive/show/{{ $archive->id }}" class="font-bold text-black border-b-2 border-b-orange-600">Info</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">
                
        <!-- Header -->
        <div class="flex flex-row text-white font-bold uppercase p-2 bg-amber-600">
            <span>information (archived)</span>
        </div>
        <!-- Actions -->
        <div class="flex flex-row w-11/12 mx-auto justify-end items-center p-2 gap-2 border-b-1 border-b-zinc-400">
                                            
                <!-- PDF -->
                <a href="#" title="Download as PDF">
                    <i
                        class="fa-solid fa-file-pdf hover:text-amber-600 transition-all duration-500"></i>
                </a>
                <!-- Restore -->
                 <form action="{{ route('archive.restore', $archive->id) }}" method="POST">
                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                    @csrf
                    <!-- Dirtective to Override the http method -->
                    @method('PUT')
                        <button     
                            onclick="return confirm('Entry with (ID: {{  $archive->id }}) will be restored')"                                                   
                            title="Restore">                                                        
                            <i
                            class="fa-solid fa-rotate-right hover:text-green-600 transition-all duration-500 cursor-pointer"></i>
                        </button>
                </form>
                <!-- Delete -->
                <form action="{{ route('archive.destroy', $archive->id) }}" method="POST">
                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                    @csrf
                    <!-- Dirtective to Override the http method -->
                    @method('DELETE')
                        <button
                            onclick="return confirm('Delete PERMANENTLY Entry with (ID: {{  $archive->id }})?')"                                                        
                            title="Delete PERMANENTLY">                                                        
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
                    <span class="w-full md:w-40 rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">{{$archive->id}}</span>
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
                        {{ $archive->date }}</span>
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
                        {{ $archive->title }}</span>
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
                    <span class="bg-indigo-600 text-white font-semibold p-2 rounded-sm">{{ $archive->category->name }}</span>
                </div>                

            </div>

            <!-- Tags -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">tags</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <div 
                        class="flex flex-wrap gap-2">
                        @foreach ($archive->tags as $tag)
                            <span class="bg-teal-500 text-white font-semibold p-2 rounded-sm">{{ $tag->name }}</span>
                        @endforeach    
                    </div>
                </div>

            </div> 

            <!-- Description -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-money-bill"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">description</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($archive->description))  
                            <span> {{ $archive->description}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>     
            
            <!-- URL -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-pen"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">url</span>
                    </div>
                    <div class="flex flex-row justify-start items-center p-2 md:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Url">
                            <button class="btn" data-clipboard-target="#url" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Url">
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
                        id="url">
                        {{ $archive->url }}</span>
                    </div>

                    <div class="flex flex-row justify-start items-center p-2 max-sm:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Url">
                            <button class="btn cursor-pointer" data-clipboard-target="#url" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Url">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <span x-show="show" class="absolute -top-8 -right-6">
                                <span class="bg-green-600 text-white text-xs rounded-lg p-1 opacity-90">Copied!</span>
                            </span>
                        </span>
                    </div>

                </div>

            </div>                           

            <!-- Place -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-money-bill"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">place</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($archive->place))  
                            <span> {{ $archive->place}}</span>
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
                        <i class="fa-solid fa-money-bill"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">autor</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($archive->autor))  
                            <span> {{ $archive->autor}}</span>
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
                        <i class="fa-solid fa-money-bill"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">value</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($archive->value))  
                            <span> {{ $archive->value}}</span>
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
                            <span class="text-lg font-semibold capitalize">extra information</span>
                        </div>
                    @if (strip_tags($archive->info) != '')
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

                    @if (strip_tags($archive->info) != '')
                        <div class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                            <span class="text-md" id="info">{!! $archive->info !!}</span>
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
                        <span class="text-lg font-semibold capitalize">Files ({{ $archive->files->count() }})</span>
                    </div>                    
                </div>
                
                <div class="flex flex-col justify-start items-center w-full">
                    
                    @if ($archive->files->count() > 0)
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

                                @foreach ($archive->files as $file)
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
                                                
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    @endif
                       

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

