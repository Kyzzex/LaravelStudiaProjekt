<x-app-layout>
    <x-slot name="header">
        @if(isset($subject))
            <a href="{{ route('subjects.show', ['subject' => $subject->id]) }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex gap-x-4 w-auto">
                {{ $subject->name }}
            </a>
        @else
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Subject') }}
            </h2>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="post" action="{{ isset($subject) ? route('subjects.update', ['subject' => $subject->id]) : route('subjects.store') }}" class="flex flex-col gap-y-4" x-data=@json(['type' => isset($subject) ? $subject->subjectable_type : 'student'])>
                    @csrf
                    @if(isset($subject))
                        @method('PUT')
                    @endif

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Subject Information') }}
                    </h2>

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', isset($subject) ? $subject->name : '')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ isset($subject) ? __('Save') : __('Create') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
