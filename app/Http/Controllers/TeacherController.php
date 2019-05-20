<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Subject;
use App\Teacher;
use App\User;
use DB;
use Auth;

class TeacherController extends Controller
{
    public function index()
    {

        $account = Teacher::all();
      
    	$subjects = Subject::all();

    	return view('pages.teacher', ['subjects'=>$subjects, 'account' => $account]);
    }


    public function editTeacher(Request $request)
    {
        $teacher = Teacher::find($request->id);
        $teacher->name = $request->name;
        $teacher->subject_id = $request->subject;
        $teacher->save();

        $user = User::find($teacher->user_id);
        $user->email = $request->email;
        $user->save();

      return response()->json($teacher);
    }

	public function editPassword(Request $request) {

		$result=null;
		if($request->action=='oldcheck'){
		    $user = User::find (Auth::user()->id);
		    $result=null;
		    if(!Hash::check($request->oldpass, $user->password)){
		      $result="1";
		    }
		}
		else if($request->action=='changepass'){
		    $result = User::find (Auth::user()->id);
		    $result->password = bcrypt($request->newpass);
		    $result->save();
	}
	return response()->json($result);
	}
}
