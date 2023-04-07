<?php


namespace App\Http\Controllers\Entities;


use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectsAddRequest;
use App\Http\Requests\ProjectsDestroyRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\Auth\UsersService;
use App\Services\Entities\ProjectsService;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{

    public function list(Request $request, ProjectsService $projectsService, UsersService $usersService)
    {
        $user = $usersService->getUser();
        return $projectsService->list($user, $request);
    }

    public function create(ProjectsDestroyRequest $projectsRequest, ProjectsService $projectsService, UsersService $usersService)
    {
        $user = $usersService->getUser();
        return $projectsService->craeteArray($user, $projectsRequest);
    }

    public function link(ProjectsAddRequest $projectsAddRequest, ProjectsService $projectsService, UsersService $usersService)
    {
        $user = $usersService->getUser();
        return $projectsService->linkUser($user, $projectsAddRequest->only('Projects'));
    }

    public function linkUser($users)
    {
        $projects = Project::where('');
        return ProjectResource::collection($projects);
    }

    public function destroy(ProjectsDestroyRequest $request, ProjectsService $projectsService, UsersService $usersService)
    {
        $user = $usersService->getUser();
        return $projectsService->destroy($user, $request->only('Projects')['Projects']);
    }
}
