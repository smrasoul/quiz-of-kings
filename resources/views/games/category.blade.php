@props(['randomCategories'])

<x-layout>
    <x-nav/>

    <x-center>

        <p>یکی از دسته بندی‌های زیر را انتخاب کنید:</p>

        <x-forms.form method="POST">

            @foreach($randomCategories as $randomCategory)
                <x-forms.radio :label="$randomCategory->category->name" name="category_id"
                               :value="$randomCategory->category_id" color="outline-white"/>
            @endforeach

                @error('category_id')
                    <div class="form-text text-warning">{{ $message }}</div>
                @enderror


                <x-forms.button color="success">شروع بازی</x-forms.button>

        </x-forms.form>

    </x-center>

</x-layout>
