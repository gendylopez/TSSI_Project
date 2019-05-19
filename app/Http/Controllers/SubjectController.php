<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use DB;

class SubjectController extends Controller
{
    public function index()
    {

    	return view('pages.subject');
    }

    public function addSubject(Request $request)
    {
        $subject = new Subject();
        $subject->name = $request->name;
        $subject->save();

      return response()->json($subject);
    }

    public function editSubject(Request $request)
    {
        $subject = Subject::find($request->id);
        $subject->name = $request->name;
        $subject->save();

        $subjects = Subject::all();
      return response()->json($subject);
    }

    public function deleteSubject(Request $request)
    {
      $subject = DB::table('subject')->where('id', $request->id)->delete();

      return response()->json($subject);
    }
}
