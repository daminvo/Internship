<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\internship;
use App\internshipManager;
use App\company;
use App\User;

class StudentController extends Controller
{

    public function createRequest(Request $request){
        //$student_request=student::where ($request->student_id,"id")->;
        if($request->companyId === "other"  ){
            $companies['name'] = $request->name;
            $companies['address'] = $request->address;
            $companies = company::create($companies);

                $users['first_name'] = $request->firstName;
                $users['family_name'] = $request->familyName;
                $users['email'] = $request->email;
                $users['phone'] = $request->phone;
                $users['address'] = $request->address;
                $users['gender'] = $request->gender;
                $users['role'] = "manager";
                $users = User::create($users);

                $manager['company_id'] = $companies->getKey();
                $manager['user_id'] = $users->getKey();
                $manager = internshipManager::create($manager);

            internship::insert(['duration'=>$request->duration,'motivation' => $request->motivation,'start_date'=>$request->startDate,'end_date'=>$request->endDate,'demand_date'=>$request->demandDate,'student_id'=>$request->studentId,'manager_id'=>$manager->getKey(),'title'=>$request->title]);
            return response()->json([
                'msg' => 'information inserted successfuly',
            ]);
        } elseif ($request->managerId === "" || $request->managerId === "other") {

            $company = company::find($request->companyId);

            $users['first_name'] = $request->firstName;
            $users['family_name'] = $request->familyName;
            $users['email'] = $request->email;
            $users['phone'] = $request->phone;
            $users['address'] = $company->address;
            $users['gender'] = $request->gender;
            $users['role'] = "manager";
            $users = User::create($users);

            $manager['company_id'] = $company->id;
            $manager['user_id'] = $users->getKey();
            $manager = internshipManager::create($manager);

            internship::insert(['duration'=>$request->duration,'motivation' => $request->motivation,'start_date'=>$request->startDate,'end_date'=>$request->endDate,'demand_date'=>$request->demandDate,'student_id'=>$request->studentId,'manager_id'=>$manager->getKey(),'title'=>$request->title]);
            return response()->json([
                'msg' => 'information inserted successfuly',
            ]);
        } else {
            internship::insert(['duration'=>$request->duration,'motivation' => $request->motivation,'start_date'=>$request->startDate,'end_date'=>$request->endDate,'demand_date'=>$request->demandDate,'student_id'=>$request->studentId,'manager_id'=>$request->managerId,'title'=>$request->title]);
        return response()->json([
       'msg' => 'information is inserted successfuly',
           ]);
        }

    }










    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
