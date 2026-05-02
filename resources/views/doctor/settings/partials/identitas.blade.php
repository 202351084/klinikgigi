<form method="POST" action="{{ route('doctor.settings.update') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')
    <input type="hidden" name="tab" value="identitas">

    <div class="grid gap-5 md:grid-cols-2">
        <div class="field">
            <label>Nama Klinik</label>
            <input name="clinic_name" value="{{ old('clinic_name', $klinik->nama_klinik) }}">
        </div>
        <div class="field">
            <label>Logo Klinik</label>
            <input type="file" name="logo">
            @if($klinik->logo_klinik)
                <img src="{{ asset('storage/'.$klinik->logo_klinik) }}" alt="Logo Klinik" class="mt-2 h-16 w-16 rounded-lg object-cover">
            @endif
        </div>
    </div>

    <div class="field">
        <label>Deskripsi Singkat</label>
        <textarea name="about_description" rows="4">{{ old('about_description', $klinik->deskripsi_singkat) }}</textarea>
    </div>

    <div class="field">
        <label>Alamat</label>
        <textarea name="address" rows="3">{{ old('address', $klinik->alamat) }}</textarea>
    </div>

    <button class="rounded-md bg-teal-700 px-5 py-3 text-sm font-medium text-white hover:bg-teal-800" type="submit">Simpan Identitas</button>
</form>
