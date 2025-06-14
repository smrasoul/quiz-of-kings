@props(['games', 'completedGames', 'userId'])


<x-layout>

    <x-nav/>

    <div class="text-center">
        <x-page-heading class="">Quiz of Kings</x-page-heading>
    </div>

    @if($games->isNotEmpty())
        <div class="row d-flex justify-content-evenly">
            @foreach($games as $game)
                <x-game-card :game="$game"/>
            @endforeach
        </div>
    @else
        <div class="text-center">
            <x-large-link-button color="success" href="/game/create">بازی جدید</x-large-link-button>
        </div>
    @endif

    <x-history.table :games="$completedGames" :userId="$userId">
        <div class="col-4">
            <h5>بازی‌های اخیر</h5>
        </div>
        <div class="col-4 d-flex justify-content-end">
            <x-small-link-button href="/games" color="warning">تاریخچه‌ی بازی‌ها</x-small-link-button>
        </div>
    </x-history.table>

</x-layout>
