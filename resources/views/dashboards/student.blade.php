<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ groupDeletionId: null }">
            <x-table :columns="[__('Subject'), __('Grades'), __('Average')]" :full="__('Grades')">
                @forelse($subjects as $subject)
                    <tr class="@if($loop->even) bg-white dark:bg-gray-800 @endif">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 whitespace-nowrap">{{ $subject->name }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                            <div class="flex gap-x-1">
                                @foreach($subject->grades as $grade)
                                    <a href="{{ route('grades.show', ['grade' => $grade->id]) }}">
                                        <x-grade :grade="$grade" translate></x-grade>
                                    </a>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                            @if(count($subject->grades))
                                <x-grade :grade="$grade">{{ $subject->grades->pluck('grade')->average() }}</x-grade>
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
