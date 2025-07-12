@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'mt-1 block w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm']) !!}>{{ $slot }}</textarea>
