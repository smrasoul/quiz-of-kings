@props(['completedGames', 'userId'])


<x-layout>

    <x-nav/>

    <div class="text-center">
        <x-page-heading class="">بازی‌ها</x-page-heading>
    </div>

    <x-game-table :games="$completedGames" :userId="$userId">
        <div class="col-8">
            <h5>بازی‌های اخیر</h5>
        </div>
    </x-game-table>

</x-layout>
