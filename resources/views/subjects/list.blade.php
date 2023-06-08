<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Subjects') }}
            </h2>
            @role('admin')
                <a href="{{ route('subjects.create') }}">
                    <x-primary-button type="button">{{ __('Create') }}</x-primary-button>
                </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ subjectDeletionId: null }">
            <x-table :columns="['#', __('Name'), '']" :full="__('Name')">
                @forelse($subjects as $subject)
                    <tr class="@if($loop->even) bg-white dark:bg-gray-800 @endif">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $subject->id }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                            <a href="{{ route('subjects.show', ['subject' => $subject->id]) }}">{{ $subject->name }}</a>
                        </td>
                        <td class="px-5 py-3 text-gray-900 dark:text-gray-100">
                            <div class="flex gap-x-1 items-center">
                                <a class="p-1 text-indigo-400 hover:text-indigo-500 transition" href="{{ route('subjects.show', ['subject' => $subject->id]) }}">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor">
                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
                                    </svg>
                                </a>
                                @role('admin')
                                    <a class="p-1 text-indigo-400 hover:text-indigo-500 transition" href="{{ route('subjects.edit', ['subject' => $subject->id]) }}">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </a>
                                    <div class="h-5 border-l border-gray-400 mx-1"></div>
                                    <button type="button" class="p-1 text-red-500 hover:text-red-700 transition" x-on:click.prevent="() => { subjectDeletionId = @js($subject->id); $dispatch('open-modal', 'confirm-subject-deletion')}">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                        </svg>
                                    </button>
                                @endrole
                            </div>
                        </td>
                    </tr>
                @empty
                    <td colspan="5" class="px-6 py-4 text-gray-900 dark:text-gray-100 italic text-center">
                        {{ __('No subjects found') }}
                    </td>
                @endforelse
            </x-table>
            <x-modal name="confirm-subject-deletion" focusable>
                <form method="post" :action="'/subjects/'+subjectDeletionId" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Subject\'s account and all data related to this subject will be deleted') }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3">
                            {{ __('Delete Subject') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</x-app-layout>
