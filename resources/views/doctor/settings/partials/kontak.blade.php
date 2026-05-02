<form method="POST" action="{{ route('doctor.settings.update') }}" class="space-y-5">
    @csrf
    @method('PUT')
    <input type="hidden" name="tab" value="kontak">

    <div class="grid gap-5 md:grid-cols-2">
        <div class="field">
            <label>Nomor WhatsApp</label>
            <input name="whatsapp_number" value="{{ old('whatsapp_number', $klinik->nomor_whatsapp) }}">
        </div>
        <div class="field">
            <label>Nomor Telepon</label>
            <input name="phone_number" value="{{ old('phone_number', $klinik->nomor_telepon) }}">
        </div>
    </div>

    <div class="field">
        <label>Email Klinik</label>
        <input name="clinic_email" value="{{ old('clinic_email', $klinik->email_klinik) }}">
    </div>

    <div class="field">
        <label>Alamat Klinik</label>
        <textarea name="address" rows="3">{{ old('address', $klinik->alamat) }}</textarea>
    </div>

    <button class="rounded-md bg-teal-700 px-5 py-3 text-sm font-medium text-white hover:bg-teal-800" type="submit">Simpan Kontak</button>
</form>
