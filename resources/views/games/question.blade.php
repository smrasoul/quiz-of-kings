@props(['question', 'questionOptions'])

<x-layout>

    <x-center>

        <x-page-heading>

            <span>سوال</span>

        </x-page-heading>

        <div> {{ $question->text }} </div>
            <x-forms.form method="POST">

                <div class="row d-flex justify-content-evenly align-items-center">
                    @foreach($questionOptions as $questionOption)

                        <x-forms.radio class="py-5 my-4 col-5" name="selected_option_id" :value="$questionOption->id"
                                       color="outline-white" :label="$questionOption->text"/>

                    @endforeach
                </div>

                @error('selected_option_id')
                    <div class="form-text text-warning">انتخاب یک گزینه الزامی است.</div>
                @enderror

                <x-forms.button color="success" class="px-5">ثبت</x-forms.button>
            </x-forms.form>
    </x-center>

</x-layout>

