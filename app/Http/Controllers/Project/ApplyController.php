<?php

namespace App\Http\Controllers\Project;

use App\ApplicantTeamMember;
use App\Http\Controllers\Controller;
use App\IndividualApplicant;
use App\Project;
use App\ProjectBox;
use App\ProjectTeam;
use App\ProjectTeamMember;
use App\TeamApplicant;
use App\User;
use Illuminate\Http\Request;
use App\InternshipOffre;
class ApplyController extends Controller
{









    public function applyAsIndividual(Request $request, Project $project)
    {
        $applicant = $request->get('apply');
        $sender_id = $request->user()->id;
        $recipient_id = User::findOrFail($project->user_id)->id;

        if ($project->is_open_hiring) {
            $projectTeam = ProjectTeam::firstOrCreate(
                [
                    'project_id' => $project->id,
                ]
            );

            $isAlreadyInTeamMembers = ProjectTeamMember::where(
                [
                    'project_team_id' => $projectTeam->id,
                    'member_id' => $sender_id,
                ]
            )->first();

            if ($isAlreadyInTeamMembers) {
                return response()->json([
                    'message' => "You already joined the project team members",
                ], 400);
            }

            IndividualApplicant::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'from_id' => $sender_id,
                    'to_id' => $recipient_id,
                ],
                [
                    'expertise' => $applicant['expertise'],
                    'self_describe' => $applicant['self_describe'],
                    'apply_reason' => $applicant['apply_reason'],
                ]
            );

            ProjectBox::firstOrCreate(
                [
                    'user_id' => $sender_id,
                    'project_id' => $project->id,
                    'status' => 'Waiting',
                ]
            );

            return response()->json([
                'message' => "Individual Application Submitted",
            ]);
        } else {
            return response()->json([
                'message' => 'Project hiring is closed',
            ], 400);
        }
    }
}
