<ul class="nav justify-content-between py-2 px-0">


        <li class="nav-item">
            <x-small-link-button href="/dashboard" color="warning" class="fw-bold">ناحیه کاربری</x-small-link-button>
        </li>
    @if(request()->is('/'))
        <li class="nav-item">
            <form method="POST" action="/logout">
                @csrf
                @method('DELETE')
                <button class="btn btn-warning fw-bold">خروج از حساب کاربری</button>
            </form>
        </li>
    @else
        <li class="nav-item">
            <x-small-link-button href="/" color="warning">صفحه اصلی</x-small-link-button>
        </li>
    @endif

</ul>
