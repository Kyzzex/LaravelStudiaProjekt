@props(['grade', 'translate' => false])

@php
    $translations = collect([
        '1.5' => '1+',
        '1.75' => '2-',
        '2.5' => '2+',
        '2.75' => '3-',
        '3.5' => '3+',
        '3.75' => '4-',
        '4.5' => '4+',
        '4.75' => '5-',
        '5.5' => '5+',
        '5.75' => '6-',
    ]);
    $mark = $grade instanceof \App\Models\Grade ? (string) $grade->grade : (string) $grade;
    if($translate) {
        $mark = $translations->has($mark) ? $translations[$mark] : $mark;
    }
@endphp

<div {{ $attributes->merge(['class' => 'bg-indigo-600 text-white font-bold px-2 py-1 rounded text-center min-w-[32px]']) }}>
    {{ $mark }}
</div>
