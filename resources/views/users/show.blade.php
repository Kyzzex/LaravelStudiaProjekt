<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('users.show', ['user' => $user->id]) }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex gap-x-4 w-auto">
                <x-user-role-icon :role="$user->userable_type"></x-user-role-icon> {{ $user->name }}
            </a>
            @role('admin')
                <a href="{{ route('users.edit', ['user' => $user->id]) }}">
                    <x-primary-button type="button">{{ __('Edit') }}</x-primary-button>
                </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex flex-col gap-y-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Profile Information') }}
                    </h2>

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" type="text" class="mt-1 block w-full" :value="$user->name" required readonly />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" class="mt-1 block w-full" :value="$user->email" required readonly />
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Type')" />
                        <x-text-input id="type" type="text" class="mt-1 block w-full" :value="$user->userable_type" required readonly />
                    </div>

                    @if($user->hasRole('student'))
                        <div>
                            <x-input-label for="group" :value="__('Group')" />
                            <x-text-input id="group" type="text" class="mt-1 block w-full" :value="$user->userable->group->name" required readonly />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
