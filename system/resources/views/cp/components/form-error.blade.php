@if($errors->has($field))

	<span class="invalid-feedback d-block">
        <strong>{{ $errors->first($field) }}</strong>
    </span>

@endif