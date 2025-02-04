<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Book Request') }}
        </h2>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <br>
        <select id="classSelect">
            <option value="0">Select your class</option>
            <option value="2">Test Class 1</option>
            <option value="5">Test Class 2</option>
        </select>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"style="height:500px">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="height:100%">
                <div class="p-6 text-black-900 dark:text-black-100 inline-flex items-center" style="height:100%">
                    <!--BOOK LIST-->
                    <table style="margin-left:50px">
                        <tr><td><input type="text" id="bookSearch" onkeyup="bookSearch()" placeholder="Search for books.."></td></tr>
                        <tr><td><select id="books" size="15">
                            @foreach ($bookList as $book)
                                <option value="{{ $book->id }}" onclick="handleSelect({{ $book }})">
                                "{{ $book->title}}": {{ $book->author ? $book->author : "..." }} {{$book->isbn}}
                                </option>
                            @endforeach
                        </select></td></tr>
                    </table>
                    <!--Quantity input and buttons-->
                    <table style="align-items: center;">                        
                        <tr><td><input id="quantity" style="width: 75px;" value="0"></td></tr>
                        <tr><td><x-primary-button class="bg-white" onclick="copyBook()"> Add -> </x-primary-button></td></tr>
                        <tr><td><x-primary-button class="bg-white" onclick="removeBook()"> <- Remove </x-primary-button></td></tr>
                    </table>
                    <!--REQUEST LIST-->
                    <select class="requestList" id="requestList" size="15" width="20">
                        <option value="" id="noBooks" disabled selected>No Books in Request</option>
                    </select>
                    <x-primary-button onclick="submitRequest()" class="createRequest" id class="ms-3">
                        {{ __('Create Request') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let selectedBook;
        const selectedList= [], bookList = [];
        let requestID;
        let noBooks = document.getElementById("noBooks");
        let requestList =  document.getElementById("requestList");

        window.onload = ()=>{
            books = document.getElementById('books').children;
            for(const x of books){
                var string = x.innerText;
                var arr = string.split(':');
                bookList.push(arr[0]);
            }
        }

        function bookSearch() {
            var input, filter, ul, li, a, i, txtValue;
            
            input = document.getElementById("bookSearch");
            
            filter = input.value.toUpperCase();
            
            select = document.getElementById("books");
            
            list = select.getElementsByTagName("option");
            
            for (i = 0; i < bookList.length; i++) {
                txtValue = bookList[i];
                
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    list[i].style.display = "";
                } else {
                    list[i].style.display = "none";
                }
            }
        }
        function handleSelect(item) {
            selectedBook = item
        }
        function handleRemove(id){
            requestID = id;
        }
        function createOption(item){
           let newOption = document.createElement("option");
           newOption.id = "selected"+item.id;
           newOption.value = item.id;
           newOption.text = item.title+": "+item.quantity;
           newOption.setAttribute('onclick', 'handleRemove('+item.id+')');
           return newOption;
        }
        function dupeCheck($id){
           if(selectedList.length == 0) return false;
           let dupe = false;
            selectedList.forEach((x) => {
                if(x.id == $id) {dupe=true;}
            });
            return dupe;
        }
        function copyBook(){
            let numString = document.getElementById("quantity").value;
            if(numString==0){
                alert("Enter the quantity of books"); 
                return;
            }
            if(dupeCheck(selectedBook.id)){
                alert("Book already in request"); 
                return;
            }           

            if (selectedList.length == 0){
                requestList.removeChild(noBooks);
            }

            selectedBook.quantity = Number(numString);
            selectedList.push(selectedBook);
            
            let newOption = createOption(selectedBook)
            requestList.appendChild(newOption);            
        }
        function removeBook() {
            let index = selectedList.indexOf(requestID);
            selectedList.splice(index, 1);

            let option = document.getElementById("selected"+requestID);
            option.remove();
            // requestList.removeChild(option);

            if (selectedList.length == 0){
                requestList.appendChild(noBooks);
            }
        }

        function checkClass() {
            let cs = document.getElementById("classSelect");
            return cs.value == 0;
        }
        function submitRequest() {
            if(selectedList.length < 1){
                alert("Book Request list is empty!");
                return;
            }
            if(checkClass()){
                alert("Class needs to be selected");
                return;
            }
            const jsonList = JSON.stringify(selectedList);
            
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/orders') }}",
                data:{'bookList': jsonList},
                type:'post',
                success:  function (response) {
                    alert("Request created!");
                },
                error: function(x,xs,xt){
                    alert(x);

                }
            });
        }

    </script>
 @include('modals.new-book')

</x-app-layout>
