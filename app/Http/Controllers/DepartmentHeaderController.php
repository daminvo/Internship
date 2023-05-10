<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;
use App\Student;
use App\departmentHeader;
use App\User;

use Illuminate\Support\Collection;

class DepartmentHeaderController extends Controller
{

public function showRequests(Request $request)
{
    $department = departmentHeader::find($request->headerId);
    $students = student::where("departement_id", $department->department_id)->with(["user", "intern" => function ($query) {
        $query->select('student_id', 'internship_id');
    }])
    ->with(["intern.internship"])
    ->get();
    return $students;
}



public function acceptRequest(Request $request)
{
    intern::where("internship_id",$request->internshipId)->update(['valide'=>true]);
    return response()->json([
        'msg' => 'information updated successfuly',

    ]);
}



}
