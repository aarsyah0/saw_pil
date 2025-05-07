{{-- resources/views/admin/partials/selection_detail.blade.php --}}
<div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Capaian Unggulan Terpilih</h2>
    <table class="w-full table-auto divide-y divide-gray-200 mb-6">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium">Skor</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($finalSelectedCUs as $cu)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm">{{ number_format($cu->skor, 4) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 text-center text-gray-600">
                        Tidak ada CU terpilih.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2 class="text-xl font-semibold mb-2">Ringkasan Skor</h2>
    <p><strong>Total Skor CU:</strong> {{ number_format($totalSkorCU, 4) }}</p>
    <p><strong>Skor Maksimal:</strong> {{ number_format($maxSkorCU, 4) }}</p>
    <p><strong>Normalisasi:</strong> {{ number_format($norm, 4) }}</p>
</div>
