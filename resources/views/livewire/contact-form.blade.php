<div class="rounded-2xl border border-navy-100 bg-white p-5 shadow-sm sm:p-7">
    <div class="flex items-center gap-3 border-b border-navy-100 pb-5">
        <span class="inline-flex size-11 items-center justify-center rounded-xl bg-navy-900 text-gold-400">
            <flux:icon.envelope class="size-5" />
        </span>
        <div>
            <h2 class="text-base font-semibold text-navy-950">Kirim pesan</h2>
            <p class="text-xs text-navy-400">Kami akan merespons pada jam layanan kampus.</p>
        </div>
    </div>

    <form wire:submit="submit" class="mt-5 space-y-4">
        <div class="grid gap-4 sm:grid-cols-2">
            <flux:input wire:model="name" label="Nama lengkap" placeholder="Nama Anda" required autocomplete="name" />
            <flux:input wire:model="email" label="Email" type="email" placeholder="nama@email.com" required autocomplete="email" />
        </div>

        <flux:input wire:model="subject" label="Subjek" placeholder="Ringkasan pertanyaan atau kendala" required maxlength="150" />

        <flux:textarea wire:model="message" label="Pesan" placeholder="Tuliskan pertanyaan atau kendala Anda secara detail..." rows="6" required />

        <div class="hidden" aria-hidden="true">
            <label for="website">Website</label>
            <input id="website" type="text" wire:model="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="flex flex-col gap-3 border-t border-navy-100 pt-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="flex items-center gap-1.5 text-[11px] text-navy-400">
                <flux:icon.lock-closed class="size-3.5" />
                Data Anda hanya digunakan untuk keperluan komunikasi.
            </p>
            <flux:button type="submit" variant="primary" icon="paper-airplane" wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">Kirim Pesan</span>
                <span wire:loading wire:target="submit">Mengirim...</span>
            </flux:button>
        </div>
    </form>
</div>
