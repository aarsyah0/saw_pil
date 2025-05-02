<div class="space-y-4">
    <p><strong>Nama Mahasiswa:</strong> {{ $schedule->peserta->name }}</p>
    <p><strong>Tanggal:</strong> {{ $schedule->tanggal->format('d M Y') }}</p>
    <p><strong>Lokasi:</strong> {{ $schedule->lokasi }}</p>

    <div>
        <strong>Daftar Juri:</strong>
        <ul class="list-disc list-inside mt-1">
            @foreach ($schedule->juris as $j)
                <li>{{ $j->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
