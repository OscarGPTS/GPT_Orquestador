<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Database2\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserDatabase2Controller extends Controller
{
    /**
     * Obtener todos los usuarios con sus relaciones
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $usuarios = User::with([
            'job' => function($query) {
                $query->select('id', 'name', 'depto_id');
            },
            'job.departamento' => function($query) {
                $query->select('id', 'name', 'area_id');
            },
            'job.departamento.area' => function($query) {
                $query->select('id', 'name');
            },
            'jefe' => function($query) {
                $query->select('id', 'uuid', 'first_name', 'last_name', 'email', 'phone');
            },
            'razonSocial' => function($query) {
                $query->select('id', 'name');
            }
        ])
        ->select(
            'id',
            'uuid',
            'first_name',
            'last_name',
            'email',
            'phone',
            'job_id',
            'boss_id',
            'business_name_id',
            'admission',
            'cedula',
            'profile_image',
            'active'
        )
        ->where('active', true)
        ->orderBy('first_name', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'total' => $usuarios->count(),
            'data' => $usuarios->map(function($user) {
                return [
                    'id' => $user->id,
                    'uuid' => $user->uuid,
                    'nombre_completo' => $user->nombre(),
                    'nombre' => $user->first_name,
                    'apellido' => $user->last_name,
                    'email' => $user->email,
                    'telefono' => $user->phone,
                    'cedula' => $user->cedula,
                    'fecha_admission' => $user->admission?->format('Y-m-d'),
                    'foto_perfil' => $user->profile_image,
                    'activo' => $user->active,
                    'puesto' => [
                        'id' => $user->job?->id,
                        'nombre' => $user->job?->name,
                    ],
                    'departamento' => [
                        'id' => $user->job?->departamento?->id,
                        'nombre' => $user->job?->departamento?->name,
                    ],
                    'area' => [
                        'id' => $user->job?->departamento?->area?->id,
                        'nombre' => $user->job?->departamento?->area?->name,
                    ],
                    'razon_social' => [
                        'id' => $user->razonSocial?->id,
                        'nombre' => $user->razonSocial?->name,
                    ],
                    'jefe_directo' => $user->jefe ? [
                        'id' => $user->jefe->id,
                        'uuid' => $user->jefe->uuid,
                        'nombre_completo' => $user->jefe->nombre(),
                        'nombre' => $user->jefe->first_name,
                        'apellido' => $user->jefe->last_name,
                        'email' => $user->jefe->email,
                        'telefono' => $user->jefe->phone,
                    ] : null,
                ];
            })
        ]);
    }

    /**
     * Buscar usuario por email con sus relaciones
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)
            ->with([
                'job' => function($query) {
                    $query->select('id', 'name', 'depto_id');
                },
                'job.departamento' => function($query) {
                    $query->select('id', 'name', 'area_id');
                },
                'job.departamento.area' => function($query) {
                    $query->select('id', 'name');
                },
                'jefe' => function($query) {
                    $query->select('id', 'uuid', 'first_name', 'last_name', 'email', 'phone');
                },
                'razonSocial' => function($query) {
                    $query->select('id', 'name');
                }
            ])
            ->select(
                'id',
                'uuid',
                'first_name',
                'last_name',
                'email',
                'phone',
                'job_id',
                'boss_id',
                'business_name_id',
                'admission',
                'cedula',
                'profile_image',
                'active'
            )
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'uuid' => $user->uuid,
                'nombre_completo' => $user->nombre(),
                'nombre' => $user->first_name,
                'apellido' => $user->last_name,
                'email' => $user->email,
                'telefono' => $user->phone,
                'cedula' => $user->cedula,
                'fecha_admission' => $user->admission?->format('Y-m-d'),
                'foto_perfil' => $user->profile_image,
                'activo' => $user->active,
                'puesto' => [
                    'id' => $user->job?->id,
                    'nombre' => $user->job?->name,
                ],
                'departamento' => [
                    'id' => $user->job?->departamento?->id,
                    'nombre' => $user->job?->departamento?->name,
                ],
                'area' => [
                    'id' => $user->job?->departamento?->area?->id,
                    'nombre' => $user->job?->departamento?->area?->name,
                ],
                'razon_social' => [
                    'id' => $user->razonSocial?->id,
                    'nombre' => $user->razonSocial?->name,
                ],
                'jefe_directo' => $user->jefe ? [
                    'id' => $user->jefe->id,
                    'uuid' => $user->jefe->uuid,
                    'nombre_completo' => $user->jefe->nombre(),
                    'nombre' => $user->jefe->first_name,
                    'apellido' => $user->jefe->last_name,
                    'email' => $user->jefe->email,
                    'telefono' => $user->jefe->phone,
                ] : null,
            ]
        ]);
    }

    /**
     * Obtener usuario por ID con sus relaciones
     * 
     * @param  string  $userId
     * @return JsonResponse
     */
    public function show(string $userId): JsonResponse
    {
        $user = User::where('id', $userId)
            ->with([
                'job' => function($query) {
                    $query->select('id', 'name', 'depto_id');
                },
                'job.departamento' => function($query) {
                    $query->select('id', 'name', 'area_id');
                },
                'job.departamento.area' => function($query) {
                    $query->select('id', 'name');
                },
                'jefe' => function($query) {
                    $query->select('id', 'uuid', 'first_name', 'last_name', 'email', 'phone');
                },
                'razonSocial' => function($query) {
                    $query->select('id', 'name');
                }
            ])
            ->select(
                'id',
                'uuid',
                'first_name',
                'last_name',
                'email',
                'phone',
                'job_id',
                'boss_id',
                'business_name_id',
                'admission',
                'cedula',
                'profile_image',
                'active'
            )
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'uuid' => $user->uuid,
                'nombre_completo' => $user->nombre(),
                'nombre' => $user->first_name,
                'apellido' => $user->last_name,
                'email' => $user->email,
                'telefono' => $user->phone,
                'cedula' => $user->cedula,
                'fecha_admission' => $user->admission?->format('Y-m-d'),
                'foto_perfil' => $user->profile_image,
                'activo' => $user->active,
                'puesto' => [
                    'id' => $user->job?->id,
                    'nombre' => $user->job?->name,
                ],
                'departamento' => [
                    'id' => $user->job?->departamento?->id,
                    'nombre' => $user->job?->departamento?->name,
                ],
                'area' => [
                    'id' => $user->job?->departamento?->area?->id,
                    'nombre' => $user->job?->departamento?->area?->name,
                ],
                'razon_social' => [
                    'id' => $user->razonSocial?->id,
                    'nombre' => $user->razonSocial?->name,
                ],
                'jefe_directo' => $user->jefe ? [
                    'id' => $user->jefe->id,
                    'uuid' => $user->jefe->uuid,
                    'nombre_completo' => $user->jefe->nombre(),
                    'nombre' => $user->jefe->first_name,
                    'apellido' => $user->jefe->last_name,
                    'email' => $user->jefe->email,
                    'telefono' => $user->jefe->phone,
                ] : null,
            ]
        ]);
    }
}
