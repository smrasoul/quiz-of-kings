@props(['game', 'round', '$categories'])

<x-layout>
    <x-nav/>

    <x-center>

        <p>یکی از دسته بندی‌های زیر را انتخاب کنید:</p>

        <x-forms.form method="POST">

        @foreach($categories as $category)
                <x-forms.radio name="category" :variable="$category" color="outline-white" :label="$category->name" />
        @endforeach

            <x-forms.button color="success">شروع بازی</x-forms.button>

        </x-forms.form>

    </x-center>

</x-layout>
