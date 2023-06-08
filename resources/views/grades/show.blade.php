<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $grade->subject->name.' - '.$grade->student->user->name }}
            </h2>
            @role('admin', 'teacher')
                <a href="{{ route('grades.edit', ['grade' => $grade->id, 'student' => $grade->student_id, 'subject' => $grade->subject_id]) }}">
                    <x-primary-button type="button">{{ __('Edit') }}</x-primary-button>
                </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex flex-col gap-y-4">
                    <div class="flex items-center justify-between gap-2">
                        <x-grade :grade="$grade" translate />
                        <span class="text-white font-bold whitespace-nowrap">{{ $grade->creator->user->name }}</span>
                        <div class="flex justify-end w-full text-gray-400 text-xs">{{ $grade->updated_at }}</div>
                    </div>
                </div>
                <div class="flex flex-col gap-y-2 mt-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('History') }}
                    </h2>

                    <div class="flex flex-col gap-y-1">
                        @forelse($grade->history->sortByDesc('created_at') as $gradeHistory)
                            <div class="flex items-center justify-between gap-2">
                                <x-grade :grade="$gradeHistory->from" class="bg-gray-600" translate />
                                <span class="text-white font-bold whitespace-nowrap">{{ $gradeHistory->creator->user->name }}</span>
                                <div class="flex justify-end w-full text-gray-400 text-xs">{{ $gradeHistory->created_at }}</div>
                            </div>
                        @empty
                            <div class="p-2 w-full rounded flex bg-gray-100 dark:bg-gray-900 text-gray-400 justify-center italic">
                                {{ __('No changes found') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
