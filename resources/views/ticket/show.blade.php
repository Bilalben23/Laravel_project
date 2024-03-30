<x-app-layout>

    <h1 class="text-center text-white m-4">{{ $ticket->title }} </h1>
    <section class="text-center mb-2">

        <div class="text-white p-3">

            <p>{{ $ticket->created_at->diffForHumans() }}</p>
            <p>{{ $ticket->description }}</p>
            @if ($ticket->attachment)
                <a href="/storage/{{ $ticket->attachment }}" target="_blank">
                    <img src="/storage/{{ $ticket->attachment }}" alt="{{ $ticket->title }}" width="200px">
                </a>
            @endif
            <div class="flex align-middle justify-between mt-2">
                <a href="{{ route('ticket.edit', ['ticket' => $ticket]) }}"
                    class="bg-white text-black p-1 border-r-4">Edit</a>
                <form action="{{ route('ticket.destroy', $ticket) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white p-1 border-r-4">Delete</button>
                </form>
            </div>
            @if (auth()->user()->isAdmin)
                <div class="flex align-middle justify-between mt-3">
                    <form action="{{ route('ticket.update', ['ticket' => $ticket]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="resolved">
                        @error('status')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="bg-white text-black p-1 border-r-4">Approve</button>
                    </form>
                    <form action="{{ route('ticket.update', ['ticket' => $ticket]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        @error('status')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="bg-white text-black p-1 border-r-4">Reject</button>
                    </form>
                </div>
            @else
                <p class="text-white">Status: {{ $ticket->status }}</p>
            @endif

        </div>
    </section>

</x-app-layout>
