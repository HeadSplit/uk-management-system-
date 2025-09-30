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
        return view('private.service.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            Service::create($request->all());
            NotificationHelper::flash('Успешно добавлено');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось добавить', 'error');
        }

        return redirect()->route('service.create');
    }

    public function destroy(Service $service): RedirectResponse
    {
        try {
            $service->delete();
            NotificationHelper::flash('Успешно удалено');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось удалить', 'error');
        }

        return redirect()->route('service.index');
    }
}
