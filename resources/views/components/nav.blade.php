<ul class="nav justify-content-between py-2 px-0">
    <li class="nav-item">
        <a class="btn btn-warning" href="/dashboard">ناحیه کاربری</a>
    </li>
    <li class="nav-item">
        <form method="POST" action="/logout">
            @csrf
            @method('DELETE')
            <button class="btn btn-warning">خروج از حساب کاربری</button>
        </form>
    </li>
</ul>
