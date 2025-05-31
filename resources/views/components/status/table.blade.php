@props(['game', 'roundAnswers', 'round', 'userId'])

<div class="row mt-4 pt-5">
    <div class="row my-2 justify-content-center">
        {{ $slot }}
    </div>
    <div class="row justify-content-center text-center">
        <div class="col-8">
            <table class="table table-striped table-warning">
                <thead>
                <tr class="table">
                    <th scope="col">سوال</th>
                    <th scope="col">پاسخ شما</th>
                    <th scope="col">وضعیت</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roundAnswers as $roundAnswer)
                    <tr>
                        <x-status.table-row :game="$game" :roundAnswer="$roundAnswer" :round="$round" :userId="$userId" />
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>
