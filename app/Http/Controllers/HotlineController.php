<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App;
use Session;
use Response;
use Validator;
use Auth;
use Lang;
use App\User;
use App\GroupPermission;
use App\Helpline;
use App\ResourceType;
use App\ContentType;
use App\AgeGroup;
use App\Gender;
use App\ReportRole;
use App\SubmissionType;
use App\ReferenceBy;
use App\ReferenceTo;
use App\Priority;
use App\Status;
use App\ActionTaken;
use App\Statistics;


class HotlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($loc)
    {
        //
        //
        $resource_types = ResourceType::all();
        $content_types = ContentType::all();
        $age_groups = AgeGroup::all();
        $genders = Gender::all();
        $locale = $loc;
        Session::put('lang', $loc);

        App::setLocale($locale);
        if ($locale == 'gr') {
            return view('hotline.form-gr')->with([
                'resource_types' => $resource_types,
                'content_types' => $content_types,
                'age_groups' => $age_groups,
                'genders' => $genders,
            ]);
        } else {
            return view('hotline.form-en')->with([
                'resource_types' => $resource_types,
                'content_types' => $content_types,
                'age_groups' => $age_groups,
                'genders' => $genders,
            ]);
        }
    }

    /**
     * Display a message when form submitted succesfully
     */
    public function submitted()
    {
        $backtoform = Lang::get('success.backtoform', array(), Session::get('lang'));
        return view('helpline.submitted', compact('backtoform', 'language'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actions = ActionTaken::all();

        $resource_types = ResourceType::all();
        $content_types = ContentType::all();
        $age_groups = AgeGroup::all();
        $genders = Gender::all();
        $report_roles = ReportRole::all();
        $submission_types = SubmissionType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();
        $priorities = Priority::all();
        $users = User::all();
        $status = Status::all();

        $userThathaveAccessonHotline = Array();
        foreach ($users as $user) {
            if (GroupPermission::canuser($user->id, 'edit', 'hotline')) {
                $userThathaveAccessonHotline[] = $user;
            }

        }

        return view('hotline.create')->with([
            'resource_types' => $resource_types,
            'content_types' => $content_types,
            'age_groups' => $age_groups,
            'genders' => $genders,
            'report_roles' => $report_roles,
            'submission_types' => $submission_types,
            'references_by' => $references_by,
            'references_to' => $references_to,
            'priorities' => $priorities,
            'users' => $userThathaveAccessonHotline, //it was $users
            'status' => $status,
            'actionstaken' => $actions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Hotline $hotline
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actions = ActionTaken::all();
        $helpline = Helpline::findOrFail($id);
        //$helpline = Helpline::where('id', '=', $id)->first();
        $age_groups = AgeGroup::all();
        $genders = Gender::all();
        $resource_types = ResourceType::all();
        $content_types = ContentType::all();
        $report_roles = ReportRole::all();
        $submission_types = SubmissionType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();
        $priorities = Priority::all();
        $users = User::all();
        $status = Status::all();

        if (auth()->user()->hasRole('Operator') && (($helpline->status == 'Closed') )) {
            return redirect()->route('home');
        } else {

            if ( ($helpline->forwarded == "true")   ||  (($helpline->user_opened == Auth::id()) || (empty($helpline->user_opened))) || (($helpline->user_assigned == Auth::id() || (empty($helpline->user_assigned))))) {
                $helpline->log="";
                $first=!empty($helpline->firstResponder)?$helpline->firstResponder->name:"";
                $last=!empty($helpline->lastResponder)?$helpline->lastResponder->name:"";
                $frwd=($helpline->is_it_hotline == 'true')?"Helpline":"Hotline";
                // first operator to open the report is stored
                if ((empty($helpline->user_opened) || $helpline->user_opened == NULL) || ($helpline->forwarded == "true") )  {
                    $helpline->log .= "Before Forwarded  (From ".$frwd."):" . $first."->".$last ;
                    $helpline->user_opened = Auth::id();
                    $helpline->user_assigned =null;

                }
                if ($helpline->status != 'Closed') {
                    // $helpline->user_assigned = Auth::id();
                    $helpline->log .= "| Assigned to :" . Auth::User()->email;
                    $helpline->status = "Opened";

                    $statistics = Statistics::where('tracking_id', '=', $helpline->id)->first();

                    // first operator to open the report is stored
                    if (empty($helpline->user_opened) || $helpline->user_opened == NULL || ($helpline->forwarded == "true") )  {
                        $statistics->user_opened = Auth::id();
                        $statistics->user_assigned =null;
                    }


                    $statistics->status = "Opened";
                    $statistics->forwarded="false";
                    $statistics->save();
                }
                $helpline->forwarded="false";
                $helpline->save();

                $new_date = date('d/m/Y h:i', strtotime($helpline->call_time));
                $helpline->call_time = $new_date;

                $referenceidInfo = null;
                if (!empty($helpline->insident_reference_id)) {
                    $referenceidInfo = Array();
                    $refData = Helpline::find($helpline->insident_reference_id);
                    if (isset($refData) && !empty($refData)) {
                        $referenceidInfo['is_it_hotline'] = $refData->is_it_hotline;
                    } else {
                        $helpline->insident_reference_id = null;
                    }
                }

                $userThathaveAccessonHotline = Array();
                foreach ($users as $user) {
                    if ( (Auth::id() != $user->id) &&  GroupPermission::canuser($user->id, 'edit', 'hotline')) {
                        $userThathaveAccessonHotline[] = $user;
                    }

                }

                return view('hotline.edit')->with([
                    'helpline' => $helpline,
                    'resource_types' => $resource_types,
                    'content_types' => $content_types,
                    'age_groups' => $age_groups,
                    'genders' => $genders,
                    'report_roles' => $report_roles,
                    'submission_types' => $submission_types,
                    'references_by' => $references_by,
                    'references_to' => $references_to,
                    'priorities' => $priorities,
                    'status' => $status,
                    'users' => $userThathaveAccessonHotline,//$users,
                    'actionstaken' => $actions,
                    'referenceidInfo' => $referenceidInfo
                ]);
            } else {
                return redirect()->route('home');
            }
        }
    }


    /*
    Show read only view for manager
    */
    /**
     * Display the specified resource.
     *
     * @param \App\Hotline $hotline
     * @return \Illuminate\Http\Response
     */
    public function showManager()
    {
        $id = Input::get('id', false);
        $actions = ActionTaken::all();
        $helpline = Helpline::findOrFail($id);
        $age_groups = AgeGroup::all();
        $genders = Gender::all();
        $resource_types = ResourceType::all();
        $content_types = ContentType::all();
        $report_roles = ReportRole::all();
        $submission_types = SubmissionType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();
        $priorities = Priority::all();
        $users = User::all();
        $status = Status::all();

        // first operator to open the report is stored
        if ($helpline->user_opened == NULL) $helpline->user_opened = Auth::id();

        if ($helpline->status != 'Closed') {
            $helpline->status = "Opened";
            $statistics = Statistics::where('tracking_id', '=', $helpline->id)->first();
        }

        $new_date = date('d/m/Y h:i', strtotime($helpline->call_time));
        $helpline->call_time = $new_date;

        $referenceidInfo = null;
        if (!empty($helpline->insident_reference_id)) {
            $referenceidInfo = Array();
            $refData = Helpline::find($helpline->insident_reference_id);
            if (isset($refData) && !empty($refData)) {
                $referenceidInfo['is_it_hotline'] = $refData->is_it_hotline;
            } else {
                $helpline->insident_reference_id = null;
            }
        }

        return view('hotline.showmanager')->with([
            'helpline' => $helpline,
            'resource_types' => $resource_types,
            'content_types' => $content_types,
            'age_groups' => $age_groups,
            'genders' => $genders,
            'report_roles' => $report_roles,
            'submission_types' => $submission_types,
            'references_by' => $references_by,
            'references_to' => $references_to,
            'priorities' => $priorities,
            'status' => $status,
            'users' => $users,
            'actionstaken' => $actions,
            'referenceidInfo' => $referenceidInfo
        ]);

    }


    /**
     * Save the data after editing the specified resource.
     *
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function editManager(Request $request, Helpline $helpline)
    {


        $data = $request->all();

        $data['manager_comments'] = Crypt::encrypt(trim($data['manager_comments']));

        $helpline = Helpline::find($id);
        $helpline->manager_comments = (isset($data['manager_comments'])) ? $data['manager_comments'] : null;
        $helpline->insident_reference_id = (isset($data['insident_reference_id'])) ? $data['insident_reference_id'] : null;
        $helpline->save();

        //$data['manager_comments'] = Crypt::encrypt(($data['manager_comments']);
        //dd($data);
        //Helpline::find($helpline->id)->update($data);

        $statistics = Statistics::where('tracking_id', '=', $helpline->id)->first();


        $statistics->manager_comments = (isset($data['manager_comments'])) ? $data['manager_comments'] : null;
        $statistics->insident_reference_id = (isset($data['insident_reference_id'])) ? $data['insident_reference_id'] : null;
        //
        $statistics->save();

        return redirect()->route('home');
    }


    /**
     * Save the data after editing the specified resource.
     * change from helpline to hotline
     * @param \App\Hotline $hotline
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Helpline $hotline)
    {
        //
        $change = $request->all();
        $id =$hotline->id;
        $helpline = Helpline::where('id', '=', $id)->first();
        $helpline['content_type'] = "Other";
        $helpline['resource_type'] = "Other";
        // $change['user_opened'] = $hotline->user_assigned;
        // $change['user_assigned'] = null;
        $helpline['is_it_hotline'] = "true";
        $helpline['forwarded'] = "true";
        $helpline->update();


        $statistics = Statistics::where('tracking_id', '=', $id)->first();
        $statistics['content_type'] = "Other";
        $statistics['resource_type'] = "Other";
        // $statistics['user_opened'] = $hotline->user_assigned;
        // $statistics['user_assigned'] = null;
        $statistics['is_it_hotline'] = "true";
        $statistics['forwarded'] = "true";
        $statistics->update();




        return redirect('home');
    }


    /*
    change from hotline to helpline
    */
    public function changeFromHotline(Request $request)
    {
        $id = Input::get('id', false);
        $helpline = Helpline::where('id', '=', $id)->first();
        $helpline['content_type'] = "Other";
        $helpline['resource_type'] = "Other";
        // $change['user_opened'] = $hotline->user_assigned;
        // $change['user_assigned'] = null;
        $helpline['is_it_hotline'] = "false";
        $helpline['forwarded'] = "true";
        $helpline->update();

        $statistics = Statistics::where('tracking_id', '=', $id)->first();
        $statistics['content_type'] = "Other";
        $statistics['resource_type'] = "Other";
        $statistics['forwarded'] = "true";
        // $statistics['user_opened'] = $hotline->user_assigned;
        // $statistics['user_assigned'] = null;
        $statistics['is_it_hotline'] = "false";
        $statistics->update();
        return redirect('home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Hotline $hotline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Helpline $hotline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Hotline $hotline
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $UserId = Input::get('UserId');
        $User = User::find($UserId);
        if (User::find($UserId)->hasRole("Admin") && GroupPermission::canuser($UserId, 'delete', 'hotline')) {
            $helpline = Helpline::find($id);
            $helpline->delete();
        } else {
            if (GroupPermission::canuser($UserId, 'delete', 'hotline')) {
                $helpline = Helpline::find($id);
                if ($helpline->status == "Closed") {
                    $helpline->delete();
                } else {
                    return Response::json(
                        'Report must be in Closed status', 500);
                }
            } else {
                return Response::json('error');
            }
        }
    }

}
