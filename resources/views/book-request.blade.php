<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Str::title($book->title) }}:   {{ $book->isbn }}
        </h2>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table style="width:90%">
                        <thead style="text-align: left;">
                        <tr>
                            <th></th>
                            <th>Request #</th>
                            <th>Requester</th>
                            <th>Class</th>
                            <th>Ordered/Quantity</th>
                            <th>Students/Max</th>
                        </tr>
                        <thead>
                        <tbody>
                            @foreach ($request as $item)
                            <tr>
                                <td><input type="checkbox" id="{{ $item->id }}" class="cb" onclick="rowSelect(this)"></td>
                                <td>
                                    <a href="{{ url('orders', $item->id) }}" style="text-decoration: underline">
                                        {{ $item->id }}
                                    </a>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->class }}</td>
                                <td id="o/q:{{ $item->id }}">{{ $item->ordered }}/{{ $item->quantity }}</td>
                                <td>{{ $item->students }}/{{ $item->max }}</td>
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class="inline-flex items-center">
                        <div>
                            <div>
                                <label for="numOrdered">Number Ordered:  </label><br>
                                <input id="numOrdered" name="numOrdered" style="width: 75px; color: black">
                                <x-primary-button onClick="setOrdered()">Update</x-primary-button>
                            </div>
                            <div>
                                <label for="quantity">Quantity Requested:  </label><br>
                                <input id="quantity" name="quantity" style="width: 75px; color: black" disabled>
                            </div>
                        </div>
                        <div style="margin-left: 250px">
                            <label for="notes">Notes: </label><br>
                            <textarea id="notes" name="notes" style="width: 500px; height: 125px; color: black"></textarea>
                        </div>
                        <a href="{{ URL::previous() }}">
                            <x-primary-button class="returnButton" id class="ms-3">
                            {{ __('Return') }}
                            </x-primary-button>
                        </a>
                        <x-primary-button onclick="submitRequest({{ $book->id }})" class="submitButton" id class="ms-3">
                        {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <script>
        let activeRow;
        let updated = [];
        function Obj(id, ordered){
            this.id = id;
            this.ordered = ordered;
        }
        function cbChange(obj) {
        var cbs = document.getElementsByClassName("cb");
        for (var i = 0; i < cbs.length; i++) {
            cbs[i].checked = false;
        }
        obj.checked = true;
        }
        
        function rowSelect(obj) {
            cbChange(obj);
            activeRow = obj.id;
            let ordered = document.getElementById("numOrdered");
            let quantity = document.getElementById("quantity");
            let id = "o/q:"+obj.id;
            let string = document.getElementById(id).innerText;            
            let arr = string.split('/');
            ordered.value = arr[0];
            quantity.value = arr[1];

        }

        function setOrdered(){
            let ordered = document.getElementById("numOrdered").value;
            let id = "o/q:"+activeRow;
            let field = document.getElementById(id);
            let string = field.innerText;
            let arr = string.split('/');
            arr[0] = ordered;
            string = arr.join('/');
            field.innerText = string;

            let obj = new Obj(activeRow, ordered);
            addToUpdated(obj);
        }

        function addToUpdated(obj){
            if(updated.length < 1){
                updated.push(obj);
                return;
            }
            let index = updated.findIndex(list => list.id == obj.id)

            if (index!== -1){
                updated[index] = obj;
            }
            else{
                updated.push(obj);
            }
            console.log(updated)            
        }

        function submitRequest($id) {
            let route = "{{ route('requests.update', ':id') }}";
            route = route.replace(':id', $id);
            const jsonList = JSON.stringify(updated);
            
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: route,
                data:{'reqList': jsonList},
                type:'patch',
                success:  function (response) {
                    alert("Changes saved!");
                },
                error: function(x,xs,xt){
                    alert(x);

                }
            });
        }
    </script>
</x-app-layout>
