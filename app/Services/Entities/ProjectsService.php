<?php


namespace App\Services\Entities;


use App\Http\Requests\ProjectsDestroyRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Continents;
use App\Models\Project;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ProjectsService
{
    public LabelsService $labelsService;

    public function __construct()
    {
        $this->labelsService = new LabelsService();
    }


    public function list($user, $request)
    {
        $projects = Project::all();
        return ProjectResource::collection($projects);
    }

    public function craeteArray($user, ProjectsDestroyRequest $projectsRequest)
    {
        foreach ($projectsRequest->Projects as $project) {
            $this->create($user, $project);
        }

        return 'success';
    }

    public function create($user, array $project)
    {
        $projectModel = new Project();
        $projectModel->name = $project['ProjectName'];
        $projectModel->author_id = $user->id;
        $projectModel->save();

        $labelsId = $this->labelsService->getIdAndCreate($user, $project['Labels']);
        $this->linkLabels($projectModel, $labelsId);
        $this->linkUser($user, [$projectModel->id]);
    }

    public function linkUser($user, array $projectsId)
    {
        foreach ($projectsId as $id) {

            $u = User::find($user->id);
            $u->projects()->attach($id);
        }

        return 'success';
    }

    public function linkLabels(Project $projectModel, $labelsId)
    {
        foreach ($labelsId as $id) {
            $projectModel->labels()->attach($id);
        }
    }

    public function destroy($user, array $projectsId)
    {
        $projects = [];

        foreach ($projectsId as $kay => $pId) {
            $project[$kay] = Project::find($pId);
            if ($project[$kay]->author_id !== $user->id) {
                throw ValidationException::withMessages([
                    'Project' => ['The project does not belong to you!'],
                ]);
            }
        }

        foreach ($projects as $project) {
            $project->destroy();
        }

        return 'success';
    }
}
