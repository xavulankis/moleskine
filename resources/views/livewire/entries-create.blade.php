<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Sitemap -->    
    <div class="flex flex-row justify-start items-start gap-1 py-1 text-sm text-slate-600">
        <a href="/entries" class="hover:text-black">Entries</a> /
        <a href="/entries/create" class="font-bold text-black border-b-2 border-b-blue-600">Create</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">

        <!-- Header -->
        <div class="flex flex-row text-white font-bold uppercase p-2 bg-blue-600">
            <span>New Entry</span>
        </div>

        <!-- New Entry -->
        <form wire:submit="save">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf

            <!-- INFO -->
            <div class="mx-auto w-11/12 mt-4 pb-4 rounded-sm flex flex-col gap-2">                              

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
                        <input wire:model="date" name="date" id="date" type="date" value="{{ old('date') }}"                                    
                                    class="w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>

                </div>

                @error('date')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

                <!-- Title -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-pen"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">title</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center p-0 w-full">
                        <input wire:model="title" name="title" id="title" type="text" value="{{ old('title') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('title')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

                <!-- Category -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="ttext-lg font-semibold capitalize">category</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center w-full">
                        <select wire:model.live="category_id" name="category_id" id="category_id"
                            class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" class="text-orange-600"
                                    @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @error('category_id')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                    
                    <div class="flex flex-row justify-start items-center w-full">
                        <div wire:ignore class="w-full">
                            <select wire:model="selectedTags" name="selectedTags" id="selectedTags" multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" @if (old('selectedTags') == $tag->id) selected @endif>
                                        {{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                @error('selectedTags')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror
                
                <!-- Description -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-align-left"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">description</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center p-0 w-full">
                        <input wire:model="description" name="description" id="description" type="text" value="{{ old('description') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('description')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

                <!-- Url -->
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
                        <input wire:model="url" name="url" id="url" type="text" value="{{ old('url') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('url')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="place" name="place" id="place" type="text" value="{{ old('place') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('place')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="autor" name="autor" id="autor" type="text" value="{{ old('autor') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('autor')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="value" name="value" id="value" type="any" value="{{ old('value') }}"
                                    maxlength="8"
                                    class="w-full md:w-24 rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('value')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror            
                
                <!-- Info -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-info"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">information</span>
                        </div>                    
                    </div>
                    
                    <div class="w-full">
                        @livewire('texteditor.quill')        
                    </div>

                </div>

                @error('info')
                    <div class="text-sm text-white font-bold bg-red-600 px-2 mb-2">
                        {{ $message }}                                
                    </div>
                @enderror
               

                <!-- Save -->
                <div class="flex flex-col md:items-end">
                    <button type="submit"
                        class="w-full md:w-1/4 bg-blue-600 hover:bg-blue-800 text-white font-semibold uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out cursor-pointer">
                        Save
                    </button>
                </div>               

            </div>

        </form>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                class="fa-solid fa-angle-up"></i></button> 

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-blue-600 rounded-b-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>

        @script()
            <script>
                $(document).ready(function() {
                    $('#selectedTags').select2();

                    // event
                    $('#selectedTags').on('change', function() {
                        let selected = $(this).val();
                        //console.log(selected);
                        //$wire.set('selectedTags', selected); -> equivalent to model.live, makes a request for each selection
                        //$wire.set('selectedTags', selected, false);     // only update when click, equivalent to model
                        $wire.selectedTags = selected; // same as $wire.set('selectedTags', selected, false);
                    });

                });                
            </script>
        @endscript

    </div>

</div>

