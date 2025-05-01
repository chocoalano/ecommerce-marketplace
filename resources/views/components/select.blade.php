@props(['name', 'label', 'required', 'options'])
<div>
    <label for="{{ $name }}" class="text-gray-900 font-heading-two"> {{ Str::limit($label, 25, '...') }} </label>

    <div class="relative mt-1.5">
        <select name="{{ $name }}" id="{{ $name }}" class="common-input" {{ $attributes }} @if ($required) required @endif>
            @foreach ($options as $k)
                <option value="{{ $k['value'] }}">{{ $k['label'] }}</option>
            @endforeach
        </select>
    </div>
    @error($name)
        <span class="text-danger-600">{{ $message }}</span>
    @enderror
</div>
