<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;
use App\Student;
use App\departmentHeader;
use App\User;
use App\internshipManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ManagerPasswordEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class DepartmentHeaderController extends Controller
{

public function showRequests(Request $request)
{
    $department = departmentHeader::find($request->headerId);
    $students = student::where("department_id", $department->department_id)
    ->with(["user","intern.internship","department.faculty.university"])
    ->get();
    return $students;
}

public function acceptRequest(Request $request){
    $intern = intern::where([
        ["id", $request->internId],
        ['internship_id', $request->internshipId]
    ])->first();

    $internship = $intern->internship;
    $manager = $internship->manager;
    $password = Str::random(8);
    $hashed_password =  bcrypt($password);
    $manager->update(["validation" => 1]);
    $manager->user->update(['password' => $hashed_password]);
    $intern->update(["header_validation" => 1]);
    $user=$manager->user->first_name;


        Mail::to($manager->user->email)->send(new ManagerPasswordEmail($password,$user));


    return response()->json([
        'msg' => 'information updated successfully',
    ]);

}





}
