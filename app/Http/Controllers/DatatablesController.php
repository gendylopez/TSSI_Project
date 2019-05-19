<?php

namespace App\Http\Controllers;

use Student;
use Section;
use Subject;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class DatatablesController extends Controller
{

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getStudents()
	{        
        $students = DB::select(DB::raw("SELECT student.id as id, student.name as name, age, phone, address, section.name as section, section_id, student.created_at, student.updated_at FROM student LEFT JOIN section ON student.section_id=section.id"));

		return DataTables::of($students)
            ->addColumn('action', function ($student) {
                return '<button id="'.$student->id.'" class="edit-modal btn btn-primary btn-xs" data-id="'.$student->id.'" data-name="'.$student->name.'" data-age="'.$student->age.'" data-phone="'.$student->phone.'" data-address="'.$student->address.'" data-section="'.$student->section_id.'">Edit</button> <button  class="delete-modal btn btn-danger btn-xs" data-id="'.$student->id.'" data-name="'.$student->name.'" style="margin-left:5px;">Delete</button>';
            })->make(true);
	}

	public function getSections()
	{  
		$sections = DB::select(DB::raw("SELECT * FROM section"));
		return Datatables::of($sections)
            ->addColumn('action', function ($section) {
                return '<button id="'.$section->id.'" class="edit-modal btn btn-primary btn-xs" data-id="'.$section->id.'" data-name="'.$section->name.'">Edit</button> <button class="delete-modal btn btn-danger btn-xs" data-id="'.$section->id.'" data-name="'.$section->name.'" style="margin-left:5px;">Delete</button>';
            })->make(true);
	}

	public function getSubjects()
	{  
		$subjects = DB::select(DB::raw("SELECT * FROM subject"));
		return Datatables::of($subjects)
            ->addColumn('action', function ($subject) {
                return '<button id="'.$subject->id.'" class="edit-modal btn btn-primary btn-xs" data-id="'.$subject->id.'" data-name="'.$subject->name.'">Edit</button> <button  class="delete-modal btn btn-danger btn-xs" data-id="'.$subject->id.'" data-name="'.$subject->name.'" style="margin-left:5px;">Delete</button>';
            })->make(true);
	}
}
