<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            User Avatar
        </h2>
        <div >
            <img width="100px" height="100px" class="rounded-full" src="{{"/storage/$user->avator"}}" alt="your avator image">
        </div>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Generate avatar from AI
        </p>


        <form action="{{route("profile.avator.ai")}}" method="POST" class="mt-4">
            {{csrf_field()}}
            <x-primary-button>{{__("Generate Avatar")}}</x-primary-button>

        </form>

        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400"> OR
        </p>

    </header>

    <form method="post" action="{{ route('profile.avator') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avator" :value="__('Upload Avatar From Computer')" />
            <x-text-input id="avator" name="avator" type="file" accept=".png, .jpg, .jpeg" class="mt-1 block w-full" :value="old('avator', $user->avator)" required autofocus autocomplete="avotor" />
            <x-input-error class="mt-2" :messages="$errors->get('avator')" />
        </div>

        @if (session('message'))
            <div class="text-red-500">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
