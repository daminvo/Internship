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
use Carbon\Carbon;


class DepartmentHeaderController extends Controller
{

public function showRequests(Request $request)
{
    $department = departmentHeader::find($request->headerId);
    $students = student::where("department_id", $department->department_id);
    $intern = intern::where('header_validation',null)
    ->with(["student.user","internship.manager.company","student.department.faculty.university"])
    ->get();
    return $intern;
}

public function acceptRequest(Request $request){
    $intern = intern::where([
        ["id", $request->internId],
        ['internship_id', $request->internshipId]
    ])->first();
    $internship = $intern->internship;
    $manager = $internship->manager;
    if($manager->validaion == "0"){
        $password = Str::random(8);
        $hashed_password =  bcrypt($password);
        $manager->update(["validation" => 1]);
        $manager->user->update(['password' => $hashed_password]);
        Mail::to($manager->user->email)->send(new ManagerPasswordEmail($password,$user));
    }
    $intern->update(["header_validation" => 1]);
    return response()->json([
        'msg' => 'information updated successfully',
    ]);
}
public function refuseRequest(Request $request ){
    $intern = intern::where([
        ["id", $request->internId],
        ['internship_id', $request->internshipId]
    ])->first();
    $intern->update(["header_validation" => 0]);
    return response()->json([
        'msg' => 'information updated successfully',
    ]);

}
public function getOngoingInternsNumber(Request $request)
{
    $today = Carbon::today()->toDateString();
    $department = departmentHeader::find($request->headerId);
    $students = Student::where("department_id", $department->department_id)
        ->whereHas('intern', function ($query)use ($today) {
            $query->where([['header_validation', 1],['manager_validation', 1],['start_date','<', $today],['end_date', '>', $today]]);
        })
        ->count();
    return $students;
}
public function getAllStudentsNumber(Request $request){
    $department = departmentHeader::find($request->headerId);
    $students = Student::where("department_id", $department->department_id)
    ->count();
    return $students;
}


public function getOngoingInterns(Request $request)
{
    $today = Carbon::today()->toDateString();
    $department = departmentHeader::find($request->headerId);
    $students = Student::where("department_id", $department->department_id)
        ->whereHas('intern', function ($query) use ($today) {
            $query->where([['header_validation', 1],['manager_validation', 1],['start_date','<', $today],['end_date', '>', $today]]);
        })
        ->with(['user', 'intern.internship'])
        ->get();
    return $students;
}


public function getIntern(Request $request)
{
    $intern = Intern::where("id", $request->internId)
        ->with([
            "student.user",
            "internship.manager.company",
            "internship.manager.user"
        ])
        ->first();

    return $intern;
}

}















