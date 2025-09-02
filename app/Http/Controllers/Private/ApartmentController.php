<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApartmentController extends Controller
{
    public function index(): View
    {
        $apartments = Apartment::all();
        return view('private.apartment.index', compact('apartments'));
    }

    public function create(): View
    {
        return view('private.apartment.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            Apartment::create($request->all());
            NotificationHelper::flash('Квартира успешно создана');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось создать квартиру', 'error');
        }

        return redirect()->route('apartment.create');
    }

    public function edit(Apartment $apartment): View
    {
        return view('private.apartment.edit', compact('apartment'));
    }

    public function update(Request $request, Apartment $apartment): RedirectResponse
    {
        try {
            $apartment->update($request->all());
            NotificationHelper::flash('Успешно обновлено');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось обновить', 'error');
        }

        return redirect()->route('apartment.edit', $apartment->id);
    }

    public function destroy(Apartment $apartment): RedirectResponse
    {
        try {
            $apartment->delete();
            NotificationHelper::flash('Успешно удалено');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось удалить', 'error');
        }

        return redirect()->route('apartment.index');
    }
}
