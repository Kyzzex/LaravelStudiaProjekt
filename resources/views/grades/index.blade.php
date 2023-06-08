<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $group->name }} - {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-table :columns="[__('Student'), __('Grades'), __('Average')]" :full="__('Grades')">
                @forelse($group->students as $student)
                    <tr class="@if($loop->even) bg-white dark:bg-gray-800 @endif">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 whitespace-nowrap">{{ $student->user->name }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                            <div class="flex gap-x-1">
                                @foreach($grades->has($student->id) ? $grades[$student->id] : [] as $grade)
                                    <a href="{{ route('grades.show', ['grade' => $grade->id]) }}">
                                        <x-grade :grade="$grade" translate></x-grade>
                                    </a>
                                @endforeach
                                <x-grade-add :subject="$subject->id" :student="$student->id"></x-grade-add>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                            @if($grades->has($student->id) && count($grades[$student->id]))
                                <x-grade :grade="$grade">{{ $grades[$student->id]->pluck('grade')->average() }}</x-grade>
                            @endif
                        </td>
                    </tr>
                @empty
                    <td colspan="5" class="px-6 py-4 text-gray-900 dark:text-gray-100 italic text-center">
                        {{ __('No grades found') }}
                    </td>
                @endforelse
            </x-table>
        </div>
    </div>
</x-app-layout>
