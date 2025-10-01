<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Request as RequestModel;
use App\Services\RequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    protected RequestService $requestService;

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    public function index(Request $request): View
    {
        $requests = $this->requestService->getRequestsForUser(auth()->user());
        return view('private.request.index', compact('requests'));
    }

    public function create(): View
    {
        $apartments = Apartment::all();

        return view('pages.requests', compact('apartments'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $this->requestService->createRequest(auth()->user(), $request->all());
            NotificationHelper::flash('Заявка успешно создана');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось создать заявку', 'error');
        }

        return redirect()->route('requests');
    }

    public function edit(RequestModel $requestModel): View
    {
        return view('edit.request', compact('requestModel'));
    }

    public function update(Request $request, RequestModel $requestModel): RedirectResponse
    {
        try {
            $this->requestService->updateRequest($requestModel, $request->all());
            NotificationHelper::flash('Заявка успешно обновлена');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось обновить заявку', 'error');
        }

        return redirect()->route('requests.edit', $requestModel->id);
    }

    public function show( RequestModel $request): View
    {
        return view('pages.request', compact('request'));
    }

    public function assignToEmployee(int $requestId, int $employeeId): RedirectResponse
    {
        try {
            $this->requestService->assignToEmployee($requestId, $employeeId);
            NotificationHelper::flash('Заявка назначена сотруднику');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось назначить исполнителя', 'error');
        }

        return redirect()->back();
    }

    public function destroy(RequestModel $requestModel): RedirectResponse
    {
        try {
            $requestModel->delete();
            NotificationHelper::flash('Заявка успешно удалена');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось удалить заявку', 'error');
        }

        return redirect()->route('requests');
    }
}
