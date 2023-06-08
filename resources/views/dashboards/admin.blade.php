<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-y-4">
                @foreach($groups as $group)
                    <div class="text-gray-900 dark:text-gray-100">
                        <span class="text-xl font-bold">
                            {{ $group->name }}
                        </span>
                        <div class="flex flex-wrap gap-4">
                            @foreach($group->subjects as $subject)
                                <a href="{{ route('grades.index', ['group' => $group->id, 'subject' => $subject->id]) }}" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded whitespace-nowrap">{{ $subject->name }}</a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
