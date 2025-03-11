<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div>
        <div class="text-gray-800 dark:text-gray-200">
            <a style="margin-left:40%" href="{{ route('azure') }}">
                <x-primary-button>
                    Log in
                </x-primary-button>
            </a>
            <a style="margin-left:40%" href="{{ route('dev') }}">
                <x-primary-button>
                    Dev
                </x-primary-button>
            </a>
        </div>
    </div>
</x-guest-layout>
