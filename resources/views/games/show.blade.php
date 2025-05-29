@props(['game', 'rounds', 'userId'])


<x-layout>

    <x-nav/>

    <table class="table table-striped table-warning text-center mt-5">
        <thead >
        <tr class="table">
            <th> راند </th>
            <th>{{$game->playerOne->name}}</th>
            <th>دسته‌بندی</th>
            <th>{{$game->playerTwo->name}}</th>
            <th>وضعیت</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rounds as $round)

            @php
                $playerOneAnswers = $round->roundAnswers()
                ->where('user_id', $round->game->player_one_id)
                ->get();

            $playerTwoAnswers = $round->roundAnswers()
                ->where('user_id', $round->game->player_two_id)
                ->get();
            @endphp

            <tr>
                <th scope="row" class="align-content-center"> {{ $round->round_number }} </th>
                <td class="align-content-center">
                    @foreach($playerOneAnswers as $playerOneAnswer)
                        @if($playerOneAnswer && $playerOneAnswer->is_correct)
                            <i class="bi bi-check-lg fs-3 text-success"></i>
                        @elseif($playerOneAnswer && !$playerOneAnswer->is_correct)
                            <i class="bi bi-x fs-2 text-danger"></i>
                        @else

                        @endif
                    @endforeach
                </td>
                <td class="align-content-center"> {{ $round->category->name ?? "انتخاب نشده" }} </td>
                <td class="align-content-center">

                    @foreach($playerTwoAnswers as $playerTwoAnswer)
                        @if($playerTwoAnswer && $playerTwoAnswer->is_correct)
                            <i class="bi bi-check-lg fs-3 text-success"></i>
                        @elseif($playerTwoAnswer && !$playerTwoAnswer->is_correct)
                            <i class="bi bi-x fs-2 text-danger"></i>
                        @else

                        @endif
                    @endforeach

                </td>
                <td class="align-content-center">

                    @if(!$round->status && $game->current_turn === $userId)
                        <x-small-link-button href="/game/{{$game->id}}/round/{{$round->id}}" color="success">بازی کن</x-small-link-button>
                    @elseif(!$round->status && $game->current_turn !== $userId)
                        <x-small-link-button href="{{ request()->url() }}" color="cyan">نوبت حریف</x-small-link-button>
                    @else
                        <x-small-link-button color="warning" href="/game/{{ $game->id }}/round/{{ $round->id }}/status">مشاهده</x-small-link-button>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(empty($round->category) && $game->current_turn === $userId )

    @endif



    <div class="d-flex justify-content-center">
        @if($game->status && $game->winner_id === Auth::id())
            <h2 class="text-bg-warning text-success p-3 rounded" >برنده شدی!</h2>
        @elseif($game->status && $game->winner_id !== Auth::id())
            <h2 class="text-bg-warning text-danger p-3 rounded" >باختی!</h2>
        @endif
    </div>




</x-layout>
