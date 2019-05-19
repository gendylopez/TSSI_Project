<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Student;
use DB;

class StudentController extends Controller
{
    public function index()
    {
    	$sections = Section::all();

    	return view('pages.student', ['sections'=>$sections]);
    }

    public function addStudent(Request $request)
    {
        $student = new Student();
        $student->name = $request->name;
        $student->age = $request->age;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->section_id = $request->section;
        $student->save();

        $sections = Section::all();
      return response()->json($student);
    }

    public function editStudent(Request $request)
    {
        $student = Student::find($request->id);
        $student->name = $request->name;
        $student->age = $request->age;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->section_id = $request->section;
        $student->save();

        $sections = Section::all();
      return response()->json($student);
    }

    public function deleteStudent(Request $request)
    {
      $student = DB::table('student')->where('id', $request->id)->delete();

      return response()->json($student);
    }
}
