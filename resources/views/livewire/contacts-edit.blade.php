<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Sitemap -->    
    <div class="flex flex-row justify-start items-start gap-1 py-1 text-sm text-slate-600">
        <a href="/contacts" class="hover:text-black">Contacts</a> /
        <a href="/contacts/show/{{ $contact->id }}" class="hover:text-orange-600">Info</a> /
        <a href="/contacts/edit/{{ $contact->id }}" class="font-bold text-black {{ $underlineMenu }}">Edit</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">

        <!-- Header -->
        <div class="flex flex-row text-white font-bold uppercase p-2 {{ $bgMenuColor }}">
            <span>Edit Contact</span>
        </div>

        <!-- Edit Contact -->
        <form wire:submit="save">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf

            <!-- INFO -->
            <div class="mx-auto w-11/12 mt-4 pb-4 rounded-sm flex flex-col gap-2">   
                
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
                    
                    <div class="flex flex-row justify-start items-center w-full">
                        <select wire:model.live="type" name="type" id="type"
                            class="w-full md:w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                            @foreach ($types as $typ)
                                <option value="{{ $typ }}" class="text-orange-600"
                                    @if (old('type') == $typ) selected @endif>{{ $typ }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @error('type')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="first_name" name="first_name" id="first_name" type="text" value="{{ old('first_name') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('first_name')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="last_name" name="last_name" id="last_name" type="text" value="{{ old('last_name') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('last_name')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="phone" name="phone" id="phone" type="text" value="{{ old('phone') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('phone')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror
                
                <!-- Email -->
                <div class="flex flex-col md:flex-row gap-2">

                    <div class="flex flex-row justify-start items-center md:w-1/3 gap-2">
                        <div class="bg-black text-white p-1 rounded-md">
                            <i class="fa-solid fa-at"></i>
                        </div>                    
                        <div class="w-full">
                            <span class="text-lg font-semibold capitalize">Email</span>
                        </div>                    
                    </div>
                    
                    <div class="flex flex-row justify-start items-center p-0 w-full">
                        <input wire:model="email" name="email" id="email" type="text" value="{{ old('email') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('email')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror
                
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
                        <input wire:model="address" name="address" id="address" type="text" value="{{ old('address') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('address')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="city" name="city" id="city" type="text" value="{{ old('city') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('city')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="location" name="location" id="location" type="text" value="{{ old('location') }}"
                                    class="w-full rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    
                </div>
                
                @error('location')
                    <div class="text-sm text-red-600 font-semibold">
                        {{ $message }}                                
                    </div>
                @enderror

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
                        <input wire:model="birthdate" name="birthdate" id="birthdate" type="date" value="{{ old('birthdate') }}"                                    
                                    class="w-fit rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400">
                    </div>

                </div>

                @error('birthdate')
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
                        class="w-full md:w-1/4 {{ $bgMenuColor }} hover:bg-green-800 text-white font-semibold uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out cursor-pointer">
                        Save
                    </button>
                </div>               

            </div>

        </form>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                class="fa-solid fa-angle-up"></i></button> 

        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 {{ $bgMenuColor }} rounded-b-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>        

    </div>

</div>

