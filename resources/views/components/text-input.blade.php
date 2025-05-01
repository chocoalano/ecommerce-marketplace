@props(['name', 'label', 'required', 'type', 'placeholder'])
<div class="mb-24">
    <label for="{{ $name }}" class="text-neutral-900 text-lg mb-8 font-[500]">
        {{ $label }}
        @if ($required)
            <span class="text-danger-600">*</span>
        @endif
    </label>
    <input id="{{ $name }}" type="{{ $type }}" class="common-input" placeholder="{{ $placeholder }}"
        {{ $attributes }} @if ($required) required @endif>
    @error($name)
        <span class="text-danger-600">{{ $message }}</span>
    @enderror
</div>
