@props(['start'])

<div
    x-data="{
        start: {{ $start }},
        elapsed: Math.floor(Date.now() / 1000) - {{ $start }},
        get formatted() {
            const mins = String(Math.floor(this.elapsed / 60)).padStart(2, '0');
            const secs = String(this.elapsed % 60).padStart(2, '0');
            return `${mins}:${secs}`;
        }
    }"
    x-init="
        setInterval(() => {
            elapsed = Math.floor(Date.now() / 1000) - start;
        }, 1000);
    "
    class="mt-2 text-white"
>
    زمان سپری شده: <span x-text="formatted"></span>
</div>
