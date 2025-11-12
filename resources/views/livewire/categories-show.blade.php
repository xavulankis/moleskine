<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Messages -->
    @if (session('message'))
        <div class="flex flex-col bg-green-600 p-1 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('message') }}</span>
                <a href="/categories/show/{{ $category->id }}" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex flex-col bg-red-600 p-1 text-white text-sm rounded-sm">        
            <div class="flex row justify-between items-center">
                <span class="font-bold">{{ session('error') }}</span>
                <a href="/categories/show/{{ $category->id }}" class="cursor-pointer" title="Close">
                    <i class="fa-solid fa-xmark hover:text-gray-600 transition-all duration-500"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 p-1 text-sm text-slate-600">
        <a href="/categories" class="hover:text-black">Categories</a> /
        <a href="/categories/show/{{$category->id}}" class="font-bold text-black border-b-2 border-b-orange-600">Info</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">        

        <!-- Header -->
        <div class="flex flex-row text-white font-bold uppercase p-2 bg-amber-600">
            <span>information</span>
        </div>

        <!-- Actions -->
        <div class="flex flex-row w-11/12 mx-auto justify-end items-center p-2 gap-2 border-b-1 border-b-zinc-400">
                            
                <!-- Edit -->
                <a href="{{ route('categories.edit', $category) }}" title="Edit">
                    <i class="fa-solid fa-pencil hover:text-green-600 transition-all duration-500"></i>
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
                            class="fa-solid fa-trash hover:text-red-600 transition-all duration-500 cursor-pointer"></i>
                    </button>
                </form>
            
        </div>

        <!-- Name -->
        <div class="flex flex-col md:flex-row mx-auto w-11/12 my-4 gap-2">

            <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                <div class="bg-black text-white p-1 rounded-md">
                    <i class="fa-solid fa-pen"></i>
                </div>                    
                <div class="w-full">
                    <span class="text-lg font-semibold capitalize">name</span>
                </div>                    
            </div>
            
            <div class="flex flex-row justify-start items-center p-0 w-full">
                <input name="name" id="name" type="text" value="{{ $category->name }}" disabled
                            maxlength="200"
                            class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
            </div>
            
        </div>

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-amber-600 rounded-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>

    </div>

</div>

