<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::all();
        return view('private.user.index', compact('users'));
    }

    public function create(): View
    {
        return view('private.user.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            User::create($request->all());
            NotificationHelper::flash('Пользователь успешно создан');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось создать пользователя', 'error');
        }

        return redirect()->route('user.create');
    }

    public function edit(User $user): View
    {
        return view('private.user.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        try {
            $user->update($request->all());
            NotificationHelper::flash('Пользователь успешно обновлен');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось обновить пользователя', 'error');
        }

        return redirect()->route('user.edit', $user->id);
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
            NotificationHelper::flash('Пользователь успешно удален');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось удалить пользователя', 'error');
        }

        return redirect()->route('user.index');
    }
}
