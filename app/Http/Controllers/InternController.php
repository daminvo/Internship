<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;
use App\Student;
use Carbon\Carbon;


class InternController extends Controller
{

    public function showRequest(Request $request){

       $internships = Intern::where('student_id',$request->studentId)
       ->where('valide','=',false)
       ->with(['internship']);

       return $internships->get();
    }

    public function showCurrentInternships(Request $request){
        $today = Carbon::today()->toDateString();
        $student = Student::find($request->studentId);
        $internships = $student->internships()
        ->where('start_date','<', $today)
        ->where('end_date', '>', $today)
        ->where('valide','=',true)
        ->get();

        return $internships;
    }


    public function showFinchedInternships(Request $request){
        $today = Carbon::today()->toDateString();
        $student = Student::find($request->studentId);
        $internships = $student->internships()
        ->where('end_date', '<', $today)
        ->where('valide','=',true)
        ->get();

        return $internships;
    }

}
