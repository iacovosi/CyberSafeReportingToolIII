<?php

namespace App\Http\Controllers;

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
use Carbon\Carbon;
use Mail;

class HelplineController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkdelete');
    }

    public function validator(Request $request){

        // Set validation rules for fields
        $data = $request->all();

        // validation rules for all.
        $rules = [
            'resource_type' => 'required',
            'content_type' => 'required',
            'name' => 'required_if:personal_data,true',
        ];
        // validation rule if you want to provide personal
        if ($request->personal_data === 'true') {
            $rules['email'] = 'required_without:phone';
            $rules['phone'] = 'required_without:email';
        }
        
        // not submited by an operator
        if (!$request->submitted_by_operator === 'true') {
            $rules['personal_data'] = 'required';
            $rules['resource_url'] = 'required_if:resource_type,website,chatroom,social-media';
            // $rules['g-recaptcha-response'] = 'required | recaptcha';
        
        // submited by operator
        }else{
            if (isset($data['insident_reference_id'])){
                $rules['insident_reference_id'] = 'exists:helplines,id';
            }
        }

        // Generate a new validator instance
        $validator = Validator::make($request->all(), $rules, Lang::get('validation.custom.entry', array(), Session::get('lang')));
        
        // Add any conditional validation rules
        $validator->sometimes('phone', 'numerdateformatic', function ($input) {
            return $input->personal_data == "true" && $input->email == "";
        });

        if ($validator->fails()) {
            return redirect()->back()->with(['errors' => $validator->messages()])->withInput();
        }
        
        return null;
    }

    /**
     * Return all resources needed
     */
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
     * Display a listing of the resource.
     * 
     * In this case we display the form /helpline/{lang}/form
     * the use can submit a report.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($loc = null)
    {
        $resource_types = ResourceType::all();
        $content_types = ContentType::all();
        $age_groups = AgeGroup::all();
        $genders = Gender::all();
        $locale = Session::get('lang');

        // for some reason the first time it loads the page Session get lang return null, so line below sets gr to default
        if (!isset($locale)) {
            $web = explode('/', url()->current());
            $locale = $web[4];
        }

        App::setLocale($locale);
        Session::put('lang', $loc);
        if ($locale == 'gr') {
            return view('helpline.form-gr')->with([
                'resource_types' => $resource_types,
                'content_types' => $content_types,
                'age_groups' => $age_groups,
                'genders' => $genders,
            ]);
        } else {
            return view('helpline.form-en')->with([
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
        $language = Session::get('lang');
        return view('helpline.submitted', compact('backtoform', 'language'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Create a report as an operator/loggedin user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('helpline.create')->with(self::resources());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = self::validator($request);

        if($validation){ // found an error while validating form
            return $validation;
        }

        $data = $request->except('submitted_by_operator');
        $data['comments'] = Crypt::encrypt($request->comments); // encrypt comments

        // allow multiple actions
        if (isset($data['actions']) && $request->submitted_by_operator){
            $json = [Auth::id() => $data['actions']];
            $data['actions'] = json_encode($json);
        }else{
            $data['actions'] = json_encode([]);
        }
        
        if (!empty($data['call_time'])) {
            $dateformat = Carbon::createFromFormat('d/m/Y H:i:s', $data['call_time'] . ":00");
            $data['call_time'] = $dateformat;
        }

        Helpline::create($data);

        if ($request->submitted_by_operator) {
            return redirect('home');
        }

        return redirect('helpline/submitted')->with('success-info', Lang::get('success.submited', array(), Session::get('lang')));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function show(Helpline $helpline)
    {

        $users = User::all();
        
        // only serve helpline reports
        if ($helpline->is_it_hotline == 'true'){
            return redirect()->route('home');
        }

        // People that can view a report are: admins / first opened / assigned
        
        if ( auth()->user()->hasRole("admin") || auth()->user()->hasRole("manager") || ($helpline->user_assigned == Auth::id() || $helpline->forwarded == 'true' || empty($helpline->user_opened)) || (($helpline->user_opened == Auth::id()) &&  (empty($helpline->user_assigned)))) {
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

            // store the id of the first operator that opens the report
            if ((empty($helpline->user_opened) || $helpline->user_opened == NULL) || ($helpline->forwarded == "true") ){
                $helpline->log .= "Before Forwarded  (From ".$frwd."):" . $first."->".$last ;
                $helpline->user_opened = Auth::id();
                $helpline->user_assigned = null;
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

            return view('helpline.edit')->with(array_merge(['helpline' => $helpline], self::resources()));
        }
        
        
        return redirect()->route('home');
    }

    /*
    * Show read only view for manager
    */
    /**
     * Display the specified resource.
     *
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function showManager()
    {
        $id = Input::get('id', false);
        $helpline = Helpline::findOrFail($id);


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

        return view('helpline.showmanager')->with(array_merge(['helpline' => $helpline ], self::resources()));
    }


    /**
     * Save the data after editing the specified resource.
     *
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function editManager(Request $request)
    {
        $data = $request->except(['id']);

        $id = $request->id;
        
        $helpline = Helpline::find($id);
        $rules = [];

        if (isset($data['insident_reference_id'])){
            $rules['insident_reference_id'] = 'exists:helplines,id';
        }

        $validator = Validator::make($request->all(), $rules, Lang::get('validation.custom.entry', array(), Session::get('lang')));

        if ($validator->fails()) {
            return redirect()->back()->with(['errors' => $validator->messages()])->withInput();
        }

        $helpline->manager_comments = Crypt::encrypt(trim($data['manager_comments']));
        $helpline->insident_reference_id = $data['insident_reference_id'];
        $helpline->save();

        return redirect()->route('home');
    }


    /**
     * Save the data after editing the specified resource.
     *
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Helpline $helpline)
    {

        $validation = self::validator($request);

        if($validation){
            return $validation;
        }


        $data = $request->all();
        $data['comments'] = Crypt::encrypt($request->comments);

        // create the mysql date format
        if (!empty($data['call_time'])) {
            $dateformat = Carbon::createFromFormat('d/m/Y H:i:s', $data['call_time'] . ":00");
            $data['call_time'] = $dateformat;
        }

        $helpline = Helpline::find($helpline->id);

        // allow multiple actions 
        if (!is_null(json_decode($helpline->actions))){ // this is a json formatted action
            $array = json_decode($helpline['actions'], true);
            $array[Auth::id()] = $data['actions'];
            $data['actions'] = json_encode($array);
        }

        $helpline->update($data);

        return redirect()->route('home');
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Helpline $helpline)
    {

        if ($request->ajax()) {

            $data = $request->all();

            //Actions
            $actions = $request->actions;
            $data['actions'] = $actions;

            // create the mysql date format
            if (!empty($data['call_time'])) {
                $dateformat = Carbon::createFromFormat('d/m/Y H:i:s', $data['call_time'] . ":00");
                $data['call_time'] = $dateformat;
            }

            $helpline = Helpline::find($helpline->id);
            $helpline->insident_reference_id = (isset($data['insident_reference_id'])) ? $data['insident_reference_id'] : null;
            $helpline->call_time = (isset($data['call_time'])) ? $data['call_time'] : null;
            $helpline->update($data);

            return Response::json($helpline);
        }
    }

    /**
     * Save the data after editing the specified resource.
     * change from helpline to hotline
     * @param \App\Hotline $hotline
     * @return \Illuminate\Http\Response
     */
    public function changeFromHelpLine(Request $request)
    {

        $id = Input::get('id', false);
        $helpline = Helpline::where('id', '=', $id)->first();
        $helpline['content_type'] = "Other";
        $helpline['resource_type'] = "Other";
        $helpline['is_it_hotline'] = "true";
        $helpline['forwarded'] = "true";
        $helpline->update();

        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Helpline $helpline)
    {
        $UserId = Auth::user()->id;
        
        if (User::findOrFail($UserId)->hasRole("admin") && GroupPermission::canuser($UserId, 'delete', 'helpline')) {
            $helpline->forceDelete();
            return Response::json('Report has been deleted', 200);
        } else {
            if (GroupPermission::canuser($UserId, 'delete', 'helpline')) {
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

    public function test(Request $request, $id)
    {
        return $request->all();
    }

    public static function emailInformOperators($type)
    {
        $users = User::all();
        $operators = Array();
        foreach ($users as $user) {
            if ($user->hasRole('operator')) {
                $operator = Array();
                $operator['email'] = $user->email;
                $operator['name'] = $user->name;
                $operators[] = $operator;
            }
        }
        foreach ($operators as $operator) {
            $name = $operator['name'];
            $email = $operator['email'];
            $data = ['name' => $name, 'type' => $type];
            Mail::send('mail', $data, function ($message) use ($type, $email) {
                $message->to($email, 'Operators of Cyber Security Web Application')->subject
                ('Cyber Security Application Info:New Report Created - ' . $type);
                $message->from('cybersecurity@cyearn.pi.ac.cy', 'Cyber Security Application');
            });
        }
    }

}
