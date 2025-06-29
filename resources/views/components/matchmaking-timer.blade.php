@props(['start'])

<div
    x-data="{
        startTime: {{ $start }},
        elapsed: 0,
        get formatted() {
            const mins = String(Math.floor(this.elapsed / 60)).padStart(2, '0');
            const secs = String(this.elapsed % 60).padStart(2, '0');
            return `${mins}:${secs}`;
        }
    }"
    x-init="
        setInterval(() => {
            elapsed = Math.floor(Date.now() / 1000) - startTime;
        }, 1000)
    "
    class="mt-3 text-muted"
>
    زمان سپری‌شده: <span x-text="formatted"></span>
</div>
