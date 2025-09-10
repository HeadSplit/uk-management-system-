<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\House;
use App\Models\Invoice;
use App\Models\Request as RequestModel;
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

    public function showUserInvoices(): View
    {
        $user = auth()->user();

        $user->load('invoices');
        $unpaidInvoices = Invoice::whereIn('apartment_id', $user->apartments->pluck('id'))
            ->where('status', 'unpaid')
            ->get();

        $paidInvoices = Invoice::whereIn('apartment_id', $user->apartments->pluck('id'))
            ->where('status', 'paid')
            ->get();
        return view('pages.personal', compact('unpaidInvoices', 'paidInvoices'));
    }

    public function showRequests(): View
    {
        $user = auth()->user();

        $requests = RequestModel::when($user->role === 'resident', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['user', 'apartment'])
        ->get();

        return view('private.requests', compact('requests'));
    }

    public function showInvoices(): View
    {
        $user = auth()->user();

        $apartmentsIds = $user->apartments()->pluck('id')->toArray();

        $invoices = Invoice::when($user->role === 'resident', function ($query) use ($apartmentsIds) {
            $query->whereIn('apartment_id', $apartmentsIds);
        })
        ->get();

        return view('private.invoices', compact('invoices'));
    }

    public function showHouses(): View
    {
        $houses = House::all();

        return view('private.houses', compact('houses'));
    }

    public function showApartments(): View
    {
        $user = auth()->user();

        $apartments = Apartment::when($user->role === 'resident', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('private.apartments', compact('apartments'));
    }

    public function showUsers(): View
    {
        $users = User::all();

        return view('private.users', compact('users'));
    }
}
