<x-layout>

    <x-center>

        <x-page-heading>ورود به حساب کاربری</x-page-heading>

        <x-forms.form class="w-25" method="POST" Action="/login">
            <x-forms.input label="ایمیل" name="email" type="email"/>
            <x-forms.input label="رمز عبور" name="password" type="password"/>

            <x-forms.button color="warning" class="w-50">ورود</x-forms.button>
        </x-forms.form>

        <div class="mt-3">
            <span>هنوز ثبت نام نکرده اید؟</span>
            <a class="link-warning" href="/register">ثبت نام</a>
        </div>

    </x-center>



</x-layout>
