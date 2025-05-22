<x-layout>

    <x-auth>

        <x-page-heading>ورود به حساب کاربری</x-page-heading>

        <x-forms.form method="POST" Action="/login">
            <x-forms.input label="ایمیل" name="email" type="email"/>
            <x-forms.input label="رمز عبور" name="password" type="password"/>

            <x-forms.button>ورود</x-forms.button>
        </x-forms.form>

        <div class="mt-3">
            <span>هنوز ثبت نام نکرده اید؟</span>
            <a class="link-warning" href="/register">ثبت نام</a>
        </div>

    </x-auth>



</x-layout>
