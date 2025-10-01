<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\House;
use App\Models\Service;
use App\Models\User;
use App\Services\BillingService;
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
        $houses = House::all();
        $users = User::all();
        return view('pages.apartments', compact('houses', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['number', 'house_id', 'area', 'entrance', 'floor', 'user_id']);
        $data['residents'] = [$request->user_id];

        try {
            Apartment::create($data);
            NotificationHelper::flash('Квартира успешно создана');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось создать квартиру', 'error');
        }

        return redirect()->route('apartments.create');
    }

    public function edit(Apartment $apartment): View
    {
        $houses = House::all();

        return view('edit.apartments', compact('apartment', 'houses'));
    }

    public function update(Request $request, Apartment $apartment): RedirectResponse
    {
        try {
            $apartment->update($request->all());
            NotificationHelper::flash('Успешно обновлено');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось обновить', 'error');
        }

        return redirect()->route('apartments.edit', $apartment->id);
    }

    public function destroy(Apartment $apartment): RedirectResponse
    {
        try {
            $apartment->delete();
            NotificationHelper::flash('Успешно удалено');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось удалить', 'error');
        }

        return redirect()->route('apartments');
    }

    public function detachUser(Request $request)
    {
        $apartment = Apartment::find($request->apartment_id);
        if (!$apartment) return redirect()->back();

        $userId = (int)$request->user_id;
        $residents = $apartment->residents ?? [];
        $residents = array_map('intval', $residents);

        if (($key = array_search($userId, $residents, true)) !== false) {
            unset($residents[$key]);
            $apartment->residents = array_values($residents);
            $apartment->save();
            NotificationHelper::flash('Жилец удален из квартиры');
        }

        return redirect()->back();
    }


    public function storeResident(Request $request)
    {
        $apartment = Apartment::find($request->apartment_id);
        if (!$apartment) {
            return redirect()->back();
        }

        $residents = $apartment->residents ?? [];

        if (!in_array($request->user_id, $residents)) {
            $residents[] = $request->user_id;
            $apartment->residents = $residents;
            $apartment->save();
        }

        NotificationHelper::flash('Жилец успешно добавлен');

        return redirect()->back();
    }

    public function showSendMetricsForm(Apartment $apartment)
    {
        $services = Service::all();

        return view('pages.metrics', compact('apartment', 'services'));
    }

    public function sendMetrics(Request $request, Apartment $apartment, BillingService $billingService)
    {
        $period = $request->input('period');
        $consumption = $request->input('services', []);

        $billingService->createInvoice($apartment->id, $period, $consumption);

        NotificationHelper::flash('Показатели успешно переданы');
        return redirect()->route('invoices');
    }

}
