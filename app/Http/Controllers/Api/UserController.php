<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['sometimes', 'min:3'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $id],
            'password' => ['sometimes', 'min:8'],
            'password_confirmation' => ['required_with:password', 'same:password'],
            'username' => ['sometimes', 'min:3', 'unique:users,username,' . $id],
            'alamat' => ['sometimes', 'min:5'],
            'imgprofile' => ['sometimes', 'image', 'max:2048'],
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);
        $user->username = $request->input('username', $user->username);
        $user->alamat = $request->input('alamat', $user->alamat);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('imgprofile')) {
            if ($user->imgprofile) {
                Storage::disk('gcs')->delete($user->imgprofile);
            }

            $path = $request->file('imgprofile')->store('profiles', 'gcs');
            $user->imgprofile = Storage::disk('gcs')->url($path);
        }

        $user->save();

        if ($user->wasChanged()) {
            return response()->json([
                'message' => 'User updated successfully.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'alamat' => $user->alamat,
                    'imgprofile' => $user->imgprofile,
                ],
            ], 200);
        } else {
            return response()->json(['message' => 'No changes were made.'], 200);
        }
    }
}
