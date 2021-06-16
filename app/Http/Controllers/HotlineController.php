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


class HotlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($loc)
    {
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

    public function resources(){
        return ['actions' => ActionTaken::all(),
                'resource_types' => ResourceType::all(),
                'content_types' => ContentType::all(),
                'age_groups' => AgeGroup::all(),
                'genders' => Gender::all(),
                'report_roles' => ReportRole::all(),
                'submission_types' => SubmissionType::all(),
                'references_by' => ReferenceBy::all(),
                'references_to' => ReferenceTo::all(),
                'priorities' => Priority::all(),
                'users' => User::all(),
                'status' => Status::all(),
            ];
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
        return view('hotline.create')->with(self::resources());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Hotline $hotline
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $helpline = Helpline::findOrFail($id);

        // only serve hotline reports
        if ($helpline->is_it_hotline == 'false'){
            return redirect()->route('home');
        }
        

        // People that can view a report are: admins / first opened / assigned / new reports / not assigned reports
        if ( auth()->user()->hasRole("admin") || auth()->user()->hasRole('manager') || (($helpline->user_opened == Auth::id()) || (empty($helpline->user_opened))) || (($helpline->user_assigned == Auth::id() || (empty($helpline->user_assigned))))) {
            if ($helpline->status === 'Closed' &&  !auth()->user()->hasRole('manager') && !auth()->user()->hasRole("admin")){
                return redirect()->route('home');
            }

            // allow multiple actions 
            if (!is_null(json_decode($helpline->actions))){ // this is a json formatted action
                $array = json_decode($helpline['actions'], true);
    
                if(!isset($array[Auth::id()])){ // first time opening this request
                    $array[Auth::id()] = "Not provided";
                }
                
                $helpline['actions'] = json_encode($array);
            }
            
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
                $helpline->log .= "| Assigned to :" . Auth::User()->email;
                $helpline->status = "Opened";
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

            return view('hotline.edit')->with(array_merge(['helpline' => $helpline], self::resources()));
        }
        
        
        return redirect()->route('home');
         
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
        $helpline = Helpline::findOrFail($id);

        // first operator to open the report is stored
        if ($helpline->user_opened == NULL) $helpline->user_opened = Auth::id();

        if ($helpline->status != 'Closed') {
            $helpline->status = "Opened";
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

        return view('hotline.showmanager')->with(array_merge(['helpline' => $helpline], self::resources()));

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
        $helpline['is_it_hotline'] = "false";
        $helpline['forwarded'] = "true";
        $helpline->update();

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
        $UserId = Auth::user()->id;

        if (User::findOrFail($UserId)->hasRole("admin") && GroupPermission::canuser($UserId, 'delete', 'hotline')) {
            $helpline = Helpline::findOrFail($id);
            $helpline->forceDelete();
            return Response::json('Report has been deleted', 200);
        } else {
            if (GroupPermission::canuser($UserId, 'delete', 'hotline')) {
                $helpline = Helpline::find($id);
                if ($helpline->status == "Closed") {
                    $helpline->forceDelete();
                } else {
                    return Response::json('Report must be in Closed status', 409);
                }
            } else {
                return Response::json('Something went wrong, try again later', 500);
            }
        }
    }

}
