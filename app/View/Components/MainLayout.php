<?php

namespace App\View\Components;

use App\Models\Pengaturan;
use Illuminate\View\Component;
use Illuminate\View\View;

class MainLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $settings = Pengaturan::pluck('value', 'key');
        
        return view('layouts.main', compact('settings'));
    }
}
