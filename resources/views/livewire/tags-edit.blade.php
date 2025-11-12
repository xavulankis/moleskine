<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 py-1 text-sm text-slate-600">
        <a href="/tags" class="hover:text-black">Tags</a> /
        <a href="/tags/show/{{$tag->id}}" class="hover:text-amber-600">Info</a> /
        <a href="/tags/edit/{{ $tag->id }}" class="font-bold text-black border-b-2 border-b-green-600">Edit</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">

        <!-- Header -->
        <div class="flex flex-row text-white font-bold uppercase p-2 bg-green-600">
            <span>edit tag</span>
        </div>

        <!-- Edit tag -->
        <form action="{{ route('tags.update', $tag) }}" method="POST">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf
            <!-- Dirtective to Override the http method -->
            @method('PUT')

            <!-- INFO -->
            <div class="mx-auto w-11/12 mt-4 pb-4 rounded-sm flex flex-col gap-2">


                <!-- Name -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-pen"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">name</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center p-0 w-full">
                        <input name="name" id="name" type="text" value="{{ $tag->name }}"
                                    maxlength="200"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>

                @error('name')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

                <!-- Save -->
                <div class="flex flex-col md:items-end">
                    <button type="submit"
                        class="w-full md:w-1/4 bg-green-600 hover:bg-green-800 text-white font-semibold uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out cursor-pointer">
                        Save
                    </button>
                </div>

            </div>

        </form>    
        
        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-green-600 rounded-b-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div> 

    </div>

</div>
