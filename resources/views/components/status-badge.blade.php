@props([
    'status',
])

<flux:badge :color="$status->color()" size="sm" :icon="$status->icon()">
    {{ $status->label() }}
</flux:badge>
