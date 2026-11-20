<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::orderByDesc('id')->paginate(10);

        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => [
            'required',
            'string',
            'max:50',
            'alpha_dash',
            Rule::notIn(['admin']),
            Rule::unique('users', 'username'),
            ],
            'full_name' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
            'avatar' => [
                'nullable',
                File::image()->types(['jpg', 'jpeg', 'png'])->max('2mb'),
            ],
        ]);

        $validated['created_at'] = now();
        unset($validated['password_confirmation']);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $this->prepareAvatar(
                $request->file('avatar')
            );
        }

        try {
            User::create($validated);
        } catch (\Throwable $e) {
            if (!empty($validated['avatar'])) {
                Storage::disk('public')->delete($validated['avatar']);
            }

            throw $e;
        }

        return redirect()->route('staff.index')
            ->with('success', 'Staff account created successfully!');
    }

    public function show(User $staff)
    {
        return view('staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        if ($staff->username === 'admin' && $request->input('username') !== 'admin') {
            return redirect()
                ->back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors([
                    'username' => 'The administrator username cannot be changed.',
                ]);
        }
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($staff->id),
            ],
            'full_name' => ['required', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:12', 'confirmed'],
            'avatar' => [
                'nullable',
                File::image()->types(['jpg', 'jpeg', 'png'])->max('2mb'),
            ],
        ]);

        // Keep the existing password when left blank
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $oldAvatar = $staff->avatar;
        $newAvatar = null;

        if ($request->hasFile('avatar')) {
            $newAvatar = $this->prepareAvatar(
                $request->file('avatar')
            );

            $validated['avatar'] = $newAvatar;
        }

        try {
            $staff->update($validated);
        } catch (\Throwable $e) {
            if ($newAvatar) {
                Storage::disk('public')->delete($newAvatar);
            }

            throw $e;
        }

        if ($newAvatar && $oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }

        return redirect()->route('staff.index')
            ->with('success', 'Staff account updated successfully!');
    }

    public function destroy(User $staff)
    {
        $result = DB::transaction(function () use ($staff) {
            $staff = User::query()
                ->lockForUpdate()
                ->findOrFail($staff->id);

            if ($staff->id === Auth::id()) {
                return 'self';
            }

            if ($staff->sales()->exists()) {
                return 'sales';
            }

            $avatar = $staff->avatar;
            $staff->delete();

            return $avatar ?? '';
        });

        if ($result === 'self') {
            return redirect()->route('staff.index')
                ->with('error', 'You cannot delete your own account.');
        }

        if ($result === 'sales') {
            return redirect()->route('staff.index')
                ->with('error',
                    'Staff members with sales history cannot be deleted.');
        }

        if ($result) {
            Storage::disk('public')->delete($result);
        }

        return redirect()->route('staff.index')
            ->with('success', 'Staff account deleted successfully!');
    }

    private function prepareAvatar($file): string
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->read($file->getRealPath());

        // Create a square avatar without distortion
        $image->cover(300, 300);

        $path = 'avatars/' . Str::uuid() . '.jpg';

        Storage::disk('public')->put(
            $path,
            (string) $image->toJpeg(quality: 85)
        );

        return $path;
    }
}
