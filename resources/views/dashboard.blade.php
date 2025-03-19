<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2> -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table style="width:90% padding-bottom">
                        <thead style="text-align: left;">
                        <tr>
                            <th>Request #</th>
                            <th>Status</th>
                            <th>Course</th>
                            <th># of Titles</th>
                        </tr>
                        <thead>
                        <tbody>
                            @if ($request->count() >= 1)
                            @foreach ($request as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('user.request', $item->id) }}" style="text-decoration: underline">
                                        {{ $item->id }}
                                    </a>
                                </td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->class }}</td>
                                <td>{{ $item->titles }}</td>
                            </tr> 
                            @endforeach
                            @else
                            <tr>
                                <td> No Open Requests</td>
                                <td> .... </td>
                                <td> .... </td>
                                <td> .... </td>
                            </tr>  
                            @endif

                        </tbody>
                    </table>
                    <a href="{{ url('/books') }}">
                        <x-primary-button>
                            Make a Request
                        </x-primary-button>
                    </a>
                    <a href="{{ url('/orders') }}">
                        <x-primary-button>
                            View Book Requests
                        </x-primary-button>
                    </a>
                </div>                
            </div>
        </div>
    </div>
</x-app-layout>
