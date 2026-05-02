<div class="space-y-6">
    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
        FAQ di homepage dibatasi maksimal <strong>4 item</strong> agar tampilan index tetap ringkas dan konsisten.
    </div>

    @if(! $faqLimitReached)
        <form method="POST" action="{{ route('doctor.settings.faq.store') }}" class="grid gap-5">
            @csrf
            <div class="grid gap-5 md:grid-cols-2">
                <div class="field"><label>Pertanyaan</label><input name="pertanyaan"></div>
                <div class="field"><label>Urutan</label><input type="number" name="urutan" value="1"></div>
            </div>
            <div class="field"><label>Jawaban</label><textarea name="jawaban" rows="4"></textarea></div>
            <div class="field"><label>Status Tampil</label><select name="status_tampil"><option value="1">Tampil</option><option value="0">Sembunyikan</option></select></div>
            <div><button class="rounded-md bg-teal-700 px-5 py-3 text-sm font-medium text-white hover:bg-teal-800" type="submit">Tambah FAQ</button></div>
        </form>
    @else
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-700">
            Jumlah FAQ sudah 4 item. Hapus salah satu FAQ jika ingin menambahkan yang baru.
        </div>
    @endif

    <div class="space-y-4">
        @forelse($faqList as $item)
            <div class="rounded-xl border border-slate-200 p-4">
                <form method="POST" action="{{ route('doctor.settings.faq.update', $item) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="field"><label>Pertanyaan</label><input name="pertanyaan" value="{{ $item->pertanyaan }}"></div>
                        <div class="field"><label>Urutan</label><input type="number" name="urutan" value="{{ $item->urutan }}"></div>
                    </div>
                    <div class="field"><label>Jawaban</label><textarea name="jawaban" rows="4">{{ $item->jawaban }}</textarea></div>
                    <div class="field"><label>Status Tampil</label><select name="status_tampil"><option value="1" @selected($item->status_tampil)>Tampil</option><option value="0" @selected(! $item->status_tampil)>Sembunyikan</option></select></div>
                    <button class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700" type="submit">Update FAQ</button>
                </form>
                <form method="POST" action="{{ route('doctor.settings.faq.destroy', $item) }}" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-md border border-rose-200 px-4 py-2 text-sm font-medium text-rose-600" type="submit">Hapus</button>
                </form>
            </div>
        @empty
            <p class="text-sm text-slate-500">Belum ada FAQ.</p>
        @endforelse
    </div>
</div>
