<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function create()
    {
        return view('visits.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('visits.create');
    }

    public function edit(Request $request, Visit $visit)
    {
        return view('visits.edit', compact('visit'));
    }

    public function update(Request $request, Visit $visit)
    {
        return redirect()->route('visits.edit', $visit);
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();

        return redirect()->route('visits.create');
    }
}
