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
use App\Statistics;
use App\Fakenews;
use App\FakenewsType;
use App\FakenewsPictures;
use App\FakenewsPictureReff;
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
     * In this case we display the form /helpline/{lang}/form
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

        // for some reason the first time it loads the page Session get lang return null, so line below sets gr to default
        if (!isset($locale)) {
            $web = explode('/', url()->current());
            $locale = $web[4];
        }

        App::setLocale($locale);
        Session::put('lang', $loc);
        if ($locale == 'gr') {
            return view('fakenews.form-en')->with([
                'fakenews_type'=>$fakenewstype,
                'age_groups' => $age_groups,
                'genders' => $genders
            ]);
        } else {
            return view('fakenews.form-en')->with([
                'fakenews_type'=>$fakenewstype,
                'age_groups' => $age_groups,
                'genders' => $genders
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


    
    //public function index($loc = null)
    //{

    //}
    //
/* public function create()
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

    $userThathaveAccessonFakenews = Array();
    foreach ($users as $user) {
        if (GroupPermission::canuser($user->id, 'edit', 'fakenews')) {
            $userThathaveAccessonFakenews[] = $user;
        }
    }

    return view('create.fakenews')->with([
        'resource_types' => $resource_types,
        'content_types' => $content_types,
        'age_groups' => $age_groups,
        'genders' => $genders,
        'report_roles' => $report_roles,
        'submission_types' => $submission_types,
        'references_by' => $references_by,
        'references_to' => $references_to,
        'priorities' => $priorities,
        'users' => $userThathaveAccessonHotline, //$users,
        'status' => $status,
        'actionstaken' => $actions
    ]);       
} */


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the post...
        if (!$request->submitted_by_operator) 
        {
            

            // Set validation rules for fields
            $rules = [
                'fakenews_type' => 'required',
                'title'=> 'required',
                'source_document' => 'required',
                'source' => 'required',
                'publication_date'=> 'required',
                'source_url' => 'url|required_if:fakenews_type,fakenews,realnews',
                'personal_data' => 'required',
                'country' => 'required',
                'name' => 'required_if:personal_data,true',
                'images.image' => 'mimes:jpeg,png,jpg,gif,svg|max:5048',
            ];
            if ($request->personal_data == 'true') {
                $rules['email'] = 'required_without:phone';
                $rules['phone'] = 'required_without:email';
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
        //$fakenews = new Fakenews;

        $data = $request->all();

        // Defaults
        $data['submission_type'] = (!empty($request->submission_type)) ? $request->submission_type : 'electronic-form';
        $data['evaluation'] = (!empty($request->submission_type)) ? $request->evaluation : '1';
        
        //unset($data['submitted_by_operator']);
        

        /* if (!empty($data['call_time'])) {
            $dateformat = Carbon::createFromFormat('d/m/Y H:i:s', $data['call_time'] . ":00");
            $data['call_time'] = $dateformat;
        } */

        unset($data['images']);
        unset($data['_token']);
        unset($data["g-recaptcha-response"]);
        $id = Fakenews::create($data)->id;
        $fakenews = Fakenews::find($id);

        if ($files = $request->images){
            foreach($files as $file){
                $imageName = time().'_'.$file->getClientOriginalName();
                $file->move(storage_path("uploaded_images"),$imageName);
                $picdata = array(
                    'picture_path' => storage_path("uploaded_images") . $imageName
                );
                $pic = FakenewsPictures::create($picdata);
                $pic->update($picdata);
                $picreffdata = array(
                    'fakenews_reference_id' => $id,
                    'picture_reference_id'=>$pic->id
                );
                $picreff = FakenewsPictureReff::create($picreffdata);
                $picreff->update($picreffdata);
            }
        }

        /*if (isset($data['call_time'])){
            $helpline->call_time = $data['call_time'];
        } */

        $fakenews->update($data);

       /*  $statistics = new Statistics();

        // Get the created incident so we add its id to the Statistics so we can track it!!!
        // $returnLatest = Helpline::latest()->first();
        $statistics->tracking_id = $id;// $returnLatest->id;
        //
        $statistics->is_it_hotline = (isset($data['is_it_hotline'])) ? 'true' : 'false';
        $statistics->submission_type = $data['submission_type'];
        // user profile
        $statistics->age = (isset($data['age'])) ? $data['age'] : 'Not Set';
        $statistics->gender = (isset($data['gender'])) ? $data['gender'] : 'Not set';
        $statistics->report_role = (isset($data['report_role'])) ? $data['report_role'] : 'Not set';
        // report description
        $statistics->resource_type = $data['resource_type'];
        $statistics->content_type = $data['content_type'];
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
        $statistics->save(); */

        //HelplineController::emailInformOperators($is_it_hotline);  //if email server enabled.. then you can send email!

/*         if ($request->submitted_by_operator) {
            return redirect('home');
        }
 */
        return redirect('fakenews/submitted')->with('success-info', Lang::get('success.submited', array(), Session::get('lang')));
    }


}
?>
