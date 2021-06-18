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
        $this->middleware('checkdelete');
    }

    public function validator(Request $request){

        // Set validation rules for fields
        $data = $request->all();

        // validation rules for all.
        $rules = [
            'fakenews_source_type'=>'required',
            'publication_date'=> 'required|date',
            'img_upload'=>"required",
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

        // validation rule if you want to provide personal
        if ($request->personal_data === 'true') {
            $rules['email'] = 'required_without:phone';
            $rules['phone'] = 'required_without:email';
        }
        // not submited by an operator
        if (!$request->submitted_by_operator === 'true') {
            $rules['personal_data'] = 'required';
        // submited by operator
        }else{
            if (isset($data['insident_reference_id'])){
                $rules['insident_reference_id'] = 'exists:fakenews,id';
            }
        }

        // Generate a new validator instance
        $validator = Validator::make($request->all(), $rules, Lang::get('validation.custom.entry', array(), Session::get('lang')));
        
        // Add any conditional validation rules
        $validator->sometimes('phone', 'numerdateformatic', function ($input) {
            return $input->personal_data == "true" && $input->email == "";
        });

        if ($validator->fails()) {
            //dd($validator->messages());
            return redirect()->back()->with(['errors' => $validator->messages()])->withInput();
        }
        
        return null;
    }

    /**
     * Return all resources needed
     */
    public function resources(){
        return ['actions' => ActionTaken::all(),
                'age_groups' => AgeGroup::all(),
                'fakenews_type' => FakenewsType::all(),
                'fakenews_source_type' => FakenewsSourceType::all(),
                'genders' => Gender::all(),
                'report_roles' => ReportRole::all(),
                'submission_types' => SubmissionType::all(),
                'references_by' => ReferenceBy::all(),
                'references_to' => ReferenceTo::all(),
                'priorities' => Priority::all(),
                'users' => User::all(),
                'status' => Status::all()
            ];
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
        return view('fakenews.create')->with(self::resources());
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

        $data = $request->all();
        // Defaults
        $data['submission_type'] = (!empty($request->submission_type)) ? $request->submission_type : 'electronic-form';
        $data['evaluation'] = (!empty($request->evaluation)) ? $request->evaluation : '50';
        $data['img_upload'] = (!empty($request->img_upload)) ? $request->img_upload : 0;

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

        if ($request->submitted_by_operator) {
            return redirect('home');
        }
       
        return redirect('fakenews/submitted')->with('success-info', Lang::get('success.submited', array(), Session::get('lang')));
    }
      /**
     * Display the specified resource.
     *
     * @param \App\Fakenews $fakenews
     * @return \Illuminate\Http\Response
     */
    public function show(Fakenews $fakenews)
    {
        $users = User::all();

        // People that can view a report are: admins / first opened / assigned

        if ( auth()->user()->hasRole("admin") || auth()->user()->hasRole("manager") || ($fakenews->user_assigned == Auth::id() || $fakenews->forwarded == 'true' || empty($fakenews->user_opened)) || (($fakenews->user_opened == Auth::id()) &&  (empty($fakenews->user_assigned)))) {
            if ($fakenews->status === 'Closed' &&  !auth()->user()->hasRole('manager') && !auth()->user()->hasRole("admin")){
                return redirect()->route('home');
            }

            $fakenews->log="";
            $first=!empty($fakenews->firstResponder)?$fakenews->firstResponder->name:"";
            $last=!empty($fakenews->lastResponder)?$fakenews->lastResponder->name:"";
            
            if ($fakenews->status != 'Closed') {
                $fakenews->log .= "| Assigned to :" . Auth::User()->email;
                $fakenews->status = "Opened";
            }
            
            // store the id of the first operator that opens the report
            if ((empty($fakenews->user_opened) || $fakenews->user_opened == NULL) ){
                $fakenews->log .= $first."->".$last ;
                $fakenews->user_opened = Auth::id();
                $fakenews->user_assigned =null;
            }
            
            $new_date = date('d/m/Y h:i', strtotime($fakenews->call_time));
            $fakenews->call_time = $new_date;
            
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
            if ($fakenews->img_upload==1){
                $image_array_ids = FakenewsPictureReff::where('fakenews_reference_id','=',$fakenews->id)->pluck('picture_reference_id');
                foreach($image_array_ids as $image_id){
                    $img_path = FakenewsPictures::where('id','=',$image_id)->pluck('picture_path');
                    $image_array[$image_id]=$img_path[0];
                }
            }
            
            return view('fakenews.edit')->with(array_merge(['fakenews' => $fakenews,'pictures'=>$image_array], self::resources()));
        }
        return redirect()->route('home');
    }

    /**
     * Save the data after editing the specified resource.
     *
     * @param \App\Fakenews $fakenews
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Fakenews $fakenews)
    {
        $validation = self::validator($request);

        if($validation){
            return $validation;
        }
        
        $data = $request->all();

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
        $UserId = Auth::user()->id;
        
        if (User::find($UserId)->hasRole("admin") && GroupPermission::canuser($UserId, 'delete', 'fakenews')) {
            $fakenews = Fakenews::find($id);
            $fakenews->delete();
        } else {
            if (GroupPermission::canuser($UserId, 'delete', 'fakenews')) {
                $fakenews = Fakenews::find($id);
                if ($fakenews->status == "Closed") {
                    $fakenews-> delete();
                } else {
                    return Response::json('Report must be in Closed status', 409);
                }
            } else {
                return Response::json('Something went wrong, try again later', 500);
            }
        }
    }

    public function deleteimage($id,$image_id)
    {   

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
        return view('fakenews.evals')->with([
            'fakenews'=>$fakenews,
            'img_array'=>$img_array

        ]);
    }

}
?>
