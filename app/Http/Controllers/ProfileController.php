<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updatePhoto(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = $request->user();

        $oldPhoto = $user->photo;
        $newPhotoPath = $validated['photo']->store('profiles', 'public');

        if (
            !empty($oldPhoto) &&
            !str_starts_with($oldPhoto, 'http://') &&
            !str_starts_with($oldPhoto, 'https://') &&
            !str_starts_with($oldPhoto, 'assets/') &&
            !str_starts_with($oldPhoto, 'storage/') &&
            Storage::disk('public')->exists($oldPhoto)
        ) {
            Storage::disk('public')->delete($oldPhoto);
        }

        $user->update([
            'photo' => $newPhotoPath,
        ]);

        return back()->with('success', 'Profile photo updated successfully.');
    }
}
