<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public string $title;
    public string $subtitle;

    public function __construct(string $title = 'Dashboard', string $subtitle = '')
    {
        $this->title   = $title;
        $this->subtitle = $subtitle;
    }

    public function render()
    {
        return view('layouts.admin');
    }
}