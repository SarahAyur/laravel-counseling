@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm']) }}>
