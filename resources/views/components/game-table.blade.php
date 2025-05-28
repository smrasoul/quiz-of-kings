@props(['games', 'userId'])

<div class="row mt-5 pt-5">
    <div class="row my-2 justify-content-center">
        {{ $slot }}
    </div>
    <div class="row justify-content-center text-center">
        <div class="col-8">
            <table class="table table-striped table-warning">
                <thead>
                <tr class="table">
                    <th scope="col">حریف</th>
                    <th scope="col">تاریخ</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                        <x-game-table-row :game="$game" :user-id="$userId">

                            @if($game->winner_id === $userId)
                                <p class="text-success fw-bold m-0">برنده</p>
                            @else
                                <p class="text-danger fw-bold m-0">بازنده</p>
                            @endif

                        </x-game-table-row>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
