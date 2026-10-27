@props([
    'complaint',
])

@php
    $tone = [
        'baru' => 'bg-blue-50 text-blue-600 ring-blue-100',
        'diverifikasi' => 'bg-sky-50 text-sky-600 ring-sky-100',
        'diproses' => 'bg-amber-50 text-amber-600 ring-amber-100',
        'selesai' => 'bg-green-50 text-green-600 ring-green-100',
        'ditolak' => 'bg-red-50 text-red-600 ring-red-100',
    ];

    $entries = $complaint->updates;
    $lastEntry = $entries->last();
@endphp

<div class="relative">
    <div class="absolute bottom-4 left-[19px] top-4 w-px bg-navy-100"></div>

    <ol class="space-y-6">
        <li class="relative flex gap-4">
            <span class="relative z-10 inline-flex size-10 shrink-0 items-center justify-center rounded-full bg-navy-50 text-navy-700 ring-4 ring-white">
                <flux:icon.paper-airplane class="size-4" />
            </span>
            <div class="pt-0.5">
                <div class="flex flex-wrap items-center gap-2">
                    <p class="text-sm font-semibold text-navy-950">Pengaduan dikirim</p>
                    <span class="text-xs text-navy-400">{{ $complaint->created_at->translatedFormat('d M Y, H.i') }} WIB</span>
                </div>
                <p class="mt-1 text-sm leading-6 text-navy-600">Pengaduan tercatat di sistem SIPADU dan menunggu ditinjau oleh admin kampus.</p>
            </div>
        </li>

        @foreach ($entries as $entry)
            <li class="relative flex gap-4" wire:key="update-{{ $entry->id }}">
                <span @class([
                    'relative z-10 inline-flex size-10 shrink-0 items-center justify-center rounded-full ring-4 ring-white',
                    $tone[$entry->status?->value ?? 'baru'] ?? 'bg-navy-50 text-navy-600 ring-navy-100',
                ])>
                    <flux:icon :name="$entry->status?->icon() ?? 'chat-bubble-left-right'" class="size-4" />
                </span>
                <div class="pt-0.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="text-sm font-semibold text-navy-950">
                            {{ $entry->user_id ? 'Tanggapan Admin Kampus' : 'Pembaruan Sistem' }}
                        </p>
                        @if ($entry->status)
                            <flux:badge :color="$entry->status->color()" size="sm">{{ $entry->status->label() }}</flux:badge>
                        @endif
                        <span class="text-xs text-navy-400">{{ $entry->created_at->translatedFormat('d M Y, H.i') }} WIB</span>
                    </div>
                    @if (filled($entry->message))
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-navy-600">{{ $entry->message }}</p>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>

    @if ($lastEntry === null && $complaint->status !== \App\Enums\ComplaintStatus::Baru)
        <p class="mt-4 rounded-xl bg-navy-50 px-4 py-3 text-xs text-navy-500">
            Status terkini: <span class="font-semibold text-navy-800">{{ $complaint->status->label() }}</span>.
        </p>
    @endif
</div>
