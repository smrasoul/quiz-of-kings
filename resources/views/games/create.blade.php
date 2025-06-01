@props(['queue'])

<x-layout>

    <x-nav/>

    {{--

        if in queue show finding opponent

        else show button


     --}}
    <x-center>
        @if($queue->isEmpty())
            <x-forms.form method="POST" action="/game">
                <x-forms.button color="success">شروع بازی جدید</x-forms.button>
            </x-forms.form>
        @else
            <p>در حال جست‌وجو برای حریف...</p>
            <x-large-link-button color="primary" href="/game/create" >بررسی</x-large-link-button>
        @endif
    </x-center>
</x-layout>
