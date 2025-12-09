<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\ProviderApplication;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role
     */
    public function index()
    {
        // Dashboard para administrador
        if (auth()->user()->hasRole('admin')) {
            return $this->adminDashboard();
        }

        // Dashboard para compras
        if (auth()->user()->hasRole('purchasing')) {
            return $this->purchasingDashboard();
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
     * Dashboard para el equipo de Compras
     */
    private function purchasingDashboard()
    {
        $totalApplications = ProviderApplication::count();
        $pendingApplications = ProviderApplication::where('status', 'pending')->count();
        $approvedApplications = ProviderApplication::where('status', 'approved')->count();
        $rejectedApplications = ProviderApplication::where('status', 'rejected')->count();
        
        // Solicitudes pendientes paginadas de 10 en 10
        $pendingList = ProviderApplication::where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $data = [
            'totalApplications' => $totalApplications,
            'pendingApplications' => $pendingApplications,
            'approvedApplications' => $approvedApplications,
            'rejectedApplications' => $rejectedApplications,
            'pendingList' => $pendingList,
        ];
        
        return view('dashboards.purchasing.dashboard', $data);
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
