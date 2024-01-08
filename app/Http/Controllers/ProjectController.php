<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Enquiry;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use DB;

class ProjectController extends Controller
{
    public function count(Request $request)
    {
        try {
            $status = $request->input('status', null);

            $totalCount = Project::count();
            $ongoingCount = Project::where('status', 'ongoing')->count();
            $completedCount = Project::where('status', 'completed')->count();
            $enquiriesCount = Enquiry::count();
            $contactCount = Contact::count();
            $data = [
                'total_projects' => $totalCount,
                'ongoing_projects' => $ongoingCount,
                'completed_projects' => $completedCount,
                'enquiries' => $enquiriesCount,
                "contactCount" => $contactCount
            ];

            return response()->json(['data' => $data, 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops! Something Went Wrong.' . $e->getMessage(), 'status' => 500]);
        }
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Project::createRules());

            if ($validator->fails()) {
                return response()->json(["message" => "Oops!" . $validator->errors()->first(), "status" => 400]);
            }
            $projectData = [
                'projectName' => $request->projectName,
                'status' => $request->status,
                'description' => $request->description,
                'location' => $request->location,
                'projectImage1' => $request->file('projectImage1')->store('image'),
                'projectImage2' => $request->file('projectImage2')->store('image'),
                'projectThumbnail' => $request->file('projectThumbnail')->store('thumbnails'),
                'overviewHeading' => $request->overviewHeading,
                'overviewContent' => $request->overviewContent,
                'overviewFooter' => $request->overviewFooter,
                'withinReach' => $request->withinReach,
                'withinReachImage' => $request->file('withinReachImage')->store('image'),
                'flatConfig' => $request->flatConfig,
            ];
            if ($request->hasFile('projectVideo')) {
                $projectData["projectVideo"] = $request->file('projectVideo')->store('video');
            }
            if ($request->hasFile('projectBanner')) {
                $projectData["projectBanner"] = $request->file('projectBanner')->store('banner');
            }
            if ($request->hasFile('brochure')) {
                $projectData["brochure"] = $request->file('brochure')->store('brochures');
            }
            if ($request->hasFile("propertyLogo")) {
                $projectData["propertyLogo"] = $request->file("propertyLogo")->store("propertyLogo");
            }
            $project = Project::create($projectData);

            return response()->json(["message" => "Project created successfully", "status" => 201]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(["message" => "Project name already exists.", "status" => 400]);
            } else {
                return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
            }
        }
    }


    public function getById(Request $request)
    {
        try {
            $projectId = $request->id;
            $project = Project::find($projectId);

            if (!$project) {
                return response()->json(['message' => 'Project not found'], 404);
            }
            $project->flatConfig = json_decode($project->flatConfig);
            $project->withinReach = json_decode($project->withinReach);

            $projectImages = [
                'architectural' => $project->gallery
                    ->where('imageType', 'architectural')
                    ->toArray(),
                'exterior' => $project->gallery
                    ->where('imageType', 'exterior')
                    ->toArray(),
                'interior' => $project->gallery
                    ->where('imageType', 'interior')
                    ->toArray(),
            ];
            $projectImages['architectural'] = array_values($projectImages['architectural']);
            $projectImages['exterior'] = array_values($projectImages['exterior']);
            $projectImages['interior'] = array_values($projectImages['interior']);

            $project["images"] = $projectImages;
            return response()->json(["data" => ["project" => $project], "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function getList(Request $request)
    {
        try {
            $list = Project::select('id', 'projectName', 'brochure', "projectImage1", "projectImage2", "isActive")->paginate(100);
            return response()->json(["data" => $list, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function getProjectListByStatus(Request $request)
    {
        try {
            $status = $request->status;
            if (empty($status)) {
                return response()->json(["message" => "Project Status is empty.", "status" => 400]);
            }
            Log::info('SQL Query', ['query' => Project::where('status', '=', $status)->toSql()]);
            Log::info('your-message', ['id' => $request->status]);
            // $list = Project::select('id', "projectName", "description", "status",
            //  "location", "projectImage", "projectVideo", "approvedPlan", "brochure", "projectNoc")->get();
            $list = Project::where('status', '=', $status)->paginate(1);
            //$list =  DB::table('projects')->orderBy('id')->cursorPaginate(1);
            return response()->json(["data" => $list, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function edit(Request $request)
    {
        try {
            // Fetch the project
            $projectId = $request->id;
            $project = Project::find($projectId);
            if (!$project) {
                return response()->json(["message" => "Project not found.", "status" => 404]);
            }
            // Update project fields
            $project->fill($request->only(['projectName', 'flatConfig', 'status', 'description', 'location', "overviewHeading", "overviewContent", "overviewFooter", "withinReach", 'isActive', "city"]));
            // Update file fields
            $project->flatConfig = json_encode($request->flatConfig);
            $fileFields = ['projectImage1', "propertyLogo", 'projectImage2', 'brochure', 'projectBanner', 'projectThumbnail', 'projectVideo', 'withinReachImage'];
            foreach ($fileFields as $fileField) {
                if ($request->hasFile($fileField)) {
                    $oldFilePath = $project->{$fileField};
                    if ($oldFilePath && Storage::exists($oldFilePath)) {
                        Storage::delete($oldFilePath);
                    }
                    $project->{$fileField} = $request->file($fileField)->store($fileField);
                }
            }
            // Save changes
            $project->save();
            // Return response
            return response()->json(["message" => "Project modified.", "status" => 200]);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error modifying project', ['error' => $e->getMessage()]);
            // Return error response
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $project = Project::find($request->id);
            if (!empty($project->projectImage) && $project->projectImage !== null) {
                Storage::delete($project->projectImage);
            }
            if (!empty($project->approvedPlan) && $project->approvedPlan !== null) {
                Storage::delete($project->approvedPlan);
            }
            if (!empty($project->brochure) && $project->brochure !== null) {
                Storage::delete($project->brochure);
            }
            if (!empty($project->projectNoc) && $project->projectNoc !== null) {
                Storage::delete($project->projectNoc);
            }
            if (!empty($project->projectVideo) && $project->projectVideo !== null) {
                Storage::delete($project->projectVideo);
            }
            if (!$project) {
                return response()->json(["message" => "Project not found.", "status" => 404]);
            }
            $project->delete();
            return response()->json(["message" => "Project deleted successfully.", "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }
}
