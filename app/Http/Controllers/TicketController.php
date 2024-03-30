<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\User;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{

    public function index()
    {
        // $tickets = Ticket::whereUser_id(auth()->user()->id)->get();
        $user = auth()->user();
        $tickets = $user->isAdmin? Ticket::latest()->get(): $user->tickets;

        return view("ticket.index", compact('tickets'));
    }

    public function create()
    {
        return view("ticket.create");
    }


    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            "title" => $request->title,
            "description" => $request->description,
            "user_id" => auth()->user()->id,
        ]);

        if ($request->file("attachment")) {
                $this->storeAttachment($request, $ticket);
        }

        return to_route("ticket.index")
            ->with("success-message", "The Ticket Has Been Created Successfully!");
    }

    public function show(Ticket $ticket)
    {
        if (!auth()->user()->isAdmin && auth()->user()->id !== $ticket->user_id) {
            abort(403);
        }
        return view("ticket.show", ["ticket" => Ticket::findOrFail($ticket->id)]);
    }

    public function edit(Ticket $ticket)
    {
        if (!auth()->user()->isAdmin && auth()->user()->id !== $ticket->user_id) {
            abort(403);
        }
        return view("ticket.edit", ["ticket" => Ticket::findOrFail($ticket->id)]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        if (!auth()->user()->isAdmin && auth()->user()->id !== $ticket->user_id) {
            abort(403);
        }

        if($request->has("status")) {
            $user = User::find($ticket->user_id);
            // $user->notify(new TicketUpdatedNotification($ticket));

            $user->notify(new TicketUpdatedNotification($ticket));

        };


        $ticket->update($request->except("attachment"));

        if ($request->file("attachment")) {

            // Delete old attachment file:
            Storage::disk("public")->delete($ticket->attachment);

            // store the new attachment:
            $this->storeAttachment($request, $ticket);
        }

        return to_route("ticket.index")
            ->with("success-message", "The Ticket Has Been Updated Successfully!");
    }

    // route model binding
    public function destroy(Ticket $ticket)
    {
        if (!auth()->user()->isAdmin && auth()->user()->id !== $ticket->user_id) {
            abort(403);
        }
        // Delete attachment file:
        Storage::disk("public")->delete($ticket->attachment);
        $ticket->delete();
        return to_route("ticket.index")
            ->with("success-message", "ticket deleted successfully!");
    }

    protected function storeAttachment($request, $ticket) {
        $fileExtension = $request->file("attachment")->extension();
        $customFileName = "attachment_of_" . auth()->user()->name . "_" . (count(Storage::disk("public")
            ->files("attachments"))+1).".$fileExtension";

        $path = $request->file("attachment")->storeAs(
            "attachments", $customFileName, "public"
        );

        $ticket->update([
            "attachment" => $path
        ]);
    }
}