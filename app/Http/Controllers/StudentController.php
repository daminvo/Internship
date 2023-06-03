<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\internship;
use App\internshipManager;
use App\InternshipOffer;
use App\company;
use App\User;
use App\intern;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



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


            $internship = internship::create(['duration'=>$request->duration, 'demand_date'=>Carbon::today()->toDateString(),'manager_id'=>$manager->getKey(),'title'=>$request->title, 'state' => 'pending']);

            intern::create(['student_id'=>$request->studentId, 'internship_id' => $internship->getKey(), 'start_date'=>$request->startDate,'end_date'=>$request->endDate,'motivation' => $request->motivation]);

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

            $manager['company_id'] = $request->companyId;
            $manager['user_id'] = $users->getKey();
            $manager = internshipManager::create($manager);

            $internship = internship::create(['duration'=>$request->duration,'demand_date'=>Carbon::today()->toDateString(),'manager_id'=>$manager->getKey(),'title'=>$request->title, 'state' => 'pending']);

            intern::create(['student_id'=>$request->studentId, 'internship_id' => $internship->getKey(), 'motivation' => $request->motivation,'start_date'=>$request->startDate,'end_date'=>$request->endDate]);

            return response()->json([
                'msg' => 'information inserted successfuly',
            ]);

        } else {
            $internship = internship::create(['duration'=>$request->duration,'demand_date'=>Carbon::today()->toDateString(),'manager_id'=>$request->managerId,'title'=>$request->title, 'state' => 'pending']);

            intern::create(['student_id'=>$request->studentId, 'internship_id' => $internship->getKey(), 'motivation' => $request->motivation,'start_date'=>$request->startDate,'end_date'=>$request->endDate,]);

            return response()->json([
                'msg' => 'information is inserted successfuly',
            ]);

        }

    }

    public function applyOffer(Request $request) {
        intern::insert(['student_id' => $request->studentId ,'motivation' => $request->motivation,'internship_id' => $request->internshipId,'start_date' => $request->startDate, 'end_date' => $request->endDate, 'header_validation' => 1]);
        return response()->json([
            'msg' => 'information is inserted successfuly',
        ]);
    }


    public function getAllOffres(Request $request){

        $user = $request->user();

        if ($user && $user->role === 'student') {
            return InternshipOffer::with(['internship.manager.user', 'is_favorited'=>
                function ($q) use ($user) {
                    $q->where('favorites.student_id', $user->student()->pluck('id'));
                }
            ])
            ->simplePaginate(9);
        }

        return InternshipOffer::with(['internship.manager.user'])->simplePaginate(9);

    }

    public function getOffre(Request $request){

        $user = $request->user();

        $InternshipOffer=InternshipOffer::where('id',$request->id)->with(["internship.manager.user", "is_favorited" =>
            function ($q) use ($user) {
                $q->where('favorites.student_id', $user->student()->pluck('id'));
            }
        ])
        ->get();

        return $InternshipOffer;
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
