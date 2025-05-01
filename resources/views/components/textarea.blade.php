@props(['name', 'label', 'required', 'placeholder'])
<div class="mb-32">
    <label for="{{ $name }}" class="text-neutral-900 text-lg mb-8 font-[500]">
        {{ $label }}
        @if ($required)
            <span class="text-danger-600">*</span>
        @endif
    </label>
    <textarea id="{{ $name }}" class="common-input rounded-8" placeholder="{{ $placeholder }}"
        {{ $attributes }} @if ($required) required @endif></textarea>
    @error($name)
        <span class="text-danger-600">{{ $message }}</span>
    @enderror
</div>
