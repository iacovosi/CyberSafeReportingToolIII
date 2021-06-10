<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App;
use Storage;
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
use App\Fakenews;
use App\FakenewsType;
use App\FakenewsPictures;
use App\FakenewsPictureReff;
use App\FakenewsSourceType;
use App\FakenewsStatistics;
use Carbon\Carbon;
use Mail;  // <<<<

class FakenewsController extends Controller
{
    public function __construct()
    {
        //doesnt do anything i guess???
        $this->middleware('checkdelete');
    }

    /**
     * Display a listing of the resource.
     * 
     * In this case we display the form /fakenews/{lang}/form
     * the use can submit a report.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($loc = null)
    {
        $fakenewstype = FakenewsType::all();
        $age_groups = AgeGroup::all();
        $genders = Gender::all();
        $locale = Session::get('lang');
        $fakenewssourcetype = FakenewsSourceType::all();

        // for some reason the first time it loads the page Session get lang return null, so line below sets gr to default
        if (!isset($locale)) {
            $web = explode('/', url()->current());
            $locale = $web[4];
        }

        App::setLocale($locale);
        Session::put('lang', $loc);
        if ($locale == 'gr') {
            return view('fakenews.form-gr')->with([
                'fakenews_type'=>$fakenewstype,
                'age_groups' => $age_groups,
                'genders' => $genders,
                'fakenews_source_type'=> $fakenewssourcetype
            ]);
        } else {
            return view('fakenews.form-en')->with([
                'fakenews_type'=>$fakenewstype,
                'age_groups' => $age_groups,
                'genders' => $genders,
                'fakenews_source_type'=> $fakenewssourcetype
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
        return view('fakenews.submitted', compact('backtoform', 'language'));
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
        $actions = ActionTaken::all();
        $fakenews = Fakenews::all();
        $fakenewstype = FakenewsType::all();
        $fakenewssourcetype = FakenewsSourceType::all();
        $age_groups = AgeGroup::all();
        $genders = Gender::all();
        $report_roles = ReportRole::all();
        $submission_types = SubmissionType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();
        $priorities = Priority::all();
        $users = User::all();
        $status = Status::all();

        $userThathaveAccessonFakenews = Array();
        foreach ($users as $user) {
            if (GroupPermission::canuser($user->id, 'edit', 'fakenews')) {
                $userThathaveAccessonFakenews[] = $user;
            }
        }

        return view('fakenews.create')->with([
            'fakenews_type' => $fakenewstype,
            'fakenews_source_type' => $fakenewssourcetype,
            'age_groups' => $age_groups,
            'genders' => $genders,
            'report_roles' => $report_roles,
            'submission_types' => $submission_types,
            'references_by' => $references_by,
            'references_to' => $references_to,
            'priorities' => $priorities,
            'users' => $userThathaveAccessonFakenews, //$users,
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
        // Validate the post...
        //dd(!$request->submitted_by_operator);
        if (!$request->submitted_by_operator) 
        {
            // Set validation rules for fields
            $rules = [
                'fakenews_source_type'=>'required',
                'publication_date'=> 'required|date',
                'img_upload'=>"required",
                'personal_data' => 'required',
                //internet rules
                'source_url' => 'required_if:fakenews_source_type,Internet & url',
                'title'=> 'required_if:fakenews_source_type,Internet',
                //TV rules
                'tv_channel'=>'required_if:fakenews_source_type,TV',
                'tv_prog_title'=>'required_if:fakenews_source_type,TV',
                'tv_publication_time'=>'required_if:fakenews_source_type,TV',
                //Radio rules
                'town'=>'required_if:fakenews_source_type,Radio',
                'radio_publication_time'=>'required_if:fakenews_source_type,Radio',
                //Newspaper rules
                'newspaper_name'=>'required_if:fakenews_source_type,Newspaper',
                //adv/pam rules
                'adv_country'=>'required_if:fakenews_source_type,Advertising/Pamphlets',
                'adv_town'=>'required_if:fakenews_source_type,Advertising/Pamphlets',
                //Other
                'specific_type'=>'required_if:fakenews_source_type,Other',
                'other_country'=>'required_if:fakenews_source_type,Other',
                'other_town'=>'required_if:fakenews_source_type,Other',
                //Personal details
                'name' => 'required_if:personal_data,true',
                'images*' => 'required_if:img_upload:yes',
                'images.*' => 'mimes:jpeg,png,jpg,gif,svg|max:10120',
            ];
            if ($request->personal_data == 'true') {
                $rules['email'] = 'required_without:phone';
                $rules['phone'] = 'required_without:email';
            }
            if ($request->fakenews_source_type == 'Radio') {
                $rules['radio_station'] = 'required_without:radio_freq';
                $rules['radio_freq'] = 'required_without:radio_station';
            }
            // $rules['g-recaptcha-response'] = 'required | recaptcha';

            // Generate a new validator instance
            $validator = Validator::make($request->all(), $rules, Lang::get('validation.custom.entry', array(), Session::get('lang')));

            // Add any conditional validation rules
            $validator->sometimes('phone', 'numeric', function ($input) {
                return $input->personal_data == "true" && $input->email == "";
            });

            if ($validator->fails()) {
                return redirect()->back()->with(['errors' => $validator->messages()])->withInput();
            }
        }

        $data = $request->all();
        // Defaults
        $data['submission_type'] = (!empty($request->submission_type)) ? $request->submission_type : 'electronic-form';
        $data['evaluation'] = (!empty($request->evaluation)) ? $request->evaluation : '50';
        $data['img_upload'] = (!empty($request->img_upload)) ? $request->img_upload : 0;
        
        //unset($data['submitted_by_operator']);

        if (!empty($data['call_time'])) {
            $dateformat = Carbon::createFromFormat('d/m/Y H:i:s', $data['call_time'] . ":00");
            $data['call_time'] = $dateformat;
        }

       
        unset($data['images']);
        unset($data["g-recaptcha-response"]);
        
        $data['comments'] = Crypt::encrypt($request->comments);
        if ($data['fakenews_source_type']=='Internet' & (!empty($data['source_document']))){
            $data['source_document'] = Crypt::encrypt($request->source_document);
        } 
        if (!$request->submitted_by_operator){
            if ($data['fakenews_source_type']=='Internet'){
                unset($data['tv_channel']);
                unset($data['tv_prog_title']);
                unset($data['radio_station']);
                unset($data['radio_freq']);
                unset($data['newspaper_name']);
                unset($data['page']);
                unset($data['specific_type']);
                unset($data['country']);
                unset($data['town']);
                unset($data['area_district']);
                unset($data['specific_address']);   
            }elseif($data['fakenews_source_type']=='TV'){
                $data['publication_time']=$data['tv_publication_time'];
                unset($data['tv_publication_time']);
                unset($data['source_url']);
                unset($data['title']);
                unset($data['source_document']);
                unset($data['radio_station']);
                unset($data['radio_freq']);
                unset($data['newspaper_name']);
                unset($data['page']);
                unset($data['specific_type']); 
                unset($data['country']);
                unset($data['town']);
                unset($data['area_district']);
                unset($data['specific_address']);   
            }elseif($data['fakenews_source_type']=='Radio'){
                $data['publication_time']=$data['radio_publication_time'];
                unset($data['radio_publication_time']);
                unset($data['tv_channel']);
                unset($data['tv_prog_title']);
                unset($data['source_url']);
                unset($data['title']);
                unset($data['source_document']);
                unset($data['newspaper_name']);
                unset($data['page']);
                unset($data['specific_type']); 
                unset($data['area_district']);
                unset($data['specific_address']); 
            }elseif($data['fakenews_source_type']=='Newspaper'){
                unset($data['tv_channel']);
                unset($data['tv_prog_title']);
                unset($data['source_url']);
                unset($data['radio_station']);
                unset($data['radio_freq']);
                unset($data['title']);
                unset($data['source_document']);
                unset($data['specific_type']);
                unset($data['country']);
                unset($data['town']);
                unset($data['area_district']);
                unset($data['specific_address']);    
            }elseif($data['fakenews_source_type']=='Advertising/Pamphlets'){
                $data['country'] = $data['adv_country'];
                unset($data['adv_country']);
                $data['town'] = $data['adv_town'];
                unset($data['adv_town']);
                $data['area_district'] = $data['adv_area_district'];
                unset($data['adv_area_district']);
                $data['specific_address'] = $data['adv_specific_address'];
                unset($data['adv_specific_address']);
                unset($data['tv_channel']);
                unset($data['tv_prog_title']);
                unset($data['source_url']);
                unset($data['radio_station']);
                unset($data['radio_freq']);
                unset($data['title']);
                unset($data['source_document']);
                unset($data['specific_type']);
                unset($data['newspaper_name']);
                unset($data['page']);
            }elseif($data['fakenews_source_type']=='Other'){
                $data['country'] = $data['other_country'];
                unset($data['other_country']);
                $data['town'] = $data['other_town'];
                unset($data['other_town']);
                $data['area_district'] = $data['other_area_district'];
                unset($data['other_area_district']);
                $data['specific_address'] = $data['other_specific_address'];
                unset($data['other_specific_address']);
                unset($data['tv_channel']);
                unset($data['tv_prog_title']);
                unset($data['source_url']);
                unset($data['radio_station']);
                unset($data['radio_freq']);
                unset($data['title']);
                unset($data['source_document']);
                unset($data['newspaper_name']);
                unset($data['page']);
            };
        };
        
        //dd($data);
        $id = Fakenews::create($data)->id;

        if (($files = $request->images) & (!empty($request->images))){
            foreach($files as $file){
                $imageName = time() .'_' . $file -> getClientOriginalName();
                $file->move(public_path("storage\\uploaded_images"),$imageName);
                $picdata = array(
                    'picture_path' =>  $imageName
                );
                $pic = FakenewsPictures::create($picdata);
                //$pic->update($picdata);
                $picreffdata = array(
                    'fakenews_reference_id' => $id,
                    'picture_reference_id'=>$pic -> id
                );
                $picreff = FakenewsPictureReff::create($picreffdata);
                //$picreff->update($picreffdata);
            };
        };

        $statistics = new FakenewsStatistics();

        // Get the created incident so we add its id to the Statistics so we can track it!!!
        // $returnLatest = Helpline::latest()->first();
        $statistics->tracking_id = $id;// $returnLatest->id;
        //
        $statistics->submission_type = $data['submission_type'];
        // user profile
        $statistics->age = (isset($data['age'])) ? $data['age'] : 'Not Set';
        $statistics->gender = (isset($data['gender'])) ? $data['gender'] : 'Not set';
        $statistics->report_role = (isset($data['report_role'])) ? $data['report_role'] : 'Not set';
        // report description
        $statistics->fakenews_source_type = $data['fakenews_source_type'];
        $statistics->fakenews_type = (isset($data['fakenews_type'])) ? $data['fakenews_type'] : 'Undefined';
        $statistics->evaluation = $data['evaluation'];
        $statistics->img_upload = $data['img_upload'];

        $statistics->loc_available = (  isset($data['country']) | 
                                        isset($data['town']) | 
                                        isset($data['area_district']) |
                                        isset($data['specific_address'])  ) 
                                        ? 1: 0;
        // operator actions
        $statistics->user_opened = (isset($data['user_opened'])) ? $data['user_opened'] : null;
        // $statistics->user_assigned = (isset($data['user_assigned'])) ? $data['user_assigned'] : '';
        if (isset($data['user_assigned'])) $statistics->user_assigned = $data['user_assigned'];
        $statistics->priority = (isset($data['priority'])) ? $data['priority'] : 'Not set';
        $statistics->reference_by = (isset($data['reference_by'])) ? $data['reference_by'] : 'Not set';
        $statistics->reference_to = (isset($data['reference_to'])) ? $data['reference_to'] : 'Not set';
        $statistics->actions = (isset($data['actions'])) ? $data['actions'] : 'Not set';
        $statistics->status = (isset($data['status'])) ? $data['status'] : 'New';
        $statistics->call_time = (isset($data['call_time'])) ? $data['call_time'] : null;
        $statistics->manager_comments = (isset($data['manager_comments'])) ? $data['manager_comments'] : null;
        $statistics->insident_reference_id = (isset($data['insident_reference_id'])) ? $data['insident_reference_id'] : null;
        //
        $statistics->save();

        //HelplineController::emailInformOperators($is_it_hotline);  //if email server enabled.. then you can send email!

        if ($request->submitted_by_operator) {
            return redirect('home');
        }
       
        return redirect('fakenews/submitted')->with('success-info', Lang::get('success.submited', array(), Session::get('lang')));
    }
      /**
     * Display the specified resource.
     *
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $actions = ActionTaken::all();
        $fakenews = Fakenews::find($id);
        $fakenewstype = FakenewsType::all();
        $fakenewssourcetype = FakenewsSourceType::all();
        $age_groups = AgeGroup::all();
        $genders = Gender::all();
        $report_roles = ReportRole::all();
        $submission_types = SubmissionType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();
        $priorities = Priority::all();
        $users = User::all();
        $status = Status::all();

        if (auth()->user()->hasRole("operator") && (($fakenews->status == 'Closed') )) {
            return redirect()->route('home');
        } else {

            if (  (($fakenews->user_opened == Auth::id()) || (empty($fakenews->user_opened))) || (($fakenews->user_assigned == Auth::id() || (empty($fakenews->user_assigned))))) {
                $fakenews->log="";
                $first=!empty($fakenews->firstResponder)?$fakenews->firstResponder->name:"";
                $last=!empty($fakenews->lastResponder)?$fakenews->lastResponder->name:"";
                // store the id of the first operator that opens the report
                if ($fakenews->user_opened == NULL){
                    $fakenews->user_opened = Auth::id();
                    $fakenews->user_assigned =null;
                }

                if ($fakenews->status != 'Closed') {
                    //$fakenews->user_assigned = Auth::id();
                    // $fakenews->user_opened = Auth::id();  // ??????????
                    $fakenews->log .= "| Assigned to :" . Auth::User()->email;
                    $fakenews->status = "Opened";
                    //requires stats data to be introduced when making an incident
                    $statistics = Statistics::where('tracking_id', '=', $fakenews->id)->first();
                    
                    if  (empty($fakenews->user_opened) || $fakenews->user_opened == NULL) {
                        $statistics->user_opened = Auth::id();
                        $statistics->user_assigned =null;
                    }

                    // 8/6/2018
                    // THERE WAS A CASE WHERE A REPORT WAS CREATED WITHOUT CREATING A STATISTICS ENTRY
                    // NEED TO CHECK WHY THIS HAPPENED - THE REPORT CREATED FROM HELPLINE ONLINE FORM
                    // FOR THIS REASON THE CODE BELOW, CHEKCS IF AN ENTRY IN THE STATISTICS TABLE EXISTS
                    // IF THERE IS THEN IT CAN CHANGE THE STATUS
                    if (!empty($statistics)) {
                        $statistics->status = "Opened";
                        $statistics->forwarded ="false";
                        $statistics->save();
                    }
                }
                $new_date = date('d/m/Y h:i', strtotime($fakenews->call_time));
                $fakenews->call_time = $new_date;
                ##
                $referenceidInfo = null;
                if (!empty($fakenews->insident_reference_id)) {
                    $referenceidInfo = Array();
                    $refData = Fakenews::find($fakenews->insident_reference_id);
                    if (isset($refData) && !empty($refData)) {
                        $referenceidInfo['status'] = $refData->status;
                    } else {
                        $fakenews->insident_reference_id = null;
                    }
                }

                $userThathaveAccessonFakenews = Array();
                foreach ($users as $user) {
                    if ((Auth::id() != $user->id) &&  GroupPermission::canuser($user->id, 'edit', 'fakenews')) {
                        $userThathaveAccessonFakenews[] = $user;
                    }
                }
                $image_array = Array();
                //$image_id_array = Array();
                if ($fakenews->img_upload==1){
                    $image_array_ids = FakenewsPictureReff::where('fakenews_reference_id','=',$fakenews->id)->pluck('picture_reference_id');
                    //dd($image_array_ids);
                    foreach($image_array_ids as $image_id){
                        $img_path = FakenewsPictures::where('id','=',$image_id)->pluck('picture_path');
                        $image_array[$image_id]=$img_path[0];
                    }
                    //dd($image_array);
                }
                
                return view('fakenews.edit')->with([
                    'pictures'=>$image_array,
                    'fakenews' => $fakenews,
                    'fakenews_type' => $fakenewstype,
                    'fakenews_source_type' => $fakenewssourcetype,
                    'age_groups' => $age_groups,
                    'genders' => $genders,
                    'report_roles' => $report_roles,
                    'submission_types' => $submission_types,
                    'references_by' => $references_by,
                    'references_to' => $references_to,
                    'priorities' => $priorities,
                    'status' => $status,
                    'users' => $userThathaveAccessonFakenews,//$users,
                    'actionstaken' => $actions,
                    'referenceidInfo' => $referenceidInfo
                ]);
            } else {
                return redirect()->route('home');
            }
        }
    }



    /**
     * Save the data after editing the specified resource.
     *
     * @param \App\Helpline $helpline
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Fakenews $fakenews)
    {

        $data = $request->all();
        
        //In case the user selects to transfer the incident to another user.
        // if ($request->user_assigned != $request->user_opened) {
        //     if ( isset($request->user_opened) ){
        //         $user= User::where('id', $request->user_opened)->first();
        //     } else {
        //         $user= User::where('id', $request->user_assigned)->first();
        //     }
        //     $data['user_assigned'] = $user->id;
        //     $transferuser = User::where('id', $request->user_assigned)->first();
        //     $data['user_opened'] = $transferuser->id;
        // }

        $data['comments'] = Crypt::encrypt($request->comments);

        if (!empty($data['source_document'])){
            $data['source_document'] = Crypt::encrypt($request->source_document);
        }

        // create the mysql date format
        if (!empty($data['call_time'])) {
            $dateformat = Carbon::createFromFormat('d/m/Y H:i:s', $data['call_time'] . ":00");
            $data['call_time'] = $dateformat;
        }

        $fakenews = Fakenews::find($fakenews->id);
        $fakenews->insident_reference_id = (isset($data['insident_reference_id'])) ? $data['insident_reference_id'] : null;
        $fakenews->call_time = (isset($data['call_time'])) ? $data['call_time'] : null;
        $fakenews->update($data);

        $statistics = FakenewsStatistics::where('tracking_id', '=', $fakenews->id)->first();

        // 8/6/2018
        // THERE WAS A CASE WHERE A REPORT WAS CREATED WITHOUT CREATING A STATISTICS ENTRY
        // NEED TO CHECK WHY THIS HAPPENED - THE REPORT CREATED FROM HELPLINE ONLINE FORM
        // FOR THIS REASON THE CODE BELOW, CHEKCS IF AN ENTRY IN THE STATISTICS TABLE EXISTS AND IF NOT CREATES A NEW ONE 
          if (empty($statistics)) {
            $statistics = new FakenewsStatistics();
            $statistics->tracking_id = $fakenews->id;
        }

        $statistics->submission_type = $data['submission_type'];
        // user profile
        $statistics->age = (isset($data['age'])) ? $data['age'] : 'Not Set';
        $statistics->gender = (isset($data['gender'])) ? $data['gender'] : 'Not set';
        $statistics->report_role = (isset($data['report_role'])) ? $data['report_role'] : 'Not set';
        // report description       
        $statistics->fakenews_source_type = $data['fakenews_source_type'];
        $statistics->fakenews_type = (isset($data['fakenews_type'])) ? $data['fakenews_type'] : 'Undefined';
        $statistics->evaluation = (isset($data['evaluation'])) ? $data['evaluation'] : '50';
        $statistics->img_upload = $data['img_upload'];
        $statistics->loc_available = (  isset($data['country']) | 
                                        isset($data['town']) | 
                                        isset($data['area_district']) |
                                        isset($data['specific_address'])  ) 
                                        ? 1: 0;
        // operator actions
        $statistics->user_opened = (isset($data['user_opened'])) ? $data['user_opened'] : null;
        if (isset($data['user_assigned'])) $statistics->user_assigned = $data['user_assigned'];
        $statistics->priority = (isset($data['priority'])) ? $data['priority'] : 'Not set';
        $statistics->reference_by = (isset($data['reference_by'])) ? $data['reference_by'] : 'Not set';
        $statistics->reference_to = (isset($data['reference_to'])) ? $data['reference_to'] : 'Not set';
        $statistics->actions = (isset($data['actions'])) ? $data['actions'] : 'Not set';
        $statistics->status = $data['status'];
        $statistics->call_time = (isset($data['call_time'])) ? $data['call_time'] : null;
        $statistics->manager_comments = (isset($data['manager_comments'])) ? $data['manager_comments'] : null;
        $statistics->insident_reference_id = (isset($data['insident_reference_id'])) ? $data['insident_reference_id'] : null;
        $statistics->save();

        if ((!empty($request->images)) & ($request->img_upload == 1)){

            $validate_images = $request->validate([
                'images.*' => 'mimes:jpeg,png,jpg,gif,svg|max:10120'
            ]);

            if ($files = $request->images){
                foreach($files as $file){
                    $imageName = time() .'_' . $file -> getClientOriginalName();
                    $file->move(public_path("storage\\uploaded_images"),$imageName);
    
                    $picdata = array(
                        'picture_path' =>  $imageName
                    );
                    $pic = FakenewsPictures::create($picdata);
                    //$pic->update($picdata);
                    $picreffdata = array(
                        'fakenews_reference_id' => $fakenews->id,
                        'picture_reference_id'=>$pic -> id
                    );
                    $picreff = FakenewsPictureReff::create($picreffdata);
                    //$picreff->update($picreffdata);
                };
            };
            return redirect()->back();
        };

        return redirect()->route('home');
    }

    public function destroy($id)
    {
        $UserId = Input::get('UserId');
        if (User::find($UserId)->hasRole("admin") && GroupPermission::canuser($UserId, 'delete', 'fakenews')) {
            $fakenews = Fakenews::find($id);
            $fakenews->delete();
            $statistics = FakenewsStatistics::where('tracking_id', '=', $id)->first();
            $statistics -> delete();
        } else {
            if (GroupPermission::canuser($UserId, 'delete', 'fakenews')) {
                $fakenews = Fakenews::find($id);
                if ($fakenews->status == "Closed") {
                    $fakenews-> delete();
                    $statistics = FakenewsStatistics::where('tracking_id', '=', $id)->first();
                    $statistics -> delete();
                } else {
                    return Response::json('Report must be in Closed status', 500);
                }
            } else {
                return Response::json('error');
            }
        }
    }

    public function deleteimage($id,$image_id)
    {   
        //dd($image_id);
        
        $picture_title = FakenewsPictures::where('id','=',$image_id)->pluck('picture_path');
        if(unlink(public_path("storage\\uploaded_images" . '\\'. $picture_title[0])))
        {
            FakenewsPictures::where('id','=',$image_id)->delete();
            FakenewsPictureReff::where('picture_reference_id','=',$image_id)->delete();
        }
        return redirect()->back();
    }

    public function evalview()
    {   
        $fakenews = Fakenews::orderBy('updated_at', 'DESC')->select(['id', 'evaluation', 'comments','fakenews_source_type','fakenews_type', 'img_upload','actions', 'updated_at'])
                                ->where("fakenews_type",'!=','Undefined')->paginate(4);
        //dd($fakenews);
        //return ($fakenews);
        $img_array= Array();
        foreach($fakenews as $news)
        {
            if ($news['img_upload'] == 1)
            {
                $img_ids = FakenewsPictureReff::where('fakenews_reference_id', '=',$news['id'])->pluck('picture_reference_id');
                $img_names = FakenewsPictures::whereIn('id',$img_ids)->pluck('picture_path');
                array_push($img_array,$img_names);
            }
        }
        //$test_array= array_merge($fakenews,$img_array);
        //dd($test_array);
        //return($fakenews);
        return view('fakenews.evals')->with([
            'fakenews'=>$fakenews,
            'img_array'=>$img_array

        ]);
    }

}
?>
