<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Organisateur extends Component
{

    public $todayStats = [];
    public $globalStats = [];
    public $todayEvents = [];

    public function mount()
    {
        $this->fetchDashboardData();
    }

    public function fetchDashboardData()
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))
            ->get(env('API_URL') . '/dashboard/organisateur');

        if ($response->successful()) {
            $data = $response->json();
            $this->todayStats = $data['today_stats'];
            $this->globalStats = $data['global_stats'];
            $this->todayEvents = $data['today_events'];
        }
    }

    public function render()
    {
        return view('livewire.dashboard.organisateur');
    }
}
