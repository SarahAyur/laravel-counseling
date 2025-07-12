@props(['options' => [], 'selected' => null])

<select {{ $attributes->merge(['class' => 'block mt-1 w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm']) }}>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
