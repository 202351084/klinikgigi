<form method="POST" action="{{ route('doctor.settings.update') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')
    <input type="hidden" name="tab" value="profil-dokter">

    <div class="grid gap-5 md:grid-cols-2">
        <div class="field">
            <label>Nama Dokter</label>
            <input name="doctor_name" value="{{ old('doctor_name', $dokter->nama_dokter) }}">
        </div>
        <div class="field">
            <label>Gelar</label>
            <input name="doctor_title" value="{{ old('doctor_title', $dokter->gelar) }}">
        </div>
        <div class="field">
            <label>Foto Dokter</label>
            <input type="file" name="doctor_photo">
            @if($dokter->foto_dokter)
                <img src="{{ asset('storage/'.$dokter->foto_dokter) }}" alt="Foto Dokter" class="mt-2 h-20 w-20 rounded-xl object-cover">
            @endif
        </div>
        <div class="field">
            <label>Deskripsi Singkat</label>
            <input name="doctor_specialty" value="{{ old('doctor_specialty', strtok((string) $dokter->keterangan, "\n")) }}">
        </div>
    </div>

    <div class="field">
        <label>Keterangan / Bio Dokter</label>
        <textarea name="doctor_bio" rows="4">{{ old('doctor_bio', $dokter->keterangan) }}</textarea>
    </div>

    <button class="rounded-md bg-teal-700 px-5 py-3 text-sm font-medium text-white hover:bg-teal-800" type="submit">Simpan Profil Dokter</button>
</form>
