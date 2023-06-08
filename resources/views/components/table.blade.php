@props(['columns', 'full'])

@if ($columns)
    <div class="w-full overflow-x-auto">
        <table class="w-full">
            <tr class="bg-indigo-600 overflow-hidden shadow-sm sticky top-0">
                @foreach($columns as $column)
                    <th class="p-6 text-gray-100 text-left @if($loop->first) rounded-l-lg @endif @if($loop->last) rounded-r-lg @endif @if(isset($full) && $full === $column) w-full @endif">{{ $column }}</th>
                @endforeach
            </tr>
            {{ $slot }}
        </table>
    </div>
@endif
