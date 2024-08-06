<?php

namespace App\View\Components;

use App\Models\PowerOutage;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class TasraltGrid extends Component
{
    /**
     * Create a new component instance.
     */
    public $dataProvider;

    public function __construct()
    {
        $this->dataProvider = new EloquentDataProvider(PowerOutage::query());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tasralt-grid');
    }
}