<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-col bg-green-600 p-1 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('message') }}</span>
                <a href="/contacts/show/{{ $contact->id }}" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex flex-col bg-red-600 p-1 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('error') }}</span>
                <a href="/contacts/show/{{ $contact->id }}" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 p-1 text-sm text-slate-600">
        <a href="/contacts" class="hover:text-black">Contacts</a> /
        <a href="/contacts/show/{{ $contact->id }}" class="font-bold text-black {{ $underlineMenu }}">Info</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">
                
        <!-- Header -->
        <div class="flex flex-row text-white font-bold uppercase p-2 {{ $bgMenuColor }}">
            <span>information</span>
        </div>
        <!-- Actions -->
        <div class="flex flex-row w-11/12 mx-auto justify-end items-center p-2 gap-2 border-b-1 border-b-slate-800">                
                                            
                <!-- PDF -->
                <a href="#" title="Download as PDF">
                    <i
                        class="fa-solid fa-file-pdf {{ $iconPDF }} hover:text-slate-800 transition-all duration-500"></i>
                </a>
                <!-- Edit -->
                <a href="{{ route('contacts.edit', $contact) }}" title="Edit">
                    <i class="fa-solid fa-pencil {{ $iconEdit }} hover:text-slate-800 transition-all duration-500"></i>
                </a>
                <!-- Delete -->
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST">
                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                    @csrf
                    <!-- Dirtective to Override the http method -->
                    @method('DELETE')
                    <button
                        onclick="return confirm('Are you sure you want to delete this contact')"
                        title="Delete">
                        <i
                            class="fa-solid fa-trash {{ $iconDelete }} hover:text-slate-800 transition-all duration-500 cursor-pointer"></i>
                    </button>
                </form>                
                <!-- Actions -->
                <span class="{{$actionsBadge}}">actions</span>
            
        </div>


        <!-- INFO -->
        <div class="mx-auto w-11/12 mt-4 pb-4 flex flex-col gap-2 border-b-1 border-b-slate-800">

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
                    <span class="w-full md:w-40 rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">{{$contact->id}}</span>
                </div>

            </div>
            
            <!-- Type -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-address-book"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">Type</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($contact->type))  
                            <span> {{ $contact->type}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- First Name -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-user"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">First Name</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($contact->first_name))  
                            <span> {{ $contact->first_name}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- Last Name -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-people-group"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">Last Name</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($contact->last_name))  
                            <span> {{ $contact->last_name}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- Phone -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-mobile"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">Phone</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($contact->phone))  
                            <span> {{ $contact->phone}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- Email -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-at"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">Email</span>
                    </div>
                    <div class="flex flex-row justify-start items-center p-2 md:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Email">
                            <button class="btn" data-clipboard-target="#email" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Email">
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
                        id="email">
                        {{ $contact->email }}</span>
                    </div>

                    <div class="flex flex-row justify-start items-center p-2 max-sm:hidden">
                        <span x-data="{ show: false }" class="relative" data-tooltip="Copy Email">
                            <button class="btn cursor-pointer" data-clipboard-target="#email" x-on:click="show = true"
                                x-on:mouseout="show = false" title="Copy Email">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <span x-show="show" class="absolute -top-8 -right-6">
                                <span class="bg-green-600 text-white text-xs rounded-lg p-1 opacity-90">Copied!</span>
                            </span>
                        </span>
                    </div>

                </div>

            </div>

            <!-- Address -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-house"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">Address</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($contact->address))  
                            <span> {{ $contact->address}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>
            
            <!-- City -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-city"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">City</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($contact->city))  
                            <span> {{ $contact->city}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- Location -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">Location</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        @if (isset($contact->location))  
                            <span> {{ $contact->location}}</span>
                        @else 
                            <span>-</span>
                        @endif 
                    </span>
                </div>

            </div>

            <!-- Birthdate -->
            <div class="flex flex-col md:flex-row gap-2">

                <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                    <div class="bg-black text-white p-1 rounded-md">
                        <i class="fa-solid fa-cake-candles"></i>
                    </div>                    
                    <div class="w-full">
                        <span class="text-lg font-semibold capitalize">Birthdate</span>
                    </div>                    
                </div>
                
                <div class="flex flex-row justify-start items-center p-0 w-full">
                    <span 
                        class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                        {{ date('d-m-Y', strtotime($contact->birthdate)) }}</span>
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
                    @if (strip_tags($contact->info) != '')
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

                    @if (strip_tags($contact->info) != '')
                        <div class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                            <span class="text-md" id="info">{!! $contact->info !!}</span>
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
            

        </div>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa-solid fa-angle-up"></i></button>

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 {{ $bgMenuColor }} rounded-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>        

    </div>    

</div>

<script>
    new ClipboardJS('.btn');
</script>
