<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($grade) ? $subject->name.' - '.$student->user->name.' - '.$grade->grade : __('Add Grade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="post" action="{{ isset($grade) ? route('grades.update', ['grade' => $grade->id]) : route('grades.store') }}" class="flex flex-col gap-y-4">
                    @csrf
                    @if(isset($grade))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">

                    <div>
                        <x-input-label for="grade" :value="__('Grade')" />
                        <x-select-input id="grade" name="grade" type="text" class="mt-1 block w-full" required>
                            @foreach($acceptedGrades as $gradeOption)
                                <option value="{{ $gradeOption }}" @if(isset($grade) && $grade->grade === $gradeOption) selected @endif>
                                    <x-grade :grade="$gradeOption" translate />
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('grade')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ isset($grade) ? __('Save') : __('Create') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
