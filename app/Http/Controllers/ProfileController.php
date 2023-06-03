<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\ProjectBox;
use App\Wishlist;

class ProfileController extends Controller
{
    public function getUser($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        if ($user->role === 'student') {
            // $projects = Intern::with('project.user:id,tagname,first_name,last_name,photo_url,email')->where([
            //     'user_id' => $user->id,
            //     'status' => 'Finished'
            // ])->latest()->get();
            $user = User::with('student', 'student.department.faculty.university')->findOrFail($user->id);

            return response()->json(
                [
                    'user' => $user,
                    // 'projects' => $projects,
                ]);
        } elseif ($user->role === 'header') {
            $user = User::with('header', 'header.department.faculty.university')->findOrFail($user->id);

            return response()->json(
                [
                    'user' => $user,
                    // 'projects' => $projects,
                ]);
        } elseif ($user->role === 'manager') {
            $user = User::with('manager', 'manager.company')->findOrFail($user->id);

            return response()->json(
                [
                    'user' => $user,
                    // 'projects' => $projects,
                ]);
        }
    }
}
