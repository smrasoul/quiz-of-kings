<x-layout>

    <x-center>

        <x-page-heading> ثبت نام</x-page-heading>

        <x-forms.form class="w-25" method="POST" action="/register" enctype="multipart/form-data">
            <x-forms.input label="نام" name="name"/>
            <x-forms.input label="پست الکترونیکی" name="email" type="email"/>
            <x-forms.input label="رمز عبور" name="password" type="password"/>
            <x-forms.input label="تکرار رمز عبور" name="password_confirmation" type="password"/>

            <x-forms.button color="warning">ثبت نام</x-forms.button>
        </x-forms.form>

        <div class="mt-3">
            <span>قبلا ثبت نام کرده اید؟</span>
            <a class="link-warning" href="/login">ورود</a>
        </div>

    </x-center>

</x-layout>

