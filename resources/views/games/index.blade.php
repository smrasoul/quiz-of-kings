@props(['games'])


<x-layout>

    <x-nav/>

    <x-center>
        <x-page-heading class="">بازی‌ها</x-page-heading>
    </x-center>

    @if($games)
        <div class="row d-flex justify-content-evenly text-center">
            @foreach($games as $game)
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">آخرین تغییر:</h5>
                            <p class="card-text">
                                {{ $game->updated_at }}
                            </p>
                            <x-large-link-button color="success my-3" href="game/{{ $game->id }}">
                                ادامه بازی
                            </x-large-link-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- start the matchmaking --}}
    @endif

</x-layout>
