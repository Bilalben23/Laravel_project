<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Str;

class AvatorController extends Controller
{

    public function update(UpdateAvatorRequest $request) {
        $path = $request->file("avator")->store("avatars", "public");

        if($oldAvatar = $request->user()->avator) {
            Storage::disk("public")->delete($oldAvatar);
        }

        auth()->user()->update(["avator" => $path]);


        return redirect(route("profile.edit"))
            ->with("message", "Avatar is updated!");
    }


    public function generate(Request $request) {

        $result = OpenAI::images()->create([
            "prompt" => "Create an avatar for user",
            "n" => 1,
            "size" => "256x256",
        ]);

        $contents = file_get_contents( $result->data[0]->url);

        $filename = Str::random(25);


        if($oldAvatar = $request->user()->avator) {
            Storage::disk("public")->delete($oldAvatar);
        }

        Storage::disk("public")->put("avatars/$filename.jpg", $contents);

        auth()->user()->update(["avator" => "avatars/$filename.jpg"]);


        return redirect(route("profile.edit"))
            ->with("message", "Avatar is updated!");


    }
}