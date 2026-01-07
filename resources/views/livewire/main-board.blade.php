<div class="w-full sm:max-w-10/12 mx-auto">

    <div class="overflow-hidden py-2">

        <div class="bg-zinc-200 p-2 border-0 border-slate-400 rounded-sm">

            <!-- NEW ENTRIES -->
            <div class="flex md:flex-row flex-col justify-between items-start gap-4 font-bold capitalize text-white mb-6">
                <a class="flex flex-col w-full h-24 py-8 rounded-sm text-center bg-black hover:bg-yellow-400 transition duration-1000 ease-in-out" href="{{ route('entries.create') }}">new entry</a>
                <a class="flex flex-col w-full h-24 py-8 rounded-sm text-center bg-indigo-600 hover:bg-yellow-400 transition duration-1000 ease-in-out" href="{{ route('categories.create') }}">new category</a>
                <a class="flex flex-col w-full h-24 py-8 rounded-sm text-center bg-teal-600 hover:bg-yellow-400 transition duration-1000 ease-in-out" href="{{ route('tags.create') }}">new tag</a>
                <a class="flex flex-col w-full h-24 py-8 rounded-sm text-center bg-amber-600 hover:bg-yellow-400 transition duration-1000 ease-in-out" href="{{ route('contacts.create') }}">new contact</a>
            </div>

            <div>            
                @if ($birthdays->count())
                <span class="text-xl font-semibold p-1">Birthdays Today</span>
                <!-- TABLE -->
                    <div class="bg-white text-black mt-1 mb-4">
                        <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <!-- TABLE HEADER -->
                                    <thead class="bg-amber-600 text-white">
                                        <tr class="text-left text-sm font-normal uppercase">                                                                        
                                            <th class="p-2">First Name</th>                                    
                                            <th class="p-2">Last Name</th>
                                            <th class="p-2">Phone</th>
                                            <th class="p-2">Email</th>
                                            <th class="p-2">birthdate</th>
                                            <th class="p-2">age</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <!-- TABLE BODY -->
                                    <tbody>
                                        @foreach ($birthdays as $entry)
                                            <!-- Color Code Pending Tasks -->
                                            <tr>
                                                <td class="p-2 pr-12 "><a
                                                        href="{{ route('entries.show', $entry) }}">{{ $entry->first_name }}</a></td>                                                
                                                <td class="p-2 pr-12">{{ $entry->last_name }}</td>
                                                <td class="p-2 pr-12">{{ !empty($entry->phone) ? $entry->phone : '-' }}</td>
                                                <td class="p-2 pr-12">{{ !empty($entry->email) ? $entry->email : '-' }}</td>
                                                <td class="p-2 pr-12">{{ !empty($entry->birthdate) ? date('d-m-Y', strtotime($entry->birthdate)) : '-' }}</td>
                                                <td class="p-2 pr-12">{{ date('Y', strtotime(now())) - date('Y', strtotime($entry->birthdate)) }}</td>
            
                                                <!-- ACTIONS --> 
                                                <td class="p-2">
                                                    <div class="flex justify-center items-center gap-2">
                                                        <!-- Open -->
                                                        <a href="{{ route('contacts.show', $entry) }}" title="Open">
                                                            <i
                                                                class="fa-solid fa-arrow-up-right-from-square {{ $iconShow}} hover:text-slate-800 transition duration-1000 ease-in-out"></i>
                                                        </a>                                                                                            
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                        </div>

                    </div>
                @endif
            </div>
            
            
            <!-- TASKS -->
            <div class="flex flex-col"> 
                <span class="text-xl font-semibold p-1">Pending Tasks 1</span>
                
                <div class="flex md:flex-row flex-col justify-start md:items-center items-left gap-2 text-xs mt-4 mb-2">
                    <span class="bg-red-300 p-1 rounded-sm font-bold capitalize w-fit">today</span>
                    <span>{{date('d-m-Y')}}</span>
                    <span class="bg-amber-400 p-1 rounded-sm font-bold capitalize w-fit">this week </span>
                    <span>{{date('d-m-Y')}} to {{date('d-m-Y', strtotime('+7 days'))}}</span>
                    <span class="bg-green-300 p-1 rounded-sm font-bold capitalize w-fit">next 7 days</span>
                    <span>after {{date('d-m-Y', strtotime('+7 days'))}}</span>
                </div>
            </div>
            @if ($notifications->count())
                    <!-- TABLE -->
                    <div class="bg-slate-200 text-black mt-1 mb-4">
                        <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <!-- TABLE HEADER -->
                                    <thead class="bg-black text-white">
                                        <tr class="text-left text-sm font-normal uppercase">                                                                        
                                            <th class="p-2">Date</th>                                    
                                            <th class="p-2">Title</th>
                                            <th class="p-2">category</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <!-- TABLE BODY -->
                                    <tbody>
                                        @foreach ($notifications as $entry)                                        
                                            <!-- Color Code Pending Tasks -->
                                            @if(date('Y-m-d', strtotime($entry->date)) == date('Y-m-d'))
                                            <tr class="bg-red-300">
                                            @elseif(date('Y-m-d', strtotime($entry->date)) <= date('Y-m-d', strtotime('+7 days')))
                                                <tr class="bg-amber-300">
                                            @elseif(date('Y-m-d', strtotime($entry->date)) > date('Y-m-d', strtotime('+7 days')))
                                                <tr class="bg-green-300">
                                            @endif                                    
                                                <td class="p-2 pr-12 ">{{ date('d-m-Y', strtotime($entry->date)) }}</td>
                                                
                                                <td class="p-2 pr-12"> <a
                                                        href="{{ route('entries.show', $entry) }}">{{ $entry->title }}</a></td>

                                                <td class="p-2 pr-12">{{ $entry->category->name }}</td>
            
                                                <!-- ACTIONS --> 
                                                <td class="p-2">
                                                    <div class="flex justify-center items-center gap-2">
                                                        <!-- Open -->
                                                        <a href="{{ route('entries.show', $entry) }}" title="Open">
                                                            <i
                                                                class="fa-solid fa-arrow-up-right-from-square {{ $iconShow}} hover:text-slate-800 transition duration-1000 ease-in-out"></i>
                                                        </a>                                                                                            
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
                    <span>No pending tasks found in the system.</span>                    
                    </span>
                </div>            
            @endif
        </div>

    </div>
</div>
