@props(['name', 'label', 'required'])
<div class="mb-24 mt-48">
    <div class="form-check common-check">
        <input class="form-check-input" type="checkbox" {{ $attributes }} id="{{ $name }}" name="{{ $name }}" required="{{ $required }}">
        <label class="form-check-label flex-grow" for="{{ $name }}">
            $label
        </label>
    </div>
    @error($name)
        <span class="text-danger-600">{{ $message }}</span>
    @enderror
</div>
