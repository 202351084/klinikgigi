<form method="POST" action="{{ route('doctor.settings.update') }}" class="space-y-5">
    @csrf
    @method('PUT')
    <input type="hidden" name="tab" value="jam-operasional">

    <div class="grid gap-5 md:grid-cols-2">
        @foreach($klinik->jamOperasional as $hour)
            <div class="rounded-xl border border-slate-200 p-4">
                <div class="font-medium text-slate-800">{{ ucfirst($hour->hari_buka) }}</div>
                <label class="mt-3 flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="hours[{{ $hour->id_jam_operasional }}][is_open]" value="1" @checked(old('hours.'.$hour->id_jam_operasional.'.is_open', ! $hour->hari_libur))>
                    Hari buka
                </label>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div class="field">
                        <label>Jam Buka</label>
                        <input type="time" name="hours[{{ $hour->id_jam_operasional }}][open_time]" value="{{ old('hours.'.$hour->id_jam_operasional.'.open_time', $hour->jam_buka ? substr($hour->jam_buka, 0, 5) : '') }}">
                    </div>
                    <div class="field">
                        <label>Jam Tutup</label>
                        <input type="time" name="hours[{{ $hour->id_jam_operasional }}][close_time]" value="{{ old('hours.'.$hour->id_jam_operasional.'.close_time', $hour->jam_tutup ? substr($hour->jam_tutup, 0, 5) : '') }}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button class="rounded-md bg-teal-700 px-5 py-3 text-sm font-medium text-white hover:bg-teal-800" type="submit">Simpan Jam Operasional</button>
</form>
