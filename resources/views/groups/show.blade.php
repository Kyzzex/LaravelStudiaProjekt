<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('groups.show', ['group' => $group->id]) }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex gap-x-4 w-auto">
                {{ $group->name }}
            </a>
            @role('admin')
                <a href="{{ route('groups.edit', ['group' => $group->id]) }}">
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
                        {{ __('Group Information') }}
                    </h2>

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" type="text" class="mt-1 block w-full" :value="$group->name" required readonly />
                    </div>
                </div>
                <div class="flex flex-col gap-y-2 mt-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Students') }}
                    </h2>

                    <div class="flex flex-col gap-y-1">
                        @forelse($group->students as $student)
                            <div class="p-2 rounded flex justify-between items-center bg-gray-100 dark:bg-gray-900">
                                <a href="{{ route('users.show', ['user' => $student->user->id]) }}" class="text-indigo-400 hover:text-indigo-500 transition">{{ $student->user->name }}</a>
                                @role('admin')
                                    <form method="POST" class="flex items-center" action="{{ route('students.group.remove', ['student' => $student->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 text-red-500 hover:text-red-700 transition">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endrole
                            </div>
                        @empty
                            <div class="p-2 w-full rounded flex bg-gray-100 dark:bg-gray-900 text-gray-400 justify-center italic">
                                {{ __('No students found') }}
                            </div>
                        @endforelse
                    </div>
                    @role('admin')
                        <form class="flex gap-x-2" method="POST" action="{{ route('students.group.add') }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                            <div class="w-full">
                                <x-select-input :options="$addable_students->pluck('user.name', 'id')" id="student_id" name="student_id" class="block w-full" required first_empty></x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('student_id')" />
                            </div>
                            <x-primary-button class="h-[40px] my-px">{{ __('Add') }}</x-primary-button>
                        </form>
                    @endrole
                </div>

                <div class="flex flex-col gap-y-2 mt-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Subjects') }}
                    </h2>

                    <div class="flex flex-col gap-y-1">
                        @forelse($group->subjects as $subject)
                            <div class="p-2 rounded flex justify-between items-center bg-gray-100 dark:bg-gray-900">
                                <a href="{{ route('subjects.show', ['subject' => $subject->id]) }}" class="text-indigo-400 hover:text-indigo-500 transition">{{ $subject->name }}</a>
                                @role('admin')
                                    <form method="POST" class="flex items-center" action="{{ route('subjects.group.remove') }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                        <button type="submit" class="p-1 text-red-500 hover:text-red-700 transition">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endrole
                            </div>
                        @empty
                            <div class="p-2 w-full rounded flex bg-gray-100 dark:bg-gray-900 text-gray-400 justify-center italic">
                                {{ __('No subjects found') }}
                            </div>
                        @endforelse
                    </div>
                    @role('admin')
                        <form class="flex gap-x-2" method="POST" action="{{ route('subjects.group.add') }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                            <div class="w-full">
                                <x-select-input :options="$addable_subjects->pluck('name', 'id')" id="subject_id" name="subject_id" class="block w-full" required first_empty></x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('subject_id')" />
                            </div>
                            <x-primary-button class="h-[40px] my-px">{{ __('Add') }}</x-primary-button>
                        </form>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
