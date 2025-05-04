@extends('user.layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-lg space-y-8">
        <h2 class="text-3xl font-semibold text-center leading-tight">
            Pemilihan Mahasiswa Berprestasi <br>
            Politeknik Negeri Jember
        </h2>

        <div class="flex flex-col lg:flex-row mt-6 gap-6">
            <img src="/images/pilmapres-cartoon.png" class="rounded-lg shadow-lg w-full lg:w-1/3" alt="Pilmapres">
            <p class="text-gray-800 text-lg leading-relaxed">
                Pemilihan Mahasiswa Berprestasi (PILMAPRES) di Politeknik Negeri Jember (Polije) adalah ajang
                tahunan yang bertujuan untuk mengapresiasi dan mendorong mahasiswa dalam mencapai prestasi akademik
                dan non-akademik. Pada tahun 2025, Polije telah membuka pendaftaran PILMAPRES, yang diumumkan melalui
                akun Instagram resmi Polije.<br><br>
                Mahasiswa yang tertarik untuk berpartisipasi dalam PILMAPRES 2025 di Polije dapat mengikuti jadwal
                dan informasi yang telah diumumkan. Untuk informasi lebih lanjut mengenai persyaratan, jadwal, dan
                prosedur pendaftaran, disarankan untuk mengunjungi situs resmi Polije atau menghubungi panitia
                PILMAPRES di kampus.
            </p>
        </div>

        {{-- Informasi Bobot Kriteria --}}
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h3 class="text-2xl font-semibold mb-4">Bobot Penilaian Kriteria</h3>
            <ul class="space-y-2 text-lg">
                <li><span class="font-medium">CU (Contribution &amp; Uniqueness):</span> 40%</li>
                <li><span class="font-medium">PI (Presentation &amp; Innovation):</span> 40%</li>
                <li><span class="font-medium">BI (Bahasa Inggris / English Proficiency):</span> 20%</li>
            </ul>
        </div>
    </div>
@endsection
