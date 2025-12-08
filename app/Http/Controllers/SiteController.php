<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::orderBy('created_at', 'desc')->get();
        return view('admin.sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'description' => 'nullable|string',
            'check_interval' => 'required|integer|min:60',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Site::create($validated);

        return redirect()->route('sites.index')->with('success', 'Sitio creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        return view('admin.sites.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return view('admin.sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'description' => 'nullable|string',
            'check_interval' => 'required|integer|min:60',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $site->update($validated);

        return redirect()->route('sites.index')->with('success', 'Sitio actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->route('sites.index')->with('success', 'Sitio eliminado exitosamente');
    }

    /**
     * Check site status manually
     */
    public function checkStatus(Site $site)
    {
        try {
            $start = microtime(true);
            $response = Http::withOptions([
                'verify' => false, // Deshabilitar verificación SSL en desarrollo
            ])->timeout(10)->get($site->url);
            $responseTime = round((microtime(true) - $start) * 1000);

            $site->update([
                'status' => $response->successful() ? 'up' : 'down',
                'response_time' => $responseTime,
                'last_checked_at' => now(),
            ]);

            $message = $response->successful() 
                ? "Sitio operativo - Tiempo de respuesta: {$responseTime}ms"
                : "Sitio caído - Código: {$response->status()}";

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            $site->update([
                'status' => 'down',
                'response_time' => null,
                'last_checked_at' => now(),
            ]);

            return redirect()->back()->with('error', 'Error al verificar sitio: ' . $e->getMessage());
        }
    }
}
