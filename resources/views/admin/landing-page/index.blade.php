@extends('admin.layouts.master')

@section('title', 'Edit Landing Admin')
@section('page-title', 'Edit Landing Page')

@section('content')


    <div class="container mx-auto p-6 space-y-12">
        {{-- HERO SLIDES --}}
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold">Slide</h2>
                <button onclick="openModal('heroAddModal')"
                    class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 transition">
                    + Add Hero Slide
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($heroSlides as $slide)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                        <div class="h-40 bg-gray-100">
                            @if ($slide->image_path)
                                <img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->title }}"
                                    class="object-cover w-full h-full">
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold">{{ $slide->title }}</h3>
                            @if ($slide->subtitle)
                                <p class="text-gray-600 mt-1">{{ $slide->subtitle }}</p>
                            @endif
                            <div class="flex items-center justify-between mt-4">
                                <span class="text-sm text-gray-500">Urutan: {{ $slide->order }}</span>
                                <div class="space-x-2">
                                    <button onclick="openModal('heroEditModal-{{ $slide->id }}')"
                                        class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.hero-slides.destroy', $slide->id) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div id="heroEditModal-{{ $slide->id }}"
                        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                        <div class="bg-white rounded-xl shadow-xl w-11/12 sm:w-3/4 md:w-1/2 lg:w-1/3 p-6 relative">
                            <button onclick="closeModal('heroEditModal-{{ $slide->id }}')"
                                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                                <i class="bi bi-x-lg text-2xl"></i>
                            </button>
                            <h3 class="text-2xl font-bold mb-4">Edit Hero Slide</h3>
                            <form action="{{ route('admin.hero-slides.update', $slide->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4">
                                @csrf @method('PUT')
                                <input type="text" name="title" value="{{ $slide->title }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Title" required>
                                <input type="text" name="subtitle" value="{{ $slide->subtitle }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Subtitle">
                                <input type="file" name="image_path" class="border rounded-lg p-2 w-full">
                                <input type="text" name="button_text" value="{{ $slide->button_text }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Button Text">
                                <input type="text" name="button_url" value="{{ $slide->button_url }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Button URL">
                                <input type="number" name="order" value="{{ $slide->order }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Urutan">
                                <div class="text-right">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Add Modal -->
        <div id="heroAddModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
            <div class="bg-white rounded-xl shadow-xl w-11/12 sm:w-3/4 md:w-1/2 lg:w-1/3 p-6 relative">
                <button onclick="closeModal('heroAddModal')"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                    <i class="bi bi-x-lg text-2xl"></i>
                </button>
                <h3 class="text-2xl font-bold mb-4">Add Hero Slide</h3>
                <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <input type="text" name="title" class="border rounded-lg p-3 w-full" placeholder="Title" required>
                    <input type="text" name="subtitle" class="border rounded-lg p-3 w-full" placeholder="Subtitle">
                    <input type="file" name="image_path" class="border rounded-lg p-2 w-full">
                    <input type="text" name="button_text" class="border rounded-lg p-3 w-full" placeholder="Button Text">
                    <input type="text" name="button_url" class="border rounded-lg p-3 w-full" placeholder="Button URL">
                    <input type="number" name="order" class="border rounded-lg p-3 w-full" placeholder="Order">
                    <div class="text-right">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }
        </script>


        {{-- PURPOSES --}}
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold">Tujuan</h2>
                <button onclick="openModal('purposeAddModal')"
                    class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 transition">
                    + Add Purpose
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($purposes as $p)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col">
                        <div class="flex items-center justify-center h-24 bg-gray-100">
                            @if ($p->icon_path)
                                <img src="{{ asset('storage/' . $p->icon_path) }}" alt="{{ $p->title }}"
                                    class="object-contain h-16 w-16">
                            @else
                                <i class="bi bi-lightbulb-fill text-gray-400 text-4xl"></i>
                            @endif
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="text-xl font-semibold">{{ $p->title }}</h3>
                            <p class="text-gray-600 mt-2 flex-1">{{ $p->description }}</p>
                            <div class="flex items-center justify-between mt-4">
                                <span class="text-sm text-gray-500">Order: {{ $p->order }}</span>
                                <div class="space-x-2">
                                    <button onclick="openModal('purposeEditModal-{{ $p->id }}')"
                                        class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.purposes.destroy', $p->id) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div id="purposeEditModal-{{ $p->id }}"
                        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                        <div class="bg-white rounded-xl shadow-xl w-11/12 sm:w-3/4 md:w-1/2 lg:w-1/3 p-6 relative">
                            <button onclick="closeModal('purposeEditModal-{{ $p->id }}')"
                                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                                <i class="bi bi-x-lg text-2xl"></i>
                            </button>
                            <h3 class="text-2xl font-bold mb-4">Edit Purpose</h3>
                            <form action="{{ route('admin.purposes.update', $p->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4">
                                @csrf @method('PUT')
                                <input type="text" name="title" value="{{ $p->title }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Title" required>
                                <textarea name="description" class="border rounded-lg p-3 w-full" placeholder="Description" required>{{ $p->description }}</textarea>
                                <input type="file" name="icon_path" class="border rounded-lg p-2 w-full">
                                <input type="number" name="order" value="{{ $p->order }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Order">
                                <div class="text-right">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- REQUIREMENTS --}}
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold">Persyaratan</h2>
                <button onclick="openModal('reqAddModal')"
                    class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 transition">
                    + Add Requirement
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($requirements as $r)
                    <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between">
                        <div>
                            <p class="text-lg font-medium text-gray-800">{{ $r->text }}</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-sm text-gray-500">Order: {{ $r->order }}</span>
                            <div class="space-x-2">
                                <button onclick="openModal('reqEditModal-{{ $r->id }}')"
                                    class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                    Edit
                                </button>
                                <form action="{{ route('admin.requirements.destroy', $r->id) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div id="reqEditModal-{{ $r->id }}"
                        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                        <div class="bg-white rounded-xl shadow-xl w-11/12 sm:w-3/4 md:w-1/2 lg:w-1/3 p-6 relative">
                            <button onclick="closeModal('reqEditModal-{{ $r->id }}')"
                                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                                <i class="bi bi-x-lg text-2xl"></i>
                            </button>
                            <h3 class="text-2xl font-bold mb-4">Edit Requirement</h3>
                            <form action="{{ route('admin.requirements.update', $r->id) }}" method="POST"
                                class="space-y-4">
                                @csrf @method('PUT')
                                <input type="text" name="text" value="{{ $r->text }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Requirement text" required>
                                <input type="number" name="order" value="{{ $r->order }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Order">
                                <div class="text-right">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add Modal -->

        </section>


        {{-- SCHEDULES --}}
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold">Jadwal</h2>
                <button onclick="openModal('schedAddModal')"
                    class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 transition">
                    + Add Schedule
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($schedules as $s)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col">
                        <div class="p-6 flex-1">
                            <h3 class="text-xl font-semibold">{{ $s->activity }}</h3>
                            <p class="text-gray-600 mt-2">{{ $s->time }}</p>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-between">
                            <span class="text-sm text-gray-500">Order: {{ $s->order }}</span>
                            <div class="space-x-2">
                                <button onclick="openModal('schedEditModal-{{ $s->id }}')"
                                    class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                    Edit
                                </button>
                                <form action="{{ route('landing-page.schedules.destroy', $s->id) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div id="schedEditModal-{{ $s->id }}"
                        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                        <div class="bg-white rounded-xl shadow-xl w-11/12 sm:w-2/3 md:w-1/2 lg:w-1/3 p-6 relative">
                            <button onclick="closeModal('schedEditModal-{{ $s->id }}')"
                                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                                <i class="bi bi-x-lg text-2xl"></i>
                            </button>
                            <h3 class="text-2xl font-bold mb-4">Edit Schedule</h3>
                            <form action="{{ route('landing-page.schedules.update', $s->id) }}" method="POST"
                                class="space-y-4">
                                @csrf @method('PUT')
                                <input type="text" name="activity" value="{{ $s->activity }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Activity" required>
                                <input type="date" name="date_from"
                                    value="{{ \Carbon\Carbon::parse($s->date_from)->format('Y-m-d') }}"
                                    class="border rounded-lg p-3 w-full" required>
                                <input type="date" name="date_to"
                                    value="{{ \Carbon\Carbon::parse($s->date_to)->format('Y-m-d') }}"
                                    class="border rounded-lg p-3 w-full" required>
                                <input type="number" name="order" value="{{ $s->order }}"
                                    class="border rounded-lg p-3 w-full" placeholder="Order">
                                <div class="text-right">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add Modal -->
            <div id="schedAddModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                <div class="bg-white rounded-xl shadow-xl w-11/12 sm:w-2/3 md:w-1/2 lg:w-1/3 p-6 relative">
                    <button onclick="closeModal('schedAddModal')"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                        <i class="bi bi-x-lg text-2xl"></i>
                    </button>
                    <h3 class="text-2xl font-bold mb-4">Add Schedule</h3>
                    <form action="{{ route('landing-page.schedules.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="activity" class="border rounded-lg p-3 w-full"
                            placeholder="Activity" required>
                        <input type="date" name="date_from" class="border rounded-lg p-3 w-full" required>
                        <input type="date" name="date_to" class="border rounded-lg p-3 w-full" required>
                        <input type="number" name="order" class="border rounded-lg p-3 w-full" placeholder="Order">
                        <div class="text-right">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- ADD Modals -->
    <div id="heroAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-1/2 relative">
            <button onclick="closeModal('heroAddModal')"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800"><i class="bi bi-x-lg"></i></button>
            <h3 class="text-xl font-bold mb-4">Add Hero Slide</h3>
            <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <input type="text" name="title" placeholder="Title" class="border rounded p-2 w-full" required />
                <input type="text" name="subtitle" placeholder="Subtitle" class="border rounded p-2 w-full" />
                <input type="file" name="image_path" class="border rounded p-2 w-full" />
                <input type="text" name="button_text" placeholder="Button Text" class="border rounded p-2 w-full" />
                <input type="text" name="button_url" placeholder="Button URL" class="border rounded p-2 w-full" />
                <input type="number" name="order" placeholder="Order" class="border rounded p-2 w-full" />
                <div class="text-right"><button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button></div>
            </form>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="purposeAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 relative">
            <button onclick="closeModal('purposeAddModal')"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                <i class="bi bi-x-lg"></i>
            </button>
            <h3 class="text-xl font-bold mb-4">Add Purpose</h3>
            <form action="{{ route('admin.purposes.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <label class="block">
                    Title
                    <input type="text" name="title" class="border rounded p-2 w-full" required>
                </label>
                <label class="block">
                    Description
                    <textarea name="description" class="border rounded p-2 w-full" required></textarea>
                </label>
                <label class="block">
                    Icon
                    <input type="file" name="icon_path" class="border rounded p-2 w-full">
                </label>
                <label class="block">
                    Order
                    <input type="number" name="order" class="border rounded p-2 w-full">
                </label>
                <div class="text-right">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="reqAddModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-xl w-11/12 sm:w-3/4 md:w-1/2 lg:w-1/3 p-6 relative">
            <button onclick="closeModal('reqAddModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
            <h3 class="text-2xl font-bold mb-4">Add Requirement</h3>
            <form action="{{ route('admin.requirements.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="text" class="border rounded-lg p-3 w-full" placeholder="Requirement text"
                    required>
                <input type="number" name="order" class="border rounded-lg p-3 w-full" placeholder="Order">
                <div class="text-right">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // Sidebar dropdown state
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const icon = document.getElementById('dataAlternatifIcon');
            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                dropdown.classList.remove('hidden');
                icon.classList.add('rotate-180');
                sessionStorage.setItem(dropdownId, 'open');
            } else {
                dropdown.classList.add('hidden');
                icon.classList.remove('rotate-180');
                sessionStorage.setItem(dropdownId, 'closed');
            }
        }

        function keepDropdownOpen(dropdownId) {
            sessionStorage.setItem(dropdownId, 'open');
        }

        function restoreDropdownState(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const icon = document.getElementById('dataAlternatifIcon');
            if (sessionStorage.getItem(dropdownId) === 'open') {
                dropdown.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            restoreDropdownState('dataAlternatifDropdown');
        });

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

@endsection
