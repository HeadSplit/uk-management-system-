<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\House;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HouseController extends Controller
{
    public function index(): View
    {
        $houses = House::all();
        return view('private.house.index', compact('houses'));
    }

    public function create(): View
    {
        return view('private.house.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            House::create($request->all());
            NotificationHelper::flash('Дом создан');
        }
        catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось создать дом', 'error');
        }

        return redirect()->route('house.create');
    }

    public function edit(House $house): View
    {
        return view('edit.houses', compact('house'));
    }

    public function update(Request $request, House $house): RedirectResponse
    {
        try {
            $house->update($request->all());
            NotificationHelper::flash('Успешно обновлено');
        }
        catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось обновить данные', 'error');
        }

        return redirect()->route('houses.edit', $house->id);
    }

    public function destroy(House $house): RedirectResponse
    {
        try {
            $house->delete();
            NotificationHelper::flash('Успешно удалено');
        }
        catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось удалить', 'error');
        }

        return redirect()->route('house.index');
    }

    public function getApartments(string $houseId)
    {
        $apartments = Apartment::where('house_id', $houseId)->get(['id', 'number']);

        return response()->json($apartments);
    }

    public function storeResident(Request $request)
    {
        $validated = $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $apartment = Apartment::findOrFail($validated['apartment_id']);
        $residents = $apartment->residents ?? [];

        if (!in_array($validated['user_id'], $residents)) {
            $residents[] = $validated['user_id'];
            $apartment->residents = $residents;
            $apartment->save();
        }

        NotificationHelper::flash('Жилец успешно добавлен');
        return redirect()->back();
    }

}
