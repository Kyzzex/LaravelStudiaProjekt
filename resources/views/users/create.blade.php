<x-app-layout>
    <x-slot name="header">
        @if(isset($user))
            <a href="{{ route('users.show', ['user' => $user->id]) }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex gap-x-4 w-auto">
                <x-user-role-icon :role="$user->userable_type"></x-user-role-icon> {{ $user->name }}
            </a>
        @else
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create User') }}
            </h2>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="post" action="{{ isset($user) ? route('users.update', ['user' => $user->id]) : route('users.store') }}" class="flex flex-col gap-y-4" x-data=@json(['type' => isset($user) ? $user->userable_type : 'student'])>
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Profile Information') }}
                    </h2>

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', isset($user) ? $user->name : '')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', isset($user) ? $user->email : '')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Type')" />
                        <x-select-input :options="['student' => __('Student'), 'teacher' => __('Teacher')]" id="type" name="type" class="mt-1 block w-full" :value="old('type', isset($user) ? $user->userable_type : '')" x-model="type" required></x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <div x-show="type === 'student'" @if(isset($user) && !$user->hasRole('student')) style="display: none" @endif>
                        <div>
                            <x-input-label for="group_id" :value="__('Group')" />
                            <x-select-input :options="$groups->pluck('name', 'id')" id="group_id" name="group_id" class="mt-1 block w-full" :value="old('group_id', isset($user) ? $user->userable->group_id : '')" required first_empty></x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('group_id')" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ isset($user) ? __('Save') : __('Create') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
