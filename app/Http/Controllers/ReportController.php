<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use App\Models\Report;
use App\Models\ReportUser;
use App\Models\User;

use Response;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'referenceID' => 'required|integer',
        ]);
        $type = $request->type;
        $comment = $request->comment;
        if ($type == 'Job') {
            $jobPostID = $request->referenceID;
            $profilePostD = 0;
            $job = Job_Posts::findOrFail($jobPostID);
        } elseif ($type == 'Profile') {
            //dd($request->referenceID);
            $profilePostD = $request->referenceID;


            $jobPostID = 0;

            $profile = Profile_Posts::findOrFail($profilePostD);
        }


        $report = Report::where([
            ['status', 1],
            ['type', $type],
            ['job_post_id', $jobPostID],
            ['profile_post_id', $profilePostD],
        ])->first();


        if ($report != null) {
            $checkReport = ReportUser::where([
                ['user_id', Auth::user()->id],
                ['report_id', $report->id],
            ])->get();
            if ($checkReport->count()) {
                return back()->with('warning', 'Already Reported.');
            }
            $report->increment('count');
        } else {
            $report = Report::create([
                'status' => 1,
                'count' => 1,
                'type'=> $type,
                'job_post_id' => $jobPostID,
                'profile_post_id' => $profilePostD,
            ]);
        }

        $reportUser = new ReportUser();
        $reportUser->user_id = Auth::user()->id;
        $reportUser->report_id = $report->id;
        $reportUser->comment = $comment;
        $reportUser->save();

        if ($report->count > 2) {
            if ($type == 'Job') {
                if (!$job->adstatus) {
                    $job->adstatus = 1;
                    $job->suspendBy = 'Platform';
                }
            } elseif ($type == 'Profile') {
                if (!$profile->adstatus) {
                    $profile->adstatus = 1;
                    $profile->suspendBy = 'Platform';
                    $profile-save();
                }
            }
        }
        return back()->with('success', $type . ' reported successfully');
    }

    public function assignUserToReport($reportId)
    {
        $adminId = Auth::user()->id;
        if ($reportId != '') {
            // Find report details
            $report_job_post = Report::find($reportId);

            if ($report_job_post === null) {
                return back()->with('alert-warning', 'Invalid report');
            }
            if ($report_job_post->assigned_user_id !== null) {
                return back()->with('alert-warning', 'Report already assigned');
            }

            //Assign id:
            Report::where('id', $reportId)->update([
                'assigned_user_id' => $adminId
            ]);

            return back()->with('alert-success', 'Assigned successfully');
        }
    }

    public function adminAddReportNotes(Request $request)
    {
        $reportId = $request->reportId;
        $notes = $request->comment;
        if ($reportId != '') {
            //Update notes:
            Report::where('id', $reportId)->update([
                'user_notes' => $notes
            ]);

            return back()->with('alert-success', 'Notes added successfully');
        }
    }

    public function index($type, $status)
    {
        $status = Str::ucfirst($status);
        $statusBinary = ($status == 'Pending') ? 1 : 0;
        if ($type == "job-post") {
            $reportLists = Report::with('reportUsers', 'job', 'job.profilecategory')
                ->whereHas('reportUsers')
                ->whereHas('job')
                ->whereHas('job.profilecategory')
                ->where('type', 'Job')
                ->where('status', $statusBinary)
                ->orderBy('id', 'desc')
                ->get();
            return view('admin.report-job-list', compact('reportLists', 'status'));
        } elseif ($type == "profile-post") {
            $reportLists = Report::with('reportUsers', 'profile', 'profile.profilecat')
                ->whereHas('reportUsers')
                ->whereHas('profile')
                ->whereHas('profile.profilecat')
                ->where('type', '=', 'Profile')
                ->where('status', $statusBinary)
                ->orderBy('id', 'desc')
                ->get();
            return view('admin.report-profile-list', compact('reportLists', 'status'));
        } else {
            return back()->with('alert-warning', 'Could not get type of report');
        }
    }



    public function showReportedUsers($id)
    {
        $report = Report::find($id);
        $responseArray = [];
        $reportUsers = $report->reportUsers;
        foreach ($reportUsers as $key => $reportUser) {
            $responseArray[$key]['name'] = $reportUser->user->name . ' ' . $reportUser->user->last_name;
            $responseArray[$key]['email'] = $reportUser->user->email;
            $responseArray[$key]['reason'] = $reportUser->comment;
            $responseArray[$key]['date'] = \Carbon\Carbon::parse($reportUser->created_at)->format('d-m-Y');
        }

        return Response::json($responseArray);
    }

    public function userReportList($id)
    {
        $user = User::find($id);
        $responseData = '<table class="table table-bordered table-striped table-vcenter">
                            <thead class="thead-light">';
        if ($user->type == 'service_provider') {
            $responseData .= '<th>#</th>';
            $responseData .= '<th>Profile Category</th>';
            $responseData .= '<th>User Name</th>';
            $responseData .= '<th>Country</th>';
            $responseData .= '<th>Job Duration</th>';
            $responseData .= '<th>Pay Amount</th>';
            $responseData .= '<th>Pay Frequency</th>';
            $responseData .= '<th>Created On</th></thead><tbody>';
            $i = 0;

            foreach ($user->profileposts as $profile) {
                if ($profile->activeReports != null && $profile->activeReports->count()) {
                    $i++;
                    $responseData .= '<tr><td>' . $i . '</td>';
                    $responseData .= '<td>' . $profile->profilecat->categoryname . '</td>';
                    $responseData .= '<td>' . $user->name . '</td>';
                    $responseData .= '<td>' . $user->country . '</td>';
                    $responseData .= '<td>' . $profile->job_duration . '</td>';
                    $responseData .= '<td>' . config('kinderway.currencySymbols.'.$profile->currency) . $profile->payamount . '</td>';
                    $responseData .= '<td>' . $profile->payfrequency . '</td>';
                    $responseData .= '<td>' . \Carbon\Carbon::parse($profile->created_at)->format('jS M Y') . '</td></tr>';
                }
            }
            if ($i == 0) {
                $responseData .= '<tr><td colspan="8" class="text-center">No Profile Found</td></tr>';
            }
            $responseData .= '</tbody></table>';
        } else {
            $responseData .= '<th>#</th>';
            $responseData .= '<th>Job Title</th>';
            $responseData .= '<th>Job Category</th>';
            $responseData .= '<th>User Name</th>';
            $responseData .= '<th>User Type</th>';
            $responseData .= '<th>Country</th>';
            $responseData .= '<th>Status</th>';
            $responseData .= '<th>Marketing</th>';
            $responseData .= '<th>Created On</th>';
            $responseData .= '<th>Expiry Date</th></thead><tbody>';
            $i = 0;

            foreach ($user->jobPosts as $job) {
                if ($job->activeReports != null && $job->activeReports->count()) {
                    $i++;
                    $responseData .= '<tr><td>' . $i . '</td>';
                    $responseData .= '<td>' . strlen($job->jobtitle) > 12 ? trim(substr($job->jobtitle, 0, 12)).'..' : $job->jobtitle . '</td>';
                    $responseData .= '<td>' . $job->profilecategory->categoryname . '</td>';
                    $responseData .= '<td>' . $user->name . '</td>';
                    $responseData .= '<td>' . $user->usertype . '</td>';
                    $responseData .= '<td>' . $user->country . '</td>';
                    $responseData .= '<td>' . ($job->adstatus ==1) ? "Active" : 'Suspended By '.$job->suspendBy . '</td>';
                    $responseData .= '<td>' . ($job->marketing) ? "Yes" : 'No' . '</td>';
                    $responseData .= '<td>' . \Carbon\Carbon::parse($job->created_at)->format('jS M Y') . '</td>';
                    $responseData .= '<td>' . \Carbon\Carbon::parse($job->expirydt)->format('jS M Y') . '</td></tr>';
                }
            }
            if ($i == 0) {
                $responseData .= '<tr><td colspan="8" class="text-center">No Job Found</td></tr>';
            }
            $responseData .= '</tbody></table>';
        }
        return $responseData;
    }
}
