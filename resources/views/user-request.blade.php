<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Request # {{ $request->id  }}: {{$request->statusName}}
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
                            <th></th>
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
                                <td><input type="checkbox" id="{{ $item->id }}" class="cb" onclick="rowSelect(this)"></td>                                
                                <td>{{ $item->isbn }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->author }}</td>
                                <td>{{ $item->publisher }}</td>
                                <td id="o/q:{{ $item->id }}">{{ $item->ordered }}/{{ $item->quantity }}</td>
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
                                <input id="numOrdered" name="numOrdered" style="width: 75px; color: black" disabled>                                
                            </div>
                            <div>
                                <label for="quantity">Quantity Requested:  </label><br>
                                @if ($request->status != 2 && $request->status != 3)
                                    <input id="quantity" name="quantity" style="width: 75px; margin-right:5px; color: black">
                                    <x-primary-button onClick="setQuantity()">Update</x-primary-button>    
                                @else
                                    <input id="quantity" name="quantity" style="width: 75px; margin-right:5px; color: black" disabled>                                    
                                @endif
                                    
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
                        @if ($request->status != 2 && $request->status != 3)
                            <x-primary-button onclick="submitRequest({{ $request->id }})" class="submitButton" id class="ms-3">
                            {{ __('Save') }}
                            </x-primary-button>
                        @endif
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <script>
        let activeRow;
        let updated = [];
        function Obj(id, quantity){
            this.id = id;
            this.quantity = quantity;
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

        function setQuantity(){
            let quantity = document.getElementById("quantity").value;
            let id = "o/q:"+activeRow;
            let field = document.getElementById(id);
            let string = field.innerText;
            let arr = string.split('/');
            arr[1] = quantity;
            string = arr.join('/');
            field.innerText = string;

            let obj = new Obj(activeRow, quantity);
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
            let route = "{{ route('user.update', ':id') }}";
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
