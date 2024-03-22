<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <span style="position: absolute;left:170px">
        <input type="{{ $type }}" class="form-control-range" placeholder="{{ $placeholder }}"
            name="{{ $name }}">
        <span class="errors">*
            @error($name)
                {{ $message }}
            @enderror
        </span></span>
</div>
