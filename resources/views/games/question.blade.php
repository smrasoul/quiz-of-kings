@props(['question', 'order', 'questionOptions'])

<x-layout>

    <x-center>

        <x-page-heading>

            <span>سوال</span>
            <span>{{ $order }}</span>

        </x-page-heading>

        <div> {{ $question->text }} </div>
            <x-forms.form method="POST">
                <div class="row d-flex justify-content-evenly align-items-center">
                    @foreach($questionOptions as $questionOption)

                        <x-forms.radio class="py-5 my-4 col-5" name="selected_option_id" :variable="$questionOption" color="outline-white" :label="$questionOption->text"/>

                    @endforeach
                </div>
                <x-forms.button color="success" class="px-5">ثبت</x-forms.button>
            </x-forms.form>
    </x-center>

</x-layout>

