<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::all();
        return view('pages.services', compact('services'));
    }

    public function create(): View
    {
        return view('private.services');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            Service::create($request->all());
            NotificationHelper::flash('Успешно добавлено');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось добавить', 'error');
        }

        return redirect()->route('services');
    }

    public function edit(Service $service): View
    {
        return view('edit.services', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        try {
            $service->update($request->all());
            NotificationHelper::flash('Услуга успешно обновлена');
        }
        catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось обновить услугу', 'error');
        }
        return redirect()->route('services');
    }

    public function destroy(Service $service): RedirectResponse
    {
        try {
            $service->delete();
            NotificationHelper::flash('Успешно удалено');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось удалить', 'error');
        }

        return redirect()->route('services');
    }
}
