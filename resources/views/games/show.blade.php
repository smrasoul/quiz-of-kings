@props(['game', 'round', 'userId'])


<x-layout>

    <x-nav/>

    <table class="table table-striped text-center">
        <thead>
        <tr>
            <th>{{$game->playerOne->name}}</th>
            <th>دسته‌بندی</th>
            <th>{{$game->playerTwo->name}}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>O X O</td>
            <td>VS</td>
            <td>O O X</td>
        </tr>
        <tr>
            <td>X O X</td>
            <td>VS</td>
            <td>O X O</td>
        </tr>
        <tr>
            <td>O O O</td>
            <td>VS</td>
            <td>X X O</td>
        </tr>
        </tbody>
    </table>

    <div class="text-center">
        @if($game->current_turn === $userId)
            <x-large-link-button href="/game/{{$game->id}}/round/{{$round->id}}" color="success">بازی کن</x-large-link-button>
        @else
            <x-large-link-button href="{{ request()->url() }}" color="cyan">نوبت حریف</x-large-link-button>
        @endif

    </div>


</x-layout>
