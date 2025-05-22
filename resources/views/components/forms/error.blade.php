@props(['error' => false])

@if ($error)
    <div class="form-text text-warning">{{ $error }}</div>
@endif
