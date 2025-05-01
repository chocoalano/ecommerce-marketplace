@props(['name', 'label', 'required', 'placeholder'])
<div class="mb-24">
    <label for="{{ $name }}" class="text-neutral-900 text-lg mb-8 font-[500]">
        {{ $label }}
        @if ($required)
            <span class="text-danger-600">*</span>
        @endif
    </label>
    <div class="relative">
        <input type="password" class="common-input" id="enter-password" {{ $attributes }} placeholder="{{ $placeholder }}"
            @if ($required) required @endif>
        <span class="toggle-password absolute top-[50%] right-0 me-16 translate-y-[-50%] cursor-pointer ph ph-eye-slash"
            id="#enter-password"></span>
    </div>
    @error($name)
        <span class="text-danger-600">{{ $message }}</span>
    @enderror
</div>
