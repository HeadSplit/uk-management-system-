<?php

namespace App\Http\Controllers\Private;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\RequestModel;
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
        return view('private.request.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $this->requestService->createRequest(auth()->user(), $request->all());
            NotificationHelper::flash('Заявка успешно создана');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось создать заявку', 'error');
        }

        return redirect()->route('request.create');
    }

    public function edit(RequestModel $requestModel): View
    {
        return view('private.request.edit', compact('requestModel'));
    }

    public function update(Request $request, RequestModel $requestModel): RedirectResponse
    {
        try {
            $this->requestService->updateRequest($requestModel, $request->all());
            NotificationHelper::flash('Заявка успешно обновлена');
        } catch (\Exception $exception) {
            NotificationHelper::flash('Не удалось обновить заявку', 'error');
        }

        return redirect()->route('request.edit', $requestModel->id);
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

        return redirect()->route('request.index');
    }
}
