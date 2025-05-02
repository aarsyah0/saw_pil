<form method="POST"
    action="{{ $schedule->exists ? route('admin.schedules.update', $schedule->id) : route('admin.schedules.store') }}">
    @csrf
    @if ($schedule->exists)
        @method('PUT')
    @endif

    @unless ($schedule->exists)
        <label class="block mb-1">Peserta</label>
        <select name="peserta_id" class="w-full mb-4 border rounded p-2">
            @foreach ($pesertas as $id)
                <option value="{{ $id }}"{{ old('peserta_id') == $id ? ' selected' : '' }}>
                    {{ \App\Models\PesertaProfile::find($id)->name }}
                </option>
            @endforeach
        </select>
    @endunless

    <label class="block mb-1">Juri</label>
    <select name="juri_id[]" multiple class="w-full mb-4 border rounded p-2">
        @foreach ($juris as $id => $name)
            <option value="{{ $id }}" @if ($schedule->juris->pluck('id')->contains($id)) selected @endif>
                {{ $name }}
            </option>
        @endforeach
    </select>

    <label class="block mb-1">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', $schedule->tanggal?->format('Y-m-d')) }}"
        class="w-full mb-4 border rounded p-2" />

    <label class="block mb-1">Lokasi</label>
    <input type="text" name="lokasi" value="{{ old('lokasi', $schedule->lokasi) }}"
        class="w-full mb-4 border rounded p-2" />

    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
        {{ $schedule->exists ? 'Update' : 'Simpan' }}
    </button>
</form>
