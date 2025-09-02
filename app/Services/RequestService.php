<?php

namespace App\Services;

use App\Models\Request as RequestModel;
use App\Models\User;

class RequestService
{
    public function getRequestsForUser(User $user)
    {
        if ($user->role === 'resident') {
            return RequestModel::where('user_id', $user->id)->get();
        }
        return RequestModel::all();
    }

    public function createRequest(User $user, array $data): RequestModel
    {
        $data['user_id'] = $user->id;
        $data['status'] = 'new';
        return RequestModel::create($data);
    }

    public function updateRequest(RequestModel $requestModel, array $data): RequestModel
    {
        $requestModel->update($data);
        return $requestModel;
    }

    public function assignToEmployee(int $requestId, int $employeeId): void
    {
        $request = RequestModel::findOrFail($requestId);
        $request->employee_id = $employeeId;
        $request->status = 'in_progress';
        $request->save();
    }
}
