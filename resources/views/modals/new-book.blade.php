<form method="POST" action="{{ route('books') }}">
    @csrf  
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-black-900 dark:text-black-100">                    
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Add New Book') }}
                    </h2>
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="title" name="title" :value="old('title')" required autofocus autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Author -->
                    <div>
                        <x-input-label for="author" :value="__('Author')" />
                        <x-text-input id="author" class="block mt-1 w-full" type="author" name="author" :value="old('author')" autofocus autocomplete="author" />
                    </div>

                    <!-- Author -->
                    <div>
                        <x-input-label for="publisher" :value="__('Publisher')" />
                        <x-text-input id="publisher" class="block mt-1 w-full" type="publisher" name="publisher" :value="old('publisher')" required autofocus autocomplete="publisher" />
                    </div>

                    <!-- ISBN -->
                    <div>
                        <x-input-label for="isbn" :value="__('ISBN')" />
                        <x-text-input id="isbn" class="block mt-1 w-full" type="isbn" name="isbn" :value="old('isbn')" required autofocus autocomplete="isbn" />
                        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-3">
                            {{ __('Submit') }}
                        </x-primary-button>
                        <!-- <x-danger-button class="ms-3">
                            {{ __('Cancel') }}
                        </x-primary-button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</form
