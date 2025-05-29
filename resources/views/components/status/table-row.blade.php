@props(['game', 'roundAnswer', 'round', 'userId'])

<td class="align-content-center">
    {{ $roundAnswer->question->text }}
</td>
<td class="align-content-center">
    {{ $roundAnswer->option->text }}
</td>
<td class="align-content-center">
    @if($roundAnswer->is_correct)
        <i class="bi bi-check-lg fs-3 text-success"></i>
    @else
        <i class="bi bi-x fs-2 text-danger"></i>
    @endif
</td>
