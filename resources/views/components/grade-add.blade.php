@props(['subject', 'student'])

<a href="{{ route('grades.create', ['student' => $student, 'subject' => $subject]) }}" {{ $attributes->merge(['class' => 'border text-gray-500 hover:text-indigo-400 border-gray-500 hover:border-indigo-500 transition border-2 border-dashed text-white font-bold p-1 rounded text-center']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
</a>
