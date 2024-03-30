<x-app-layout>


    <h1 class="text-center text-white m-4">Edit a tikcet:</h1>
    <form action="{{ route('ticket.update', $ticket) }}" method="POST" class="m-auto p-7" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <x-text-input name="title" placeholder="Title...." value="{{ $ticket->title }}" />
            @error('title')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-2">
            <x-text-area name="description" placeholder="Description....">{{ $ticket->description }}</x-text-area>
            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-2">
            @if ($ticket->attachment)
                <img src="/storage/{{ $ticket->attachment }}" alt="{{ $ticket->title }}" width="100"
                    class="block mb-2" />
            @endif
            <input type="file" name="attachment"
                class='border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'>
            @error('attachment')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-5">
            <x-primary-button>
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>


</x-app-layout>
