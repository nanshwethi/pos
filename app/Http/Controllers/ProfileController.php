<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangePhotoRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Change password.
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();

        if (! Hash::check($request->old_password, $user->password)) {
            return response()->json(["data" => ['message' => 'Old password is incorrect']], 401);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     * Change name.
     */
    public function changeName(ChangeNameRequest $request)
    {
        $user = $request->user();
        $user->update(['name' => $request->name]);

        return response()->json([
            'message' => 'Name changed successfully',
            'data' => new ProfileResource($user)
        ]);
    }

    public function changePhoto(ChangePhotoRequest $request)
    {
        $user = $request->user();

        $user->update(['photo' => $request->photo]);

        return response()->json([
            'message' => 'Photo changed successfully',
            'data' => new ProfileResource($user)
        ]);
    }

    /**
     * Get user profile.
     */
    public function show(Request $request)
    {
        return response()->json([
            'message' => 'User profile retrieved successfully',
            'data' => new ProfileResource($request->user())
        ]);
    }
}
