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
        },"internship.manager"
        => function ($query) {
            $query->select('id','company_id');
        },"internship.manager.company" => function ($query) {
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
            return $offre ? 'offer' : 'request';
        }

     public function getFinishedinternship(Request $request){

        $intern = Intern::where('student_id', $request->studentId)
        ->whereHas('internship', function ($query) {
        $query->where('state', 'finished');
         })
         ->with(['internship' => function ($query) {
            $query->select('id','title','manager_id', 'duration',);
        },"internship.manager"
        => function ($query) {
            $query->select('id','company_id');
        },"internship.manager.company" => function ($query) {
            $query->select('id','name');
        }])
        ->get();

        $intern->each(function ($intern) {
            $internship = $intern->internship;
            $internship->type = $this->getRequestType($internship->id);
        });

        return $intern;
     }



}
