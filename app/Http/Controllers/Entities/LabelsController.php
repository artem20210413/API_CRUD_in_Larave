<?php


namespace App\Http\Controllers\Entities;


use App\Http\Controllers\Controller;
use App\Http\Requests\LabelsLinkRequest;
use App\Http\Requests\LabelsDestroyRequest;
use App\Http\Requests\LabelsRequest;
use App\Http\Requests\ProjectsAddRequest;
use App\Http\Requests\ProjectsDestroyRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\Auth\UsersService;
use App\Services\Entities\LabelsService;
use App\Services\Entities\ProjectsService;
use Illuminate\Http\Request;

class LabelsController extends Controller
{
    public function create(LabelsRequest $labelsRequest, LabelsService $labelsService, UsersService $usersService)
    {
        $user = $usersService->getUser();
        $labelsService->createArray($user, $labelsRequest->only('Labels')['Labels']);
        return 'success';
    }
    public function destroy(LabelsDestroyRequest $labelsRequest, LabelsService $labelsService, UsersService $usersService)
    {
        $user = $usersService->getUser();
        $labelsService->destroy($user, $labelsRequest->only('Labels')['Labels']);
        return 'success';
    }

    public function link(LabelsLinkRequest $labelsRequest, LabelsService $labelsService)
    {
        $labelsService->linkProjects($labelsRequest);
        return 'success';
    }

}
