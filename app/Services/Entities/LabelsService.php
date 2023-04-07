<?php


namespace App\Services\Entities;


use App\Http\Requests\LabelsLinkRequest;
use App\Http\Requests\ProjectsDestroyRequest;
use App\Models\Continents;
use App\Models\Label;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class LabelsService
{
    public ProjectsService $projectsService;

    public function __construct()
    {
        $this->projectsService = new ProjectsService();
    }

    public function getIdAndCreate($user, array $labels)
    {
        $kays = [];
        foreach ($labels as $label) {
            $lab = Label::where('name', $label)->first();
            if ($lab)
                $kays[] = $lab->id;
            else
                $kays[] = $this->createArray($user, [$label])[0]->id;
        }

        return $kays;
    }

    public function createArray($user, array $names): array
    {
        foreach ($names as $name) {
            $label = new Label();
            $label->name = $name;
            $label->author_id = $user->id;
            $label->save();
            $labels[] = $label;
        }

        return $labels;
    }

    public function linkProjects(LabelsLinkRequest $labelsRequest)
    {
        foreach ($labelsRequest->Projects as $project) {
            $project = Project::find($project['ProjectId']);
            $this->projectsService->linkLabels($project, $project['Labels']);
        }
    }

    public function destroy($user, array $labelsd)
    {
        $lables = [];

        foreach ($labelsd as $kay => $lId) {
            $lables[$kay] = Project::find($lId);
            if ($lables[$kay]->author_id !== $user->id) {
                throw ValidationException::withMessages([
                    'Labels' => ['The labels does not belong to you!'],
                ]);
            }
        }

        foreach ($lables as $lable) {
            $lable->destroy();
        }

        return 'success';
    }
}
