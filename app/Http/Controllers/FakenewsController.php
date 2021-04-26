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
use Carbon\Carbon;
use Mail;  // <<<<


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FakenewsController extends Controller
{
    public function __construct()
    {
        //doesnt do anything i guess???
        $this->middleware('checkdelete');
    }


    
    //public function index($loc = null)
    //{

    //}
    //
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
    }
}
