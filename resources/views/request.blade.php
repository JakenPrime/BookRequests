<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Request # {{ $request->id  }}: {{$request->name}}
        </h2>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table style="width:90%">
                        <thead style="text-align: left; border: botttom 5px solid white;">
                        <tr>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Quantity</th>
                        </tr>
                        <thead>
                        <tbody>
                            @foreach ($books as $item)
                            <tr>                                
                                <td><a href="{{ url('requests', $item->id) }}" style="text-decoration: underline">
                                    {{ $item->isbn }}
                                </a></td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->author }}</td>
                                <td>{{ $item->publisher }}</td>
                                <td>{{ $item->ordered }}/{{ $item->quantity }}</td>
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class="inline-flex items-center">
                        <div>
                            <div>
                                <label for="status">Request Status: </label><br>
                                <select id="status" name="status" style="width: 150px; color: black">
                                @if($request->status == 4)
                                    <option id='2' value='2' selected disabled>Completed</option>
                                @else
                                    <option id='0' value='0' {{ $request->status == 0 ? 'selected' : '' }}>Open</option>
                                    <option id='1' value='1' {{ $request->status == 1 ? 'selected' : '' }}>Pending</option>
                                    <option id='2' value='2' {{ $request->status == 2 ? 'selected' : '' }}>Completed</option>
                                    <option id='3' value='3' {{ $request->status == 3 ? 'selected' : '' }}>Canceled</option>
                                @endif
                                </select>
                            </div><br>                            
                            <div>
                                <input type="checkbox" id="archive" name="archive" value="archive">
                                <label for="archive"> Archive</label><br>
                            </div>                         
                        </div>
                        <div style="margin-left: 250px">
                            <label for="notes">Notes:  </label><br>
                            <textarea id="notes" name="notes" style="width: 500px; height: 125px; color: black">{{ $request->notes }}</textarea>
                        </div>
                        <a href="{{ URL::previous() }}">
                            <x-primary-button class="returnButton" id class="ms-3">
                            {{ __('Return') }}
                            </x-primary-button>
                        </a>
                        <x-primary-button onclick="submitRequest({{ $request->id }})" class="submitButton" id class="ms-3">
                        {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <script>
        let select = document.getElementById('status');
        let notes = document.getElementById('notes');
        let startingStatus = select.value;
        let status, notesTxt;
        let order = {};
        select.onchange = (event) => {
            status = event.target.value;
            order.status = status;
        }

        document.onload = () => {
            notesTxt = notes.value;
        }

        function notesChange(){
            if(notes.value == notesTxt){
                return;
            }
            order.notes = notes.value;
        }

        function submitRequest(id) {
            order.id = id
            notesChange();
            getStatus();
            console.log(order);
            if(order.status == 9){
                alert("Complete Order to Archive");
                return;
            }
            if(order.status == startingStatus && order.notes == notesTxt){ 
                alert("No Changes to Save");
                return;
            }
            route = getRoute(id);
            const json = JSON.stringify(order);

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: route,
                data:{'order': json},
                type:'patch',
                success:  function (response) {
                    alert("Changes Saved!");
                },
                error: function(x,xs,xt){
                    alert(x);

                }
            });
        }

        function getStatus() {
            let archive = document.getElementById('archive');
            if(archive.checked && startingStatus != 2){
                order.status = 9;
                return;
            }
            else if(archive.checked && startingStatus == 2)
            {
                order.status = 4;
                return ;
            }
            order.status = select.value;
        }

        function getRoute(id){
            
            let route = "{{ route('orders.update', ':id') }}";

            route = route.replace(':id', id);

            return route;
        }
    </script>
</x-app-layout>
