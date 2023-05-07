<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;
use App\Student;
use App\departmentHeader;


class DepartmentHeaderController extends Controller
{
//   public function showRequests(Request $request){
//     $department = departmentHeader::find("department_id")
//     ->where("id",$request->headerId);
//     $student = student::find("student_id")
//     ->where("department_id",$department);
//     $intern = intern::find("internship_id")
//     ->where("student_id","=",$student);

//     return $intern->get();
//   }

// public function showRequests(Request $request)
// {
//     $department = departmentHeader::find($request->headerId);
//     $student = student::where("departement_id", $department->department_id)->first();
//     $intern = intern::where("student_id", $student->id)->first();
//     $internship=internship::where("id",$intern->internship_id)
//     ->get();

//     return $internship;
// }

public function showRequests(Request $request)
{
    $department = departmentHeader::find($request->headerId);
    $students = student::where("departement_id", $department->department_id)->get();
    $studentIds = $students->pluck('id')->toArray();
    $interns = intern::whereIn("student_id", $studentIds)->get();
    $internshipIds = $interns->pluck('internship_id')->toArray();
    $internships = internship::whereIn('id', $internshipIds)->get();

    return $internships;
}



}
