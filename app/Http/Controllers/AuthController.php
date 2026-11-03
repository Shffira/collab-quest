<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/register',
        tags: ['Auth'],
        summary: 'Daftar akun baru',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Shafira'),
                    new OA\Property(property: 'email', type: 'string', example: 'shafira@mail.com'),
                    new OA\Property(property: 'password', type: 'string', example: 'rahasia123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Register berhasil'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'message' => 'Register berhasil',
            'data'    => $user,
        ], 201);
    }

    #[OA\Post(
        path: '/login',
        tags: ['Auth'],
        summary: 'Login dan ambil token',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', example: 'shafira@mail.com'),
                    new OA\Property(property: 'password', type: 'string', example: 'rahasia123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Login berhasil, mengembalikan token'),
            new OA\Response(response: 401, description: 'Email atau password salah'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => $user,
        ], 200);
    }

    #[OA\Get(
        path: '/profile',
        tags: ['Auth'],
        summary: 'Lihat profil user login',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Data profil'),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
        ]
    )]
    public function profile(Request $request)
    {
        return response()->json(['data' => $request->user()], 200);
    }

    #[OA\Post(
        path: '/logout',
        tags: ['Auth'],
        summary: 'Logout (hapus token)',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Logout berhasil'),
            new OA\Response(response: 401, description: 'Tidak terautentikasi'),
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil'], 200);
    }
}