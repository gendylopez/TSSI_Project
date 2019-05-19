<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use DB;

class SectionController extends Controller
{
    public function index()
    {

    	return view('pages.section');
    }

    public function addSection(Request $request)
    {
        $section = new Section();
        $section->name = $request->name;
        $section->save();

      return response()->json($section);
    }

    public function editSection(Request $request)
    {
        $section = Section::find($request->id);
        $section->name = $request->name;
        $section->save();

        $sections = Section::all();
      return response()->json($section);
    }

    public function deleteSection(Request $request)
    {
      $section = DB::table('section')->where('id', $request->id)->delete();

      return response()->json($section);
    }
}
