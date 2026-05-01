<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $query = '';

    public function render()
    {
        $results = [];

        if (strlen($this->query) >= 2) {
            $results = Employee::query()
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->where('first_name', 'like', "%{$this->query}%")
                      ->orWhere('last_name',  'like', "%{$this->query}%")
                      ->orWhere('emp_code',   'like', "%{$this->query}%");
                })
                ->with('department')
                ->limit(6)
                ->get();
        }

        return view('livewire.global-search', ['results' => $results]);
    }
}
