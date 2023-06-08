@props(['disabled' => false, 'options' => [], 'value' => null, 'first_empty' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    @if($first_empty)
        <option value=""></option>
    @endif
    @foreach($options as $key => $option)
        <option value="{{ $key }}" @if($value === $key) selected @endif>{{ $option }}</option>
    @endforeach
    {{ $slot }}
</select>
