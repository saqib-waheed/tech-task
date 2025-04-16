<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List all users
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(User::all());
    }

    // Show a single user's details
    public function show(User $user): \Illuminate\Http\JsonResponse
    {
        return response()->json($user);
    }

    // Store a new user (create)
    public function store(UserStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        // If profile image is uploaded, store it
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Hash the password before saving
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    // Update existing user
    public function update(UserStoreRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        // If password is filled, update it
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // If new image uploaded, store it
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->update($data);

        return response()->json($user);
    }

    // Delete user
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }

}
