<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;
use App\Student;
use App\Rating;
use App\InternshipOffer;
use App\internshipManager;
use APP\presence;
use APP\Rating;
use Carbon\Carbon;


class InternController extends Controller
{

     public function getPendingRequests( $id){

        $intern = Intern::where([['student_id', $id],['student_validation',null]])
         ->with(['internship' => function ($query) {
            $query->select('id','title','manager_id', 'duration',);
        },"internship.manager.user","internship.manager.company" => function ($query) {
            $query->select('id','name');
        }])
        ->get();
        try{
        $intern->each(function ($intern) {
            $internship = $intern->internship;
            $internship->type = $this->getRequestType($internship->id);
            if($internship->type == "public"){
                $internship->id = $internship->internshipOffer->id;
               }
        });
        }catch (Throwable $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
        return $intern;
        }



     private function getRequestType($id)
        {
            $offre = internshipOffer::where('internship_id', $id)->first();
            return $offre ? 'public' : 'private';
        }

     public function getOngoinginternships(Request $request){
        $today = Carbon::today()->toDateString();
        $intern = Intern::where([['student_id', $request->studentId],['student_validation',1],['manager_validation',1],['start_date','<', $today],['end_date', '>', $today]])
        ->with(['internship' => function ($query) use ($today){
           $query->select('id','title', 'description', 'manager_id', 'duration',);
       },"internship.manager.user","presence"
       ,"internship.manager.company" => function ($query) {
           $query->select('id','name');
       }])
       ->get();
        try{
       $intern->each(function ($intern) {
           $internship = $intern->internship;
           $internship->type = $this->getRequestType($internship->id);
           if($internship->type == "public"){
            $internship->id = $internship->internshipOffer->id;
           }

       });
        }catch (Throwable $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }

       return $intern;
        }


    public function getFinishedinternships($id){
        $today = Carbon::today()->toDateString();
        $intern = Intern::where([['student_id', $id],['student_validation',1],['manager_validation',1],['start_date','<', $today],['end_date', '<', $today]])
        ->with(['internship' => function ($query){
           $query->select('id','title','manager_id', 'duration',);
       },"rating","internship.manager.user","internship.manager.company" => function ($query) {
           $query->select('id','name');
       }])
       ->get();
       try{
       $intern->each(function ($intern) {
           $internship = $intern->internship;
           $internship->type = $this->getRequestType($internship->id);
           if($internship->type == "public"){
            $internship->id = $internship->internshipOffer->id;
           }
       });
        }
        catch (Throwable $e) {
        $errorMessage = $e->getMessage();
        return response()->json(['error' => $errorMessage], 500);
        }

       return $intern;
    }

    public function getAcceptedinternships($id){
        $today = Carbon::today()->toDateString();
        $intern = Intern::where([['student_id', $id],['student_validation',1],['manager_validation',1],['start_date','>', $today]])
        ->with(['internship' => function ($query) use ($today){
           $query->select('id','title','manager_id', 'duration',);
       },"internship.manager.user","internship.manager.company" => function ($query) {
           $query->select('id','name');
       }])
       ->get();
       try{
       $intern->each(function ($intern) {
           $internship = $intern->internship;
           $internship->type = $this->getRequestType($internship->id);
           if($internship->type == "public"){
            $internship->id = $internship->internshipOffer->id;
           }
       });
        }
        catch (Throwable $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }

       return $intern;
        }


    public function deleteRequest(Request $request){
        $intern = intern::find($request->id);
        $studentId = $intern->student_id;

        if ($request->type === "private") {
            $intern->delete();
            $intern->internship->delete();
        } else {
            $intern->delete();
        }

        $pending = $this->getPendingRequests($studentId);
        $accepted = $this->getAcceptedinternships($studentId);
        $finished = $this->getFinishedinternships($studentId);

        return response()->json([
            'msg' => 'request deleted successfully',
            'pending'=> $pending,
            'accepted'=> $accepted,
            'finished'=> $finished
        ]);
    }

    public function studentRefuse(Request $request){
        $intern = intern::find($request->id);
        $studentId = $intern->student_id;

        if ($request->type == "private") {
            $intern->delete();
            $intern->internship->delete();
        } else {
            $intern->delete();
        }

        $pending = $this->getPendingRequests($studentId);
        $accepted = $this->getAcceptedinternships($studentId);
        $finished = $this->getFinishedinternships($studentId);
        return response()->json([
            'msg' => 'request deleted successfully',
            'pending'=> $pending,
            'accepted'=> $accepted,
            'finished'=> $finished
        ]);
    }

    public function studentSubmition(Request $request){
        $intern = intern::find($request->id);
        // $page = $intern->internship;
        //  $page->save();
        $page = Internship::find($intern->internship_id);
        $page->update(['state' => 'ongoing']);
        $studentId = $intern->student_id;
        $intern ->update(["student_validation" => 1]);
        $pending = $this->getPendingRequests($studentId);
        $accepted = $this->getAcceptedinternships($studentId);
        $finished = $this->getFinishedinternships($studentId);
        return response()->json([
            'msg' => 'submition updated successfully',
            'pending'=> $pending,
            'accepted'=> $accepted,
            'finished'=> $finished
        ]);


    }

    public function deleteSameRequests($type,$id){
        $intern = intern::find($id);
        $studentId = $intern->student_id;
        if($intern->start_date >= "start_date" && $intern->end_date  = "end_date"  )
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
