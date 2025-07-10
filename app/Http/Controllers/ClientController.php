<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\countries;
use App\Models\Specialities;
use App\Models\Experiences;
use App\Models\Job_Types;
use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use App\Models\User_Connections;
use App\Models\Document;
use App\Models\DocumentUser;
use App\Models\Profile_Categories;
use App\Services\Slug;
Use App\Models\AccessRequest;

use Chatify\Http\Models\Message;
use Chatify\Http\Models\Favorite;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Carbon\Carbon;

use Response;
use Session;
use Helper;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClientController extends Controller
{
    protected $basic_detail;
    protected $slug;

    public function __construct(Slug $slug)
    {
        $this->basic_detail['countries'] = countries::all();
        $this->basic_detail['londoncity'] = config('kinderway.londoncity');
        $this->basic_detail['londonpostal'] = config('kinderway.londonpostal');
        $this->basic_detail['languages'] = config('kinderway.language_supported');
        $this->basic_detail['languageCount'] = count($this->basic_detail['languages']);
        $this->basic_detail['job'] = null;
        $this->slug = $slug;
    }

    public function dashboard()
    {
        $alluser_jobs = Job_Posts::with(['userconnection'=> function ($query) {
            $query->where('providerconnect', 1)
                ->orderBy('updated_at', 'desc');
        }])->Where('user_id', Auth::user()->id)
            ->whereDate('grace_date', '>=', Carbon::now())
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        foreach($alluser_jobs as $job){
            foreach($job->userconnection as $key => $userconnection){
                $providerProfile = User::find($userconnection->provider_id);
                $categoryName = Profile_categories::where('id',$job->profile_category_id)->first();
                $job->userconnection[$key]['NameProvider'] = $providerProfile['name'];
                $job->userconnection[$key]['categoryname'] = $categoryName['categoryname'];
            }
        }
        
        $total_dashbrd_jobs = count($alluser_jobs);
        return view('user.client.dashboard', compact('alluser_jobs', 'total_dashbrd_jobs'));
    }

    public function getNewJobNotification(Request $request)
    {
        if ($request->ajax()) {
            $alluser_jobs = Job_Posts::with(['userconnection'=> function ($query) {
                $query->where('providerconnect', 1)
                    ->orderBy('updated_at', 'desc');
            }])->Where('user_id', Auth::user()->id)
                ->whereDate('grace_date', '>=', Carbon::now())
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
    
            foreach($alluser_jobs as $job){
                foreach($job->userconnection as $key => $userconnection){
                    $providerProfile = User::find($userconnection->provider_id);
                    $categoryName = Profile_categories::where('id',$job->profile_category_id)->first();
                    $job->userconnection[$key]['NameProvider'] = $providerProfile['name'];
                    $job->userconnection[$key]['categoryname'] = $categoryName['categoryname'];
                }
            }
            
            $total_dashbrd_jobs = count($alluser_jobs);
    
            $html = view('partials.job_notification', compact('alluser_jobs', 'total_dashbrd_jobs'))->render();

            return response()->json(['html' => $html]);
      
        }
    }

    public function manageProfile()
    {
        $this->basic_detail['profile_picture'] = Storage::url(Auth::user()->profile_picture);
        return view('user.client.manage-profile', $this->basic_detail);
    }

    public function getAllJobtype(Request $request)
    {
        $profileid = $request->profileid;
        $jtypes = job_types::where('profile_id', $profileid)->get();
        $html = view('user.client.jobtypeslist', compact('jtypes'))->render();

        return Response::json(['success' => '1', 'html' => $html]);
    }

    public function getAllLoaders(Request $request)
    {
        /*echo "abc";
        dd($request->all());*/
        $profileid = $request->profileid;

        $specialities = specialities::where('profile_category_id', $profileid)->get();

        $experiences = experiences::where('profile_category_id', $profileid)->get();

        $html = view('user.client.positionlist', compact('experiences'))->render();

        $html1 = view('user.client.workwithlist', compact('specialities'))->render();

        return Response::json(['success' => '1', 'html' => $html, 'html1' => $html1]);
    }

    public function addjobpost(Request $request)
    {
        if ($request) {
            $data = $request->All();
            // dd($data);exit;

            $btnpressed = (isset($data['btnpressed'])) ? $data['btnpressed'] : '';
            $calendar1 = (isset($data['calendar1'])) ? $data['calendar1'] : '';

            $profilecat = (isset($data['options'])) ? $data['options'] : '';
            $duration = (isset($data['duration'])) ? $data['duration'] : '';
            $jobtitle = (isset($data['jobtitle'])) ? $data['jobtitle'] : '';
            $job_position = (isset($data['job_position'])) ? $data['job_position'] : '';
            $country = (isset($data['country1'])) ? $data['country1'] : '';
            $uk_country = (isset($data['uk_country'])) ? $data['uk_country'] : '';
            $city = (isset($data['city'])) ? $data['city'] : '';
            $postal_code = (isset($data['postal_code'])) ? $data['postal_code'] : '';
            $ukcity = (isset($data['ukcity'])) ? $data['ukcity'] : '';

            if ($job_position != "UK") {
                $city = $city;
                $postal_code = '';
            } else {
                $country = $uk_country;
                $city = $ukcity;
            }

            $landmark = (isset($data['landmark'])) ? $data['landmark'] : '';
            $address = (isset($data['address'])) ? $data['address'] : '';
            $paymentOption = (isset($data['paymentOption'])) ? $data['paymentOption'] : 'fix';
            $hrsperweek = (isset($data['hrsperweek'])) ? $data['hrsperweek'] : '';
            $paycurrency = (isset($data['paycurrency'])) ? $data['paycurrency'] : '';
            $payamountfrom = (isset($data['payamountfrom'])) ? $data['payamountfrom'] : 0;
            $payamountto = (isset($data['payamountto'])) ? $data['payamountto'] : 0;
            $edu_details = (isset($data['edu_details'])) ? $data['edu_details'] : '';

            $req_language = (isset($data['req_language'])) ? $data['req_language'] : '';
            $req_language = implode(', ', $req_language);

            $preffered_lang = (isset($data['preffered_lang'])) ? $data['preffered_lang'] : '';
            $preffered_lang = (is_array($preffered_lang)) ? implode(', ', $preffered_lang) : '';
            $frequency = (isset($data['frequency'])) ? $data['frequency'] : '';
            $job_details = (isset($data['job_details'])) ? $data['job_details'] : '';
            $asap = $data['date'] == 'asap' ? 'asap' : '';
            $marketing = (isset($data['marketing'])) ? $data['marketing'] : 0;
            //Add one month to calendar date and set expiry date:
            $expiryDate = date('Y-m-d', strtotime('+60 days'));
            $graceDate = date('Y-m-d', strtotime('+60 days'));
            if ($asap != '') {
                $calendar1 = '';
            }

            $workschedule = (isset($data['workschedule'])) ? $data['workschedule'] : '';

            // $jobtype_opt = $exp_opt = $workwith = 0;
            $jobtype_opt = $exp_opt = $workwith = null;

            //Job type
            $options_jobtype = (isset($data['options_jobtype'])) ? $data['options_jobtype'] : '';
            if ($options_jobtype != '') {
                $jobtype_opt = implode(',', $options_jobtype);
            }

            //Experiece
            $options_exp = (isset($data['options_exp'])) ? $data['options_exp'] : '';
            if ($options_exp != '') {
                $exp_opt = implode(',', $options_exp);
            }

            //Work with
            $options_outlined = (isset($data['options_outlined'])) ? $data['options_outlined'] : '';
            if ($options_outlined != '') {
                $workwith = implode(',', $options_outlined);
            }

            if ($btnpressed == 'savebutton') {
                $setpublish = '0';
            } else {
                $setpublish = '1';
            }

            $usertype_val = User::select('id', 'client_type')->where('id', Auth::user()->id)->first();

            $insertProfile = Job_Posts::create([
                'user_id' => Auth::user()->id,
                'usertype' => $usertype_val['client_type'],
                'profile_category_id' => $profilecat,
                'jobtypes' => $jobtype_opt,
                'jobtitle' => $jobtitle,
                'slug' => $this->slug->createSlug('job', $jobtitle),
                'job_position' => $job_position,
                'postalcode' => $postal_code,
                'country' => $country,
                'city' => $city,
                'landmark' => $landmark,
                'address' => $address,
                'jobduration' => $duration,
                'position' => $exp_opt,
                'workwith' => $workwith,
                'req_language' => $req_language,
                'pref_language' => $preffered_lang,
                'asap' => $asap,
                'start_date' => $calendar1,
                'paymentOption' => $paymentOption,
                'payamountcurrency' => $paycurrency,
                'payamount_from' => $payamountfrom,
                'payamount_to' => $payamountto,
                'payfrequency' => $frequency,
                'hoursperweek' => $hrsperweek,
                'workschedule' => $workschedule,
                'job_details' => $job_details,
                'publish' => $setpublish,
                'adstatus' => $setpublish,
                'expirydt' => $expiryDate,
                'grace_date' => $graceDate,
                'marketing' => $marketing,
            ]);

            if ($setpublish == 0) {
                Session::flash('success', 'Job has been saved successfully');
                return Response::json(
                    [
                    'success' => '1',
                    'message' => 'Job has been saved successfully']
                );
            } else {
                Session::flash('success', 'Your job was posted successfully and will be live for the next 60 days.');
                return Response::json(['success' => '1', 'message' => 'Your job was posted successfully and will be live for the next 60 days.']);
            }
        }
    }

    public function updateJobNote(Request $request)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $data = $request->All();
        $note = (isset($data['comment'])) ? $data['comment'] : '';
        Job_Posts::where('id', $data['referenceID'])->update([
            'notes' => $note
        ]);
        return back()->with('success', 'Note has been updated successfully.');
    }

    public function updateApplicationJobNote(Request $request)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $data = $request->All();
        $note = (isset($data['comment'])) ? $data['comment'] : '';
        User_Connections::where('id', $data['referenceID'])->update([
            'notes' => $note
        ]);
        return back()->with('success', 'Note has been updated successfully.');
    }

    public function postVacancy()
    {
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '1')->get();
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '1')->get();
        return view('user.client.post-vacancy', $this->basic_detail);
    }

    public function manageAccount()
    {
        return view('user.client.manage-account');
    }

    public function update_user_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'phone_code' => 'required',
            'phone' => 'required',
            'job_position' => 'required',
            /*'country' => 'required',*/
            /*'city' => 'required',*/
            'landmark' => 'required',
        ]);
        $data = $request->All();

        $name = (isset($data['name'])) ? $data['name'] : '';
        $last_name = (isset($data['last_name'])) ? $data['last_name'] : '';
        $phone_code = (isset($data['phone_code'])) ? $data['phone_code'] : '';
        $phone = (isset($data['phone'])) ? $data['phone'] : '';
        $secondary_notifications = (isset($data['secondary_notifications'])) ? 1 : 0;
        $job_position = (isset($data['job_position'])) ? $data['job_position'] : '';
        $country = (isset($data['country'])) ? $data['country'] : '';
        $uk_country = (isset($data['uk_country'])) ? $data['uk_country'] : '';
        $city = (isset($data['city'])) ? $data['city'] : '';
        $postal_code = (isset($data['postal_code'])) ? $data['postal_code'] : '';
        $landmark = (isset($data['landmark'])) ? $data['landmark'] : '';
        $address = (isset($data['address'])) ? $data['address'] : '';
        $ukcity = (isset($data['ukcity'])) ? $data['ukcity'] : '';

        if ($job_position != "UK") {
            $city = $city;
            $postal_code = '';
        } else {
            $country = $uk_country;
            $city = $ukcity;
        }

        User::where('id', Auth::user()->id)->update([
            'name' => $name,
            'last_name' => $last_name,
            'phone_code' => $phone_code,
            'phone' => $phone,
            'secondary_notifications' => $secondary_notifications,
            'job_position' => $job_position,
            'country' => $country,
            'city' => $city,
            'postal_code' => $postal_code,
            'landmark' => $landmark,
            'address' => $address,
        ]);
        return back()->with('success', 'Profile has been saved.');
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'confirm_password' => 'required',
        ]);
        $data = $request->All();

        if (Hash::check($data['old_password'], Auth::user()->password)) {
            if ($data['confirm_password'] == $data['new_password']) {
                User::where('id', Auth::user()->id)->update(['password' => Hash::make($data['new_password'])]);
                return back()->with('success', 'Password has been updated.');
            }
        }
        return back()->with('warning', 'something went wrong.');
    }

    public function update_profile_picture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'mimes:jpeg,jpg,png,gif,svg|required' //|max:10000 = max 10000kb
        ]);
        $data = $request->All();

        $path = $request->file('profile_picture')->store('profile_picture', 'public');
        User::where('id', Auth::user()->id)->update(['profile_picture' => $path]);
        return back()->with('success', 'Picture has been uploaded.');
    }

    public function getDashboarLoadMore(Request $request)
    {
        $jobid = $request->jobid;
        $skipVal = $request->skipval;
        $totalApply = $request->totalapply;

        if ($jobid != '') {
            //Get all connections
            $allconnections = User_Connections::with('job', 'jobProvider', 'jobPoster')
                ->where('jobappliedid', $jobid)
                ->where('providerconnect', 1)
                ->orderBy('updated_at', 'desc')
                ->skip($skipVal)->take(4)->get();
            //  dd(count($allconnections));exit;

            $setnew_skip = count($allconnections);
            $setnew_skip = $skipVal + $setnew_skip;
            $nextDiv = '';

            //Check if to show add more button or not:
            $displayremains = 0;
            if ($setnew_skip < $totalApply) {
                $displayremains = $totalApply - $setnew_skip;
            }

            $addremains = 1;
            if ($setnew_skip == $totalApply) {
                $addremains = 0;
            }

            if (count($allconnections) > 0) {
                foreach ($allconnections as $allconnection) {
                    $startDiv = '<div class="col-lg-12 pl-0 pr-0  addReadMore' . $jobid . '">';

                    $nextDiv .= '<div class="post-topbar mt-1 mb-1 added_more' . $jobid . '"
                         style="border-top: 1px solid #e5e5e5; background-color: #f7f7f7">
                        <div class="row">
                            <div class="col-md-8 p-0">
                                <div class="user-picy">
                                    <img src="' . Helper::getProfilePic($allconnection['provider_id']) . '"
                                         style="border-radius: 14px;" alt="">
                                </div>
                                <h3 style="display: inline-block; padding-left:12px; padding-top:18px;">
                                    ' . Helper::getUserName($allconnection['provider_id']) . '
                                </h3>';

                    $nextDiv .= '<span class="float-right-desktop" style="font-size: 14px; font-style: italic; color: #304384; font-weight: bold; padding-top: 15px;">';
                    if (!$allconnection->jobconnect) {
                        if ($allconnection['requested_by'] == "service_provider") {
                            $nextDiv .= 'You have a New Application';
                        }
                    }
                    if ($allconnection->jobconnect) {
                        if (Helper::getTotalCount($allconnection['id'], $allconnection['job_userid']) == 0) {
                            $nextDiv .= 'You have a New Connection';
                        }
                        if (Helper::getUnseenCount($allconnection['id'], $allconnection['job_userid']) > 0) {
                            $nextDiv .= 'You have a New Message';
                        }
                    }
                            //     @if(!$post->jobconnect)
                            //         @if($post['requested_by'] == 'service_provider')
                            //             You have a new application
                            //         @endif
                            //     @endif
                            //     @if($post->jobconnect)
                            //         @if(Helper::getTotalCount($post['id'],$post['job_userid']) == 0)
                            //             You have a New Connection
                            //         @endif
                            //         @if(Helper::getUnseenCount($post['id'],$post['job_userid']) > 0)
                            //             You have a New Message
                            //         @endif
                            //     @endif
                    $nextDiv .= '</span>';


                    // if ($allconnection['requested_by'] == "service_provider") {
                //     $nextDiv .= '<span> has applied to your job</span>';
                    // } else {
                //     $nextDiv .= '<span> was invited by you</span>';
                    // }

                    // if ($allconnection->jobconnect && Helper::getUnseenCount($allconnection['id'], $allconnection['job_userid']) == 0) {
                //     $nextDiv .= '<span> You have a New Connection</span>';
                    // }

                    // if ($allconnection->jobconnect && Helper::getUnseenCount($allconnection['id'], $allconnection['job_userid']) > 0) {
                //     $nextDiv .= '<span> You have a New Message</span>';
                    // }

                    $nextDiv .= '</div>';
                    $nextDiv .= '<div class="col-md-4 p-0">

                <div class="row">
                <div class="col-11 p-0">

                                <ul class="bk-links mt-2">';

                    if ($allconnection->jobconnect) {
                        $nextDiv .= '<li><a id="chatbtn" type="button" data-toggle="modal" class="message_now" style="color: #fff; padding: 0 5px;"';
                        if ($allconnection->job->adstatus && $allconnection->profile->status) {
                            $nextDiv .= 'data-target="#modal_aside_right" onclick="viewFullProfile(' . $allconnection['providerprofileid'] . ',' . $allconnection['id'] . ',\'messagewindow\' );"';
                        } else {
                            if ($allconnection->job->adstatus) {
                                $nextDiv .= 'data-target="#suspended-job"';
                            } else {
                                $nextDiv .= 'data-target="#suspended-profile"';
                            }
                        }
                        $nextDiv .= '>
                                                 <i class="fas fa-comment" style="background-color: transparent; width:45px;">
                                                     <span id="chatCount-' . $allconnection['id'] . '">' . Helper::getUnseenCount($allconnection['id'], $allconnection['job_userid']) . '</span>
                                                 </i>
                                             </a>
                                             </li>';

                    // <li><a type="button" class="cancel"
                                        //        onclick="cancelConnect(' . $allconnection['id'] . ',\'deletebtn\');"
                                        //        style="color: #fff; padding: 0;"><i class="la la-close" style="background-color: #fb9300;"></i></a></li>
                    } else {
                        $nextDiv .= '<li><a type="button" class="cancel" title="Approve" data-toggle="tooltip" data-original-title="Approve" data-placement="bottom"';
                        if ($allconnection->job->adstatus && $allconnection->profile->status) {
                            $nextDiv .= 'data-toggle="tooltip" data-placement="bottom" onclick="approveConnect(' . $allconnection['id'] . ');"';
                        } else {
                            if ($allconnection->job->adstatus) {
                                $nextDiv .= 'data-target="#suspended-job"';
                            } else {
                                $nextDiv .= 'data-target="#suspended-profile"';
                            }
                        }
                        $nextDiv .= 'style="color: #fff; padding: 0;"><i class="la la-check bg-success"></i></a> </li>
                                        <li><a type="button"
                                               class="cancel"
                                               title="Reject"
                                               data-original-title="Reject"
                                               data-toggle="tooltip"
                                               data-placement="bottom"
                                               onclick="cancelConnect(' . $allconnection['id'] . ',\'rejectbtn\');"
                                               style="color: #fff; padding: 0;"><i class="la la-close" style="background-color: #fb9300;"></i></a>
                                        </li>';
                    }
                    $nextDiv .= '<li class="pl-1"><a type="button" class="bid_now" style="color: #fff; padding: 0 20px;" data-toggle="modal"';
                    if ($allconnection->job->adstatus && $allconnection->profile->status) {
                        $nextDiv .= 'onclick="viewFullProfile(' . $allconnection['providerprofileid'] . ',' . $allconnection['id'] . ',' . $allconnection['jobconnect'] . ');" data-target="#modal_aside_right">';
                    } else {
                        if ($allconnection->job->adstatus) {
                            $nextDiv .= 'data-target="#suspended-job">';
                        } else {
                            $nextDiv .= 'data-target="#suspended-profile">';
                        }
                    }
                    $nextDiv .= 'View Profile</a></li>';
                    $nextDiv .= '
                                </ul>

                                </div>
                                <div class="col-1 p-0">
                                    <i class="la la-ellipsis-v ed-opts-open three-dots-provider mt-2" onclick="openDrawer('.$allconnection['id'].')" style=""></i>
                                    <ul class="ed-options '.$allconnection['id'].'">';
                    if ($allconnection->jobconnect) {
                        $nextDiv .= '<li onclick="cancelConnect(' . $allconnection['id'] . ',\'deletebtn\');">Delete Connection</li>';
                    }
                    $nextDiv .= '<li onclick="reportConnect('.$allconnection['id'].', \'Report Profile\');">Report Profile</li>
                                    </ul>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>';

                    $finalValue = $startDiv . $nextDiv;
                }
                return Response::json(['success' => '1', 'setNext' => $finalValue, 'jobid' => $jobid, 'newskip' => $setnew_skip, 'addremains' => $addremains, 'displayremains' => $displayremains]);
            }
        }
    }

    public function deleteConnection(Request $request)
    {
        if ($request->ajax()) {
            $connectid = $request->connectid;
            $result = User_Connections::where('id', $connectid)
            ->where(function($query) {
                $query->where('job_userid', Auth::user()->id)
                      ->orWhere('provider_id', Auth::user()->id);
            })
            ->first(['job_userid', 'provider_id']);
        
            $relevantId = null;
            if ($result) {
                if ($result->job_userid != Auth::user()->id) {
                    $relevantId = $result->job_userid;
                } elseif ($result->provider_id != Auth::user()->id) {
                    $relevantId = $result->provider_id;
                }
            }

            Chatify::push('private-chatify-notification', 'messaging', [
                'from_id' => Auth::user()->id,
                'to_id' => $relevantId,
                'reference_id' => $connectid,
                'message' => ""
            ]);
            if (Message::where('reference_id', $connectid)->exists()) {
                Message::where('reference_id', $connectid)->delete();
            }

            User_Connections::Where('id', $connectid)->delete();

            return Response::json(['success' => '1', 'message' => 'Connection deleted successfully']);
        }
    }

    public function approveConnection(Request $request)
    {
        if ($request->ajax()) {
            $connectid = $request->connectid;

          
            $userConnection = User_Connections::find($connectid);
            $userConnection->jobconnect = 1;
            $userConnection->fullconnect = 1;
            $userConnection->save();

            $userConnection->job()->touch();


            
            $result = User_Connections::where('id', $connectid)
            ->where(function($query) {
                $query->where('job_userid', Auth::user()->id)
                      ->orWhere('provider_id', Auth::user()->id);
            })
            ->first(['job_userid', 'provider_id']);
        
            $relevantId = null;
            if ($result) {
                if ($result->job_userid != Auth::user()->id) {
                    $relevantId = $result->job_userid;
                } elseif ($result->provider_id != Auth::user()->id) {
                    $relevantId = $result->provider_id;
                }
            }

            Chatify::push('private-chatify-notification', 'messaging', [
                'from_id' => Auth::user()->id,
                'to_id' => $relevantId,
                'reference_id' => $connectid,
                'message' => ""
            ]);

            $providerId = $result->provider_id;
            $seekerId = Auth::user()->id;

            $documents = Document::where('provider_id', $providerId)->get();
            $existingDocumentIds = DocumentUser::where('provider_id', $providerId)
                ->where('seeker_id', $seekerId)
                ->pluck('document_id')
                ->toArray();

            foreach ($documents as $document) {
                if (!in_array($document->id, $existingDocumentIds)) {
                    $documentuser = DocumentUser::create([
                        'provider_id' => $providerId,
                        'seeker_id' => $seekerId,
                        'document_id' => $document->id,
                        'is_access_granted' => false,
                        'is_access_blocked' => false,
                    ]);
                }
            }

            //Send mail on approval:
            Helper::approveConnectionMail($connectid);

            return Response::json(['success' => '1', 'message' => 'Connection approved successfully']);
        }
    }

    public function getValuesForIds($modelvalue, $dbvalue)
    {
        $arr = [];
        $all_exp = explode(',', $dbvalue);
        for ($i = 0; $i < count($all_exp); $i++) {
            if ($modelvalue == 'workwith') {
                $temp = Specialities::where('id', $all_exp[$i])->first();
                $temparr = $temp->toArray();
                $arr[] = $temparr['name'];
            } elseif ($modelvalue == 'position') {
                $temp = Experiences::where('id', $all_exp[$i])->first();
                $temparr = $temp->toArray();
                $arr[] = $temparr['exp_name'];
            } elseif ($modelvalue == 'jobtypes') {
                $temp = Job_Types::where('id', $all_exp[$i])->first();
                $temparr = $temp->toArray();
                $arr[] = $temparr['jobtype'];
            }
        }
        return $arr;
    }

    public function getUserDetails(Request $request)
    {
        if ($request->currpopup) {
            $currpopup = $request->currpopup;
            $conid = $request->conid;
            $fullconnect = $request->fullconnect;

            $profile_posts = Profile_Posts::where('id', $currpopup)->with('userdetails', 'userdetails.getVerified')->first();

            //jobtype
            $all_jobtypes = [];
            $all_jtypes = $this->getValuesForIds('jobtypes', $profile_posts->jobtypes);

            //work with
            $all_workwith = [];
            $all_workwith = $this->getValuesForIds('workwith', $profile_posts->workwith);

            $conn_data = User_Connections::find($conid);
            
            $provider_id = $conn_data->provider_id;
            $seeker_id = Auth::user()->id;

            $documents = Document::where('provider_id', $provider_id)->get();
            $existingDocumentIds = DocumentUser::where('provider_id', $provider_id)
                ->where('seeker_id', Auth::user()->id)
                ->pluck('document_id')
                ->toArray();

            foreach ($documents as $document) {
                if (!in_array($document->id, $existingDocumentIds)) {
                    $documentuser = DocumentUser::create([
                        'provider_id' => $provider_id,
                        'seeker_id' =>$seeker_id,
                        'document_id' => $document->id,
                        'is_access_granted' => false,
                        'is_access_blocked' => false,
                    ]);
                }
            }
            
            $documents_count = Document::where('provider_id', $provider_id)->count();
            
            $doc_access_data = DocumentUser::where('provider_id', $provider_id)
                ->where('seeker_id', Auth::user()->id)
                ->get();
            
            $doc_access_ids = $doc_access_data->pluck('document_id');
            
            $documents = $doc_access_ids->isNotEmpty()
                ? Document::whereIn('id', $doc_access_ids)->get()
                : collect();
            
            $html = view('user.client.viewprofile', compact(
                'provider_id',
                'seeker_id',
                'doc_access_data',
                'conid',
                'profile_posts',
                'all_jtypes',
                'all_workwith',
                'fullconnect',
                'documents_count',
                'documents'
            ))->render();

            return Response::json(['success' => '1', 'html' => $html]);
        }
    }

    public function stopJob(Request $request)
    {
        if ($request->ajax()) {
            $jobId = $request->jobid;
            $jobStatus = $request->jobstatus;

            $setStatus = ($jobStatus == 1) ? 0 : 1;

            Job_Posts::Where('id', $jobId)->update([
                'adstatus' => $setStatus,
                'publish' => $setStatus
            ]);
            return Response::json(['success' => '1', 'message' => 'Job status set successfully']);
        }
    }

    public function jobSoftDelete(Request $request)
    {
        $jobId = $request->jobid;

        if ($jobId != '') {
            Helper::softDeleteAllJobs($jobId, 'Self');
            return Response::json(['success' => '1', 'message' => "Job deleted successfully!"]);
        }
    }

    public function viewFullJob(Request $request)
    {
        $jobId = $request->jobid;
        if ($jobId != '') {
            $jPosts = job_posts::where('id', $jobId)->with('userdetails')->first();

            //jobtype
            $all_jobtypes = [];
            $all_jtypes = $this->getValuesForIds('jobtypes', $jPosts->jobtypes);

            //work with
            $all_workwith = [];
            $all_workwith = $this->getValuesForIds('workwith', $jPosts->workwith);

            //experience - work skills
            $all_work_skills = [];
            $all_work_skills = $this->getValuesForIds('position', $jPosts->position);

            //req_language
            $rLang = $jPosts->req_language;
            $reqLang = explode(',', $rLang);
            //Additional Languages
            $preferredLanguages = ($jPosts->pref_language != '') ? explode(',', $jPosts->pref_language) : '';

            $html = view('user.client.viewjob', compact('jPosts', 'all_workwith', 'all_work_skills', 'all_jtypes', 'reqLang', 'preferredLanguages'))->render();

            return Response::json(['success' => '1', 'html' => $html]);
        }
    }

    public function postVacancyEdit(int $id): View
    {
        $this->basic_detail['job'] = job_posts::where('id', $id)->with('userdetails')->first();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '1')->get();
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '1')->get();
        return view('user.client.post-vacancy', $this->basic_detail);
    }

    public function postVacancyEditModel(int $id): View
    {
        $this->basic_detail['job'] = job_posts::where('id', $id)->with('profilecategory', 'userdetails')->first();
        $this->basic_detail['categoryname'] = $this->basic_detail['job']->profilecategory->categoryname;
        $this->basic_detail['types'] = Job_Types::where('profile_id', $this->basic_detail['job']['profile_category_id'])->get();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', $this->basic_detail['job']['profile_category_id'])->get();
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', $this->basic_detail['job']['profile_category_id'])->get();

        return view('user.client.partials.post-vacancy.modal-edit-dashboard', $this->basic_detail);
    }

    public function savePostVacancyEdit(int $id, Request $request): JsonResponse
    {
        $this->basic_detail['job'] = job_posts::where('id', $id)->with('userdetails')->first();

        if ($request) {
            $data = $request->All();
            // dd($data);exit;

            $btnpressed = (isset($data['btnpressed'])) ? $data['btnpressed'] : '';
            $calendar1 = (isset($data['calendar1'])) ? $data['calendar1'] : '';

            $profilecat = (isset($data['options'])) ? $data['options'] : '';
            $duration = (isset($data['duration'])) ? $data['duration'] : '';
            $jobtitle = (isset($data['jobtitle'])) ? $data['jobtitle'] : '';
            $job_position = (isset($data['job_position'])) ? $data['job_position'] : '';
            $country = (isset($data['country1'])) ? $data['country1'] : '';
            $uk_country = (isset($data['uk_country'])) ? $data['uk_country'] : '';
            $city = (isset($data['city'])) ? $data['city'] : '';
            $postal_code = (isset($data['postal_code'])) ? $data['postal_code'] : '';
            $ukcity = (isset($data['ukcity'])) ? $data['ukcity'] : '';

            if ($job_position != "UK") {
                $city = $city;
                $postal_code = '';
            } else {
                $country = $uk_country;
                $city = $ukcity;
            }

            $landmark = (isset($data['landmark'])) ? $data['landmark'] : '';
            $address = (isset($data['address'])) ? $data['address'] : '';
            $paymentOption = (isset($data['paymentOption'])) ? $data['paymentOption'] : 'fix';
            $hrsperweek = (isset($data['hrsperweek'])) ? $data['hrsperweek'] : '';
            $paycurrency = (isset($data['paycurrency'])) ? $data['paycurrency'] : '';
            $payamountfrom = (isset($data['payamountfrom'])) ? $data['payamountfrom'] : 0;
            $payamountto = (isset($data['payamountto'])) ? $data['payamountto'] : 0;
            $edu_details = (isset($data['edu_details'])) ? $data['edu_details'] : '';

            $req_language = (isset($data['req_language'])) ? $data['req_language'] : '';
            $req_language = implode(', ', $req_language);

            $preffered_lang = (isset($data['preffered_lang'])) ? $data['preffered_lang'] : '';
            $preffered_lang = (is_array($preffered_lang)) ? implode(', ', $preffered_lang) : '';
            $frequency = (isset($data['frequency'])) ? $data['frequency'] : '';
            $job_details = (isset($data['job_details'])) ? $data['job_details'] : '';
            $asap = $data['date'] == 'asap' ? 'asap' : '';
            $marketing = (isset($data['marketing'])) ? $data['marketing'] : 0;
            if ($asap != '') {
                $calendar1 = '';
            }

            $workschedule = (isset($data['workschedule'])) ? $data['workschedule'] : '';

            // $jobtype_opt = $exp_opt = $workwith = 0;
            $jobtype_opt = $exp_opt = $workwith = null;

            //Job type
            $options_jobtype = (isset($data['options_jobtype'])) ? $data['options_jobtype'] : '';
            if ($options_jobtype != '') {
                $jobtype_opt = implode(',', $options_jobtype);
            }

            //Experiece
            $options_exp = (isset($data['options_exp'])) ? $data['options_exp'] : '';
            if ($options_exp != '') {
                $exp_opt = implode(',', $options_exp);
            }

            //Work with
            $options_outlined = (isset($data['options_outlined'])) ? $data['options_outlined'] : '';
            if ($options_outlined != '') {
                $workwith = implode(',', $options_outlined);
            }

            if ($btnpressed == 'savebutton') {
                $setpublish = '0';
            } else {
                $setpublish = '1';
            }

            $usertype_val = User::select('id', 'client_type')->where('id', Auth::user()->id)->first();

            Job_Posts::where('id', $id)->update([
                'user_id' => Auth::user()->id,
                'usertype' => $usertype_val['client_type'],
                'profile_category_id' => $profilecat,
                'jobtypes' => $jobtype_opt,
                'jobtitle' => $jobtitle,
                'slug' => $this->slug->createSlug('job', $jobtitle),
                'job_position' => $job_position,
                'postalcode' => $postal_code,
                'country' => $country,
                'city' => $city,
                'landmark' => $landmark,
                'address' => $address,
                'jobduration' => $duration,
                'position' => $exp_opt,
                'workwith' => $workwith,
                'req_language' => $req_language,
                'pref_language' => $preffered_lang,
                'asap' => $asap,
                'start_date' => $calendar1,
                'paymentOption' => $paymentOption,
                'payamountcurrency' => $paycurrency,
                'payamount_from' => $payamountfrom,
                'payamount_to' => $payamountto,
                'payfrequency' => $frequency,
                'hoursperweek' => $hrsperweek,
                'workschedule' => $workschedule,
                'job_details' => $job_details,
                'publish' => $setpublish,
                'adstatus' => $setpublish,
                'marketing' => $marketing,
            ]);

            if ($setpublish == 0) {
                Session::flash('success', 'Job has been saved successfully');
                return Response::json(
                    [
                    'success' => '1',
                    'message' => 'Job has been saved successfully']
                );
            } else {
                Session::flash('success', 'Your job was posted successfully and will be live for the next 60 days.');
                return Response::json(['success' => '1', 'message' => 'Your job was posted successfully and will be live for the next 60 days.']);
            }
        }

        return view('user.client.post-vacancy', $this->basic_detail);
    }

    public function requestAccess(Request $request)
    {
        $id = $request->input('id');
        $referenceId = $request->input('referenceId');
    
        $documentUser = DocumentUser::find($id);
    
        if ($documentUser) {
            $documentUser->is_requested = true;
            $documentUser->save();

            $messageData = $this->renderDocumentRequestCard($documentUser,$referenceId);

            Chatify::push('private-chatify', 'messaging', [
                'from_id' => Auth::user()->id,
                'to_id' => $documentUser->provider_id,
                'reference_id' => $referenceId,
                'message' => Chatify::messageCard($messageData, 'request')
            ]);

            return response()->json(['message' => 'Access requested successfully']);
        } elseif ($documentUser) {
            return response()->json(['message' => 'Unauthorized access'], 403);
        } else {
            return response()->json(['message' => 'DocumentUser not found'], 404);
        }
    }

    protected function renderDocumentRequestCard($request,$referenceId)
    {
        $messageID = mt_rand(9, 999999999) + time();
        $clientName = $request->seeker->name;
        $documentName = $request->document->document_name;
        $documentId = $request->document_id;
        $seekerId = $request->seeker_id;
        $providerId = $request->provider_id;
    
        $phrase = $clientName . ' has requested access to <span>' . $documentName . '</span>';
        $rowHtml = '<div class="alignItems row">
                        <a href="#" class="btn-block-access btn-block-access-dropdown" data-id="' . $documentId . '" data-id-seeker="' . $seekerId . '" data-id-provider="' . $providerId . '" data-id-reference="' . $referenceId . '">Ignore</a>
                        <a href="#" class="btn-grant-access btn-grant-access-dropdown" data-id="' . $documentId . '" data-id-seeker="' . $seekerId . '" data-id-provider="' . $providerId . '" data-id-reference="' . $referenceId . '">Grant</a>
                    </div>';
    
        $htmlContent = '<div class="boxSentRequest">
                            <div class="textRequest">' . $phrase . '</div>
                            <div class="row">' . $rowHtml . '</div>
                        </div>';
    
        return [
            'id' => $messageID,
            'referenceId' => $referenceId,
            'from_id' => $seekerId,
            'to_id' => $providerId,
            'message' => $htmlContent,
            'attachment' => [null, null, null],
            'time' => now()->diffForHumans(),
            'fullTime' => now(),
            'viewType' => 'sender', 
            'seen' => 0, 
        ];
    }

}
