<?php
/**
 * PHP Version 7.1.7-1
 * Functions for users
 *
 * @category  File
 * @package   User
 * @author    Team Blend
 * @copyright BLEND  
 * @license   BSD Licence
 * @link      Link
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\CourseRating;
use App\Models\InstructionLevel;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;
use SiteHelpers;
use Crypt;
use App\Library\VideoHelpers;
use URL;
use App\Models\CourseVideos;
use App\Models\CourseFiles;
use Session;
/**
 * Class contain functions for admin
 *
 * @category  Class
 * @package   User
 * @author    Team Blend
 * @copyright BLEND
 * @license   BSD Licence
 * @link      Link
 */
class StudentController extends Controller
{
    /**
     * Function to display the dashboard contents for admin
     *
     * @param array $request All input values from form
     *
     * @return contents to display in dashboard
     */
    public function index(Request $request)
    {
        $user_id = \Auth::user()->id;
        $courses = DB::table('courses')
                    ->select('courses.*', 'instructors.first_name', 'instructors.last_name', 'course_taken.*')
                    ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
                    ->join('course_taken', 'course_taken.course_id', '=', 'courses.id')
                    ->where('course_taken.user_id',$user_id)->get();

        $count_enrolled = DB::table('course_taken')
                           ->select(DB::raw('count(*) as count_enrolled'))
                           ->where('course_taken.user_id', $user_id)
                           ->where('course_taken.isCompleted', 0)
                           ->groupBy('course_taken.user_id')->get();


        $gpa = 0.0;
        $TC = 0.0;
        $TS = 0.0;

        foreach ($courses as $course){
            if ($course->isCompleted && $course->Term == 'Spring 2020') {
                $cred = $course->Credits;
                $TC = $TC + $cred;
                $grad = $course->grade;
                if ($grad == 'A'){
                    $TS = $TS + ($cred*4.0);
                }
                else if ($grad == 'A-'){
                    $TS = $TS + ($cred*3.67);
                }
                else if ($grad == 'B+'){
                    $TS = $TS + ($cred*3.33);
                }
                else if ($grad == 'B'){
                    $TS = $TS + ($cred*3.00);
                }
                else if ($grad == 'B-'){
                    $TS = $TS + ($cred*2.67);
                }
                else if ($grad == 'C+'){
                    $TS = $TS + ($cred*2.33);
                }
                else if ($grad == 'C'){
                    $TS = $TS + ($cred*2.00);
                }
                else if ($grad == 'C-'){
                    $TS = $TS + ($cred*1.69);
                }
            

            }
        }

        if($TC != 0){
            $gpa = $TS/$TC;
        }

        $cgpa = 0.0;
        $totalCredits = 0.0;
        $totalScore = 0.0;
        foreach ($courses as $course){
            
            if ($course->isCompleted) {
                $cred = $course->Credits;
                $totalCredits = $totalCredits + $cred;
                $grad = $course->grade;
                if ($grad == 'A'){
                    $totalScore = $totalScore + ($cred*4.0);
                }
                else if ($grad == 'A-'){
                    $totalScore = $totalScore + ($cred*3.67);
                }
                else if ($grad == 'B+'){
                    $totalScore = $totalScore + ($cred*3.33);
                }
                else if ($grad == 'B'){
                    $totalScore = $totalScore + ($cred*3.00);
                }
                else if ($grad == 'B-'){
                    $totalScore = $totalScore + ($cred*2.67);
                }
                else if ($grad == 'C+'){
                    $totalScore = $totalScore + ($cred*2.33);
                }
                else if ($grad == 'C'){
                    $totalScore = $totalScore + ($cred*2.00);
                }
                else if ($grad == 'C-'){
                    $totalScore = $totalScore + ($cred*1.69);
                }
            

            }

            
        }
        if($totalCredits != 0){
            $cgpa = $totalScore/$totalCredits;
        }
        
        return view('students.index', compact('courses', 'cgpa', 'count_enrolled', 'gpa'));
    }

    public function pastCourses(Request $request)
    {
        $user_id = \Auth::user()->id;

        $courses = DB::table('courses')
                    ->select('courses.*', 'instructors.first_name', 'instructors.last_name', 'course_taken.*')
                    ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
                    ->join('course_taken', 'course_taken.course_id', '=', 'courses.id')
                    ->where('course_taken.user_id',$user_id)
                    ->where('course_taken.isCompleted', 1)->get();



        return view('students.pastCourses', compact('courses'));
    }

    public function getForm($user_id='', Request $request)
    {
        if($user_id) {
            $user = User::find($user_id);
        }else{
            $user = $this->getColumnTable('users');
        }
        return view('admin.users.form', compact('user'));
    }

    public function saveUser(Request $request)
    {
        // echo '<pre>';print_r($_POST);exit;
        $user_id = $request->input('user_id');

        //validation rules
        if ($user_id) {
            
            $validation_rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'roles' => 'required'
            ];

        } else {
            
            $validation_rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'roles' => 'required'
            ];

        }

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        if ($user_id) {
            $user = User::find($user_id);
            // Detach all roles for the existing user to update new roles...
            $user->roles()->detach();
            $success_message = 'User updated successfully';
        } else {
            $user = new User();
            $success_message = 'User added successfully';
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        $password = $request->input('password');
        if($password) {
            $user->password = bcrypt($password);
        }
        

        $user->is_active = $request->input('is_active');
        $user->save();

        if($request->exists('roles')) {
            $roles = $request->input('roles');
            foreach ($roles as $role_name) {
                $role = Role::where('name', $role_name)->first();
                $user->roles()->attach($role);
            }

        }
        
        
        return $this->return_output('flash', 'success', $success_message, 'admin/users', '200');
    }

    public function getData()
    {
        return DataTables::eloquent(User::query())
                            ->addColumn(
                                'user',
                                function (User $user) {
                                    return '<span class="badge badge-primary">Primary</span>';
                                }
                            )
        ->make(true);
    }
    
}
