<form method="POST" action="{{ route('doctor.settings.update') }}" class="space-y-5">
    @csrf
    @method('PUT')
    <input type="hidden" name="tab" value="pengaturan-reservasi">

    <div class="grid gap-5 md:grid-cols-2">
        <div class="field">
            <label>Batas Maksimal Booking per Hari</label>
            <input type="number" name="max_bookings_per_day" value="{{ old('max_bookings_per_day', $pengaturanReservasi?->batas_maksimal_booking_per_hari ?? 20) }}">
        </div>
        <div class="field">
            <label>Interval Slot per Jam (menit)</label>
            <input type="number" name="slot_interval_minutes" value="{{ old('slot_interval_minutes', $pengaturanReservasi?->interval_slot_per_jam ?? 30) }}">
        </div>
        <div class="field">
            <label>Hari Booking ke Depan</label>
            <input type="number" name="booking_max_days_ahead" value="{{ old('booking_max_days_ahead', $pengaturanReservasi?->hari_booking_ke_depan ?? 30) }}">
        </div>
        <div class="field">
            <label>Pasien Bisa Reschedule Sendiri</label>
            <select name="patient_can_reschedule">
                <option value="0" @selected(!old('patient_can_reschedule', $pengaturanReservasi?->pasien_bisa_reschedule_sendiri))>Tidak</option>
                <option value="1" @selected(old('patient_can_reschedule', $pengaturanReservasi?->pasien_bisa_reschedule_sendiri))>Ya</option>
            </select>
        </div>
    </div>

    <button class="rounded-md bg-teal-700 px-5 py-3 text-sm font-medium text-white hover:bg-teal-800" type="submit">Simpan Pengaturan Reservasi</button>
</form>
