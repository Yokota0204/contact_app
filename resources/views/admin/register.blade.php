<x-guest-layout>
  <x-auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
      </a>
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('admin.register') }}">
      @csrf

      <!-- Name -->
      <div>
        <x-label for="name" value="{{ __('auth.form.name') }}" />
        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
      </div>

      <!-- Email Address -->
      <div class="mt-4">
        <x-label for="email" :value="__('auth.form.email')" />
        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
      </div>
      <div class="mt-4">
        <x-label for="tel_no" :value="__('auth.form.tel_no')" />
        <x-input id="tel_no" class="block mt-1 w-full" type="text" name="tel_no" :value="old('tel_no')" />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-label for="password" :value="__('auth.form.password')" />
        <x-input id="password" class="block mt-1 w-full"
          type="password"
          name="password"
          required autocomplete="new-password"/>
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
        <x-label for="password_confirmation" :value="__('auth.form.password_confirmed')" />
        <x-input id="password_confirmation" class="block mt-1 w-full"
          type="password"
          name="password_confirmation" required />
      </div>

      <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.login') }}">
          {{ __('already_registered') }}
        </a>

        <x-button class="ml-4">
          {{ __('register') }}
        </x-button>
      </div>
    </form>
  </x-auth-card>
</x-guest-layout>
