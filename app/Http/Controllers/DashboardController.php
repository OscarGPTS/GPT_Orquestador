<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role
     */
    public function index()
    {
        $user = auth()->user();
        
        // Dashboard para administrador
        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        }
        
        // Dashboard estándar para otros roles
        return $this->userDashboard();
    }

    /**
     * Dashboard para administradores con estadísticas
     */
    private function adminDashboard()
    {
        $sites = Site::all();
        
        $data = [
            'sites' => $sites,
            'totalSites' => $sites->count(),
            'sitesUp' => $sites->where('status', 'up')->count(),
            'sitesDown' => $sites->where('status', 'down')->count(),
            'avgResponseTime' => $this->calculateAvgResponseTime($sites),
        ];
        
        return view('dashboards.admin.dashboard', $data);
    }

    /**
     * Dashboard estándar para usuarios
     */
    private function userDashboard()
    {
        return view('dashboard');
    }

    /**
     * Calcular tiempo de respuesta promedio
     */
    private function calculateAvgResponseTime($sites)
    {
        $avg = $sites->whereNotNull('response_time')->avg('response_time');
        return $avg ? round($avg) : null;
    }
}
