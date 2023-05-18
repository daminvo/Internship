<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;
use App\Student;
use App\InternshipOffer;
use App\internshipManager;
use Carbon\Carbon;


class InternController extends Controller
{

     public function getPendingRequests(Request $request){

        $intern = Intern::where([['student_id', $request->studentId],['student_validation',null]])
         ->with(['internship' => function ($query) {
            $query->select('id','title','manager_id', 'duration',);
        },"internship.manager.user","internship.manager.company" => function ($query) {
            $query->select('id','name');
        }])
        ->get();
        $intern->each(function ($intern) {
            $internship = $intern->internship;
            $internship->type = $this->getRequestType($internship->id);
        });

        return $intern;
        }



     private function getRequestType($id)
        {
            $offre = internshipOffer::where('internship_id', $id)->first();
            return $offre ? 'public' : 'private';
        }

     public function getOngoinginternships(Request $request){
        try{
        $today = Carbon::today()->toDateString();
        $intern = Intern::where([['student_id', $request->studentId],['student_validation',1],['manager_validation',1],['start_date','<', $today],['end_date', '>', $today]])
        ->with(['internship' => function ($query) use ($today){
           $query->select('id','title','manager_id', 'duration',);
       },"internship.manager.user"
       ,"internship.manager.company" => function ($query) {
           $query->select('id','name');
       }])
       ->get();
       $intern->each(function ($intern) {
           $internship = $intern->internship;
           $internship->type = $this->getRequestType($internship->id);
       });

       return $intern;
        }
       catch (Throwable $e) {
        $errorMessage = $e->getMessage();
        return response()->json(['error' => $errorMessage], 500);
    }
    }

    public function getFinishedinternships(Request $request){
        try{
        $today = Carbon::today()->toDateString();
        $intern = Intern::where([['student_id', $request->studentId],['student_validation',1],['manager_validation',1],['start_date','<', $today],['end_date', '<', $today]])
        ->with(['internship' => function ($query){
           $query->select('id','title','manager_id', 'duration',);
       },"internship.manager.user","internship.manager.company" => function ($query) {
           $query->select('id','name');
       }])
       ->get();
       $intern->each(function ($intern) {
           $internship = $intern->internship;
           $internship->type = $this->getRequestType($internship->id);
       });

       return $intern;
        }
       catch (Throwable $e) {
        $errorMessage = $e->getMessage();
        return response()->json(['error' => $errorMessage], 500);

    }
    }

    public function getAcceptedinternships(Request $request){
        try{
        $today = Carbon::today()->toDateString();
        $intern = Intern::where([['student_id', $request->studentId],['student_validation',1],['manager_validation',1],['start_date','>', $today]])
        ->with(['internship' => function ($query) use ($today){
           $query->select('id','title','manager_id', 'duration',);
       },"internship.manager.user","internship.manager.company" => function ($query) {
           $query->select('id','name');
       }])
       ->get();
       $intern->each(function ($intern) {
           $internship = $intern->internship;
           $internship->type = $this->getRequestType($internship->id);
       });

       return $intern;
        }
       catch (Throwable $e) {
        $errorMessage = $e->getMessage();
        return response()->json(['error' => $errorMessage], 500);

    }
    }

    public function deleteRequest(Request $request){
        $intern = intern::find($request->id);
        if ($request->type == "private") {
            $intern->delete();
            $intern->internship->delete();
        } else {
            $intern->delete();
        }
        return response()->json([
            'msg' => 'request deleted successfully',
        ]);
    }







}
