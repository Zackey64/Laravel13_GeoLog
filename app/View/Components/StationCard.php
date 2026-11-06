<?php

namespace App\View\Components;

use App\Models\Station;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StationCard extends Component
{
    public function __construct(
        public Station $station,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.station-card');
    }
}
