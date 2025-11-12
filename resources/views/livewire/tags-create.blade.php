<div class="w-full sm:max-w-10/12 mx-auto">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 py-1 text-sm text-slate-600">
        <a href="/tags" class="hover:text-black">Tags</a> /
        <a href="/tags/create" class="font-bold text-black border-b-2 border-b-blue-600">Create</a>
    </div>

    <div class="bg-zinc-200 overflow-hidden shadow-sm md:rounded-t-sm">

        <!-- Header -->
        <div class="flex flex-row justify-between items-center p-2 bg-blue-600">
            
            <span class="text-white font-bold uppercase">New tag </span>
            
            <button wire:click.prevent="help">
                <i class="fa-lg fa-solid fa-circle-question text-white cursor-pointer hover:text-yellow-400 transition duration-1000 ease-in-out" title="help"></i>
            </button>

        </div>
    
        <!-- Help -->
        @if ($show % 2 != 0)

            <div class="flex flex-col w-11/12 mx-auto rounded-sm border-1 border-zinc-400 bg-zinc-300 my-4 p-2">
                
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-row text-sm items-center text-zinc-800 font-bold  gap-2">
                        <span class="uppercase bg-yellow-200 p-1 rounded-sm">Help</span>
                        <span class="">add multiple tags using the add button</span>
                    </div>
                    <button wire:click.prevent="help" class="cursor-pointer hover:text-zinc-600 transition duration-1000 ease-in-out" title="Close"><i class="fa-lg fa-solid fa-circle-xmark"></i></button>                    
                </div>
                
            </div>
            
        @endif
        
        <!--tag -->
        <div class="flex flex-col mx-auto w-11/12 p-2 gap-4 my-4">
            <span class="text-sm font-bold">You can create 5 new tags at once</span>
            <div class="flex flex-col">                
                @if ($inputs->count() < 5)
                    <button wire:click.prevent="add" class="w-fit bg-green-600 font-bold text-white uppercase p-2 rounded-sm hover:bg-green-500 transition duration-1000 ease-in-out">
                        add
                        <i class="fa-solid fa-circle-plus"></i>
                    </button>
                    @else
                    <span class="text-red-600 text-sm font-semibold">You have reached the limit (5)</span>
                @endif
            </div>
            @php $count = 0 @endphp
            @foreach ($inputs as $key => $value)
                <div class="flex flex-row justify-start items-center gap-2">
    
                    <input wire:model="inputs.{{ $key }}.name" type="text" id="inputs.{{ $key }}.name" class="w-full sm:w-1/2 rounded-sm bg-zinc-100 border-1 border-zinc-300 text-gray-900 p-2 focus:border-black focus:outline-hidden focus:ring-blue-400 focus:border-blue-400" placeholder="Enter a name">
                    @if ($count > 0)
                        <button wire:click="remove({{ $key }})" class="cursor-pointer text-red-600 hover:text-black transition duration-1000 ease-in-out">
                            <i class="fa-solid fa-trash" title="Delete"></i>
                        </button>
                    @endif
                </div>
                @error('inputs.' . $key . '.name')
                    <div>
                        <span class="text-sm text-red-600 font-semibold p-2">{{ $message }}</span>
                    </div>
                @enderror
                @php $count++ @endphp
            @endforeach
            <!-- Save -->
            <div class="flex flex-col md:items-start">
                <button wire:click.prevent="save" 
                    class="w-full md:w-1/4 bg-blue-600 hover:bg-blue-800 text-white font-semibold uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out cursor-pointer {{ $inputs->count() > 5 ? 'cursor-not-allowed' : '' }}" {{ $inputs->count() > 5 ? 'disabled' : '' }}">
                    Save
                </button>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="flex flex-row justify-center items-center p-2 mt-4 bg-blue-600 rounded-b-sm">
            <span class="font-bold text-xs text-white">xavulankis 2025</span>
        </div>        

    </div>

</div>
