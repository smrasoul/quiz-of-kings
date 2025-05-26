@props(['game', 'rounds', 'userId'])


<x-layout>

    <x-nav/>

    <table class="table table-striped text-center mt-5">
        <thead>
        <tr>
            <th> راند </th>
            <th>{{$game->playerOne->name}}</th>
            <th>دسته‌بندی</th>
            <th>{{$game->playerTwo->name}}</th>
            <th>وضعیت</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rounds as $round)
            <tr>
                <th scope="row"> {{ $round->round_number }} </th>
                <td> پاسخ های پلیر اول</td>
                <td> {{ $round->category->name ?? "انتخاب نشده" }} </td>
                <td> پاسخ های پلیر دوم</td>
                <td>

                    @if(!$round->status && $game->current_turn === $userId)
                        <x-small-link-button href="/game/{{$game->id}}/round/{{$round->id}}" color="success">بازی کن</x-small-link-button>
                    @elseif(!$round->status && $game->current_turn !== $userId)
                        <x-small-link-button href="{{ request()->url() }}" color="cyan">نوبت حریف</x-small-link-button>
                    @else
                        تمام شده
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(empty($round->category) && $game->current_turn === $userId )

    @endif

 {{--

    <div class="text-center">
        @if($game->current_turn === $userId)

    </div>

 --}}


</x-layout>
