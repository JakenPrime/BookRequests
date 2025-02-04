<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg items-center">
                <div class="p-6 text-black-900 dark:text-black-100 inline-flex items-center" style="width:100%">
                    <!--OPEN REQUESTS-->
                    <div style="width:50%">
                        <label class="text-gray-800 dark:text-gray-200" style="margin-left:20px" for="openSelect" style>
                            Requests, not ordered</label><br>
                        <select id="openSelect" name="openSelect" size="10" style="margin-right:50px; margin-left:20px; width: 90%">
                        @if($openList->count() > 0)
                            @foreach ($openList as $order)
                                <option value="{{ $order->id }}" onclick="handleOpen({{ $order->id }})">
                                    {{ $order->title }}:   {{ $order->quantity }}
                                </option>
                            @endforeach
                        @else
                            <option id="openEmpty"> No Open Requests</option>
                        @endif
                        </select>
                        <x-primary-button style="margin-left:20px;" onclick="viewOpen()">View Open Request</x-primary-button>
                    </div>
                    <!--PENDING REQUESTS-->
                    <div style="width:50%">
                        <label class="text-gray-800 dark:text-gray-200" style="margin-left:20px"for="pendingSelect">
                            Pending Orders</label><br>
                        <select id="pendingSelect" name="pendingSelect" size="10" style="margin-right:50px; margin-left:20px; width: 90%">
                        @if($pendingList->count() > 0)
                            @foreach ($pendingList as $order)
                                <option value="{{ $order->id }}" onclick="handlePending({{ $order->id }})">
                                    {{ Str::limit($order->title, 20) }}:  {{ $order->ordered }}/{{ $order->quantity }}
                                </option>
                            @endforeach
                        @else
                            <option id="openEmpty"> No Pending Requests</option>
                        @endif
                        </select>
                        <x-primary-button style="margin-left:20px;" onclick="viewPending()" class="btn btn-success">Update Pending Request</x-primary-button>
                    </div>
                    <!--CLSOED REQUESTS-->
                    <div style="width:50%">
                            <input style="margin-left:20px" type="checkbox" id="archive" name="archive" value="archive">
                            <label class="text-gray-800 dark:text-gray-200" for="archive"> View Archive</label>
                            <input type="checkbox" id="archive" name="archive" value="archive">
                            <label class="text-gray-800 dark:text-gray-200" for="archive"> View Canceled</label></br>
                        <label class="text-gray-800 dark:text-gray-200" style="margin-left:20px"for="closedSelect">
                            Completed Orders</label>
                        <select id="closedSelect" name="closedSelect" size="10" style="margin-right:50px; margin-left:20px; width: 90%">
                        @if($completedList->count() > 0)
                            @foreach ($completedList as $order)
                                <option value="{{ $order->id }}" onclick="handleClosed({{ $order->id }},{{ $order->book }})">
                                    {{ Str::limit($order->title, 20) }}: {{ $order->ordered }}/{{ $order->quantity }}
                                </option>
                            @endforeach
                        @else
                            <option id="openEmpty"> No Completed Requests</option>
                        @endif
                        </select>                        
                        <div class="inline-flex items-center">
                            <x-primary-button style="margin-left:20px;" onclick="viewClosed()" class="btn btn-success">View Completed Request</x-primary-button>
                            <x-primary-button style="margin-left: 20px; width: 150px" onclick="viewShelfTag()" class="btn btn-success">Create Shelf Tag</x-primary-button>
                        </div>                        
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <script>
        let openID;
        let pendID;
        let closedID;
        let tagID;
        let route ="";
        function handleOpen($id) {
           openID = $id;
        }
        function handlePending($id) {
            pendID = $id;
        }
        function handleClosed($id, $book) {
            closedID = $id;
            tagID = $book
        }
        function viewOpen(){
            if(!openID){
                alert("Select a open request first!");
                return;
            }
            route = getRoute(openID);
            window.location.href = route;
        }
        function viewPending() {
            if(!pendID){
                alert("Select a pending request first!");
                return;
            }
            route = getRoute(pendID);
            window.location.href = route;
        }
        function viewClosed() {
            if(!closedID){
                alert("Select a completed request first!");
                return;
            }
            route = getClosedRoute(closedID);
            window.location.href = route;
        }

        function viewShelfTag(){
            if(!closedID){
                alert("Select a completed request first!");
                return;
            }
            route = getShelfTagRoute(tagID);
            window.location.href = route;
        }
        function getRoute($id){
            let route = "{{ route('requests', ':id') }}";
            return route.replace(':id', $id);
        }
        function getClosedRoute($id){
            let route = "{{ route('orders', ':id') }}";
            return route.replace(':id', $id);
        }
        function getShelfTagRoute($id){
            let route = "{{ route('shelf-tag', ':id') }}";
            return route.replace(':id', $id);
        }
        
    </script>
</x-app-layout>
