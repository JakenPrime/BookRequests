<x-app-layout>
    <x-slot name="header">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Requests
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table style="width:90%">
                        <thead style="text-align: left;">
                        <tr>
                            <th>Request #</th>
                            <th>Status</th>
                            <th>Course</th>
                            <th># of Titles</th>
                        </tr>
                        <thead>
                        <tbody>
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
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>
</x-app-layout>
