<?php

use App\Http\Controllers\ProfileController;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Profile\AvatorController;
use App\Http\Controllers\TicketController;
use OpenAI\Laravel\Facades\OpenAI;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return view("welcome");
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch("/profile/avator", [AvatorController::class, "update"])->name("profile.avator");
    Route::post("/profile/avator/ai", [AvatorController::class, "generate"])->name("profile.avator.ai");
});



Route::middleware("auth")->group(function () {
    Route::resource("/ticket", TicketController::class)
        ->name("index", "ticket.index");

});




require __DIR__.'/auth.php';


Route::post('/auth/redirect', function () {
   return Socialite::driver('github')->redirect();
})->name("login.github");

Route::get('/auth/callback', function () {
    $user = Socialite::driver("github")->user();

    $user = User::firstOrCreate(["email"=> $user->email], [
        "name" => $user->name,
        "password" => $user->password,
    ]);

    Auth::login($user);

    return redirect("/dashboard");
});