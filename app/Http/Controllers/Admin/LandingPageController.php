<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\HeroFeature;
use App\Models\Purpose;
use App\Models\Requirement;
use App\Models\Schedule;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $heroSlides = HeroSlide::query()
            ->when($search, fn($q) => $q->where('title', 'like', "%$search%"))
            ->orderBy('order')
            ->paginate(10);

        $purposes = Purpose::query()
            ->when($search, fn($q) => $q->where('title', 'like', "%$search%"))
            ->orderBy('order')
            ->paginate(10);

        $requirements = Requirement::query()
            ->orderBy('order')
            ->paginate(10);

        $schedules = Schedule::query()
            ->orderBy('order')
            ->paginate(10);

        return view('admin.landing-page.index', compact('heroSlides', 'purposes', 'requirements', 'schedules'));
    }

    // Hero Slide Methods
    public function storeHeroSlide(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string',
            'button_url' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('hero_slides', 'public');
        }

        HeroSlide::create($data);

        return back()->with('success', 'Hero Slide berhasil ditambahkan.');
    }

    public function updateHeroSlide(Request $request, HeroSlide $heroSlide)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string',
            'button_url' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('hero_slides', 'public');
        }

        $heroSlide->update($data);

        return back()->with('success', 'Hero Slide berhasil diupdate.');
    }

    public function destroyHeroSlide(HeroSlide $heroSlide)
    {
        $heroSlide->delete();
        return back()->with('success', 'Hero Slide berhasil dihapus.');
    }

    // Purpose Methods
    public function storePurpose(Request $request)
{
    $data = $request->validate([
        'title'       => 'required|string',
        'description' => 'required|string',    // ← tambahkan ini
        'icon_path'   => 'nullable|image|max:2048',
        'order'       => 'nullable|integer',
    ]);

    if ($request->hasFile('icon_path')) {
        $data['icon_path'] = $request->file('icon_path')
                                 ->store('purposes','public');
    }

    Purpose::create($data);

    return back()->with('success','Purpose berhasil ditambahkan.');
}


    public function updatePurpose(Request $request, Purpose $purpose)
    {
        $data = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'icon_path'   => 'nullable|image|max:2048',
            'order'       => 'nullable|integer',
        ]);

        if($request->hasFile('icon_path')){
            $data['icon_path'] = $request->file('icon_path')->store('purposes','public');
        }

        $purpose->update($data);

        return back()->with('success','Purpose berhasil diupdate.');
    }

    public function destroyPurpose(Purpose $purpose)
    {
        $purpose->delete();
        return back()->with('success', 'Purpose berhasil dihapus.');
    }

    // Requirement Methods
    public function storeRequirement(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        Requirement::create($data);

        return back()->with('success', 'Requirement berhasil ditambahkan.');
    }

    public function updateRequirement(Request $request, Requirement $requirement)
    {
        $data = $request->validate([
            'text' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $requirement->update($data);

        return back()->with('success', 'Requirement berhasil diupdate.');
    }

    public function destroyRequirement(Requirement $requirement)
    {
        $requirement->delete();
        return back()->with('success', 'Requirement berhasil dihapus.');
    }

    // Schedule Methods
    public function storeSchedule(Request $request)
    {
        $data = $request->validate([
            'activity'   => 'required|string',
            'date_from'  => 'required|date',
            'date_to'    => 'required|date',
            'order'      => 'nullable|integer',
        ]);

        Schedule::create($data);

        return back()->with('success', 'Schedule berhasil ditambahkan.');
    }

    public function updateSchedule(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'activity'   => 'required|string',
            'date_from'  => 'required|date',
            'date_to'    => 'required|date',
            'order'      => 'nullable|integer',
        ]);

        $schedule->update($data);

        return back()->with('success', 'Schedule berhasil diupdate.');
    }

    public function destroySchedule(Schedule $schedule)
    {

        $schedule->delete();
        return back()->with('success', 'Schedule berhasil dihapus.');
    }
}
