<ul class="nav justify-content-between py-2 px-0">
    <li class="nav-item">
        <x-link-button href="/dashboard" color="warning">ناحیه کاربری</x-link-button>
    </li>
    <li class="nav-item">
        <form method="POST" action="/logout">
            @csrf
            @method('DELETE')
            <button class="btn btn-warning">خروج از حساب کاربری</button>
        </form>
    </li>
</ul>
