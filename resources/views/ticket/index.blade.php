<x-app-layout>

    <h1 class="text-center text-white m-4">Support Tickets:</h1>

    <section class="flex justify-center align-middle text-white flex-col flex-none w-1/2 mr-auto gap-5">
        @forelse ($tickets as $ticket)
            <div>
                <a href="{{ route('ticket.show', ['ticket' => $ticket]) }}"
                    class="flex justify-between  border border-sky-500 p-6 w-full">
                    <p>{{ $ticket->title }}</p>
                    <p>{{ $ticket->created_at->diffForHumans() }}</p>
                    <p>status: {{ $ticket->status }}</p>
                </a>
                <div class="flex align-middle justify-between">
                    <a href="{{ route('ticket.edit', ['ticket' => $ticket]) }}">Edit</a>
                    <form action="{{ route('ticket.destroy', $ticket) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No tickets to show</p>
        @endforelse
    </section>

</x-app-layout>
