<?php

namespace App\Http\Controllers\Auth;

use App\Experience;
use App\Http\Controllers\Controller;
use App\User;
// use App\UserSkill;
use Illuminate\Support\Facades\Auth;
use App\Favorite;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function current(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'student') {

            // $projects = Project::with('user:id,tagname,first_name,last_name,photo_url,email')->where('user_id', $user->id)->latest()->get();
            $favorites = Favorite::with(['student.user:first_name,family_name,email', 'offer.internship.manager.user'])->where('student_id', $user->student()->pluck('id'))->where('status', true)->get();
            $user = User::with('student', 'student.department.faculty.university')->findOrFail($user->id);

            return response()->json(
                [
                    'user' => $user,
                    // 'projects' => $projects,
                    'favorites' => $favorites,
                ]
            );
        } elseif ($user->role === 'manager') {
            $user = User::with('manager', 'manager.company')->findOrFail($user->id);

            return response()->json(
                [
                    'user' => $user,
                ]
            );
        } else {

            $user = User::with('header', 'header.department.faculty.university')->findOrFail($user->id);

            return response()->json(
                [
                    'user' => $user,
                ]
            );
        }
    }

    public function uploadAvatar(Request $request)
    {
        $userAuth = $request->user();

        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:516',
        ]);

        if ($userAuth && $request->hasFile('file')) {
            $image = $request->file('file');
            $extension = $image->extension();
            $imgName = $this->generateRandomString(25) . '.' . $extension;
            $destinationPath = storage_path('app/public/images/avatar');
            $image->move($destinationPath, $imgName);

            if ($userAuth->photo) {
                $path = storage_path() . '/app/public/images/avatar/' . $userAuth->photo;
                if (file_exists($path)) unlink($path);
            }

            $userAuth->photo = $imgName;
            $userAuth->save();

            return response()->json([
                'message' => 'Photo has been Changed',
                'photo' => $imgName
                ]);
        }
    }

    public function deleteAvatar(Request $request)
    {
        $userAuth = $request->user();

            if ($userAuth->photo) {
                $path = storage_path() . '/app/public/images/avatar/' . $userAuth->photo;
                if (file_exists($path)) unlink($path);
            }

            $userAuth->photo = null;
            $userAuth->save();

        return response()->json([
            'message' => 'Avatar has been deleted',
            'photo' => $userAuth->photo
        ]);
    }

    public function saveProfile1(Request $request)
    {
        $userAuth = $request->user();
        $newUserData = $request->post('user');


        $userAuth->first_name = $newUserData['first_name'];
        $userAuth->family_name = $newUserData['family_name'];
        $userAuth->address = $newUserData['address'];
        $userAuth->phone = $newUserData['phone'];
        $userAuth->biography = $newUserData['biography'];
        $userAuth->github = $newUserData['github'];
        $userAuth->linkedin = $newUserData['linkedin'];

        $userAuth->save();

        $user = User::with('student', 'student.department.faculty.university')->findOrFail($userAuth->id);
        // $user = User::with(['skills', 'experiences'])->findOrFail($userAuth->id);

        return response()->json([
            'message' => 'Profile has been updated',
            'user' => $user
        ]);
    }

    public function saveProfile2(Request $request)
    {
        $userAuth = $request->user();
        $newUserData = $request->post('user');
        // if ($newUserData['is_open_hired'] === 'false') $newUserData['is_open_hired'] = false;
        // else $newUserData['is_open_hired'] = true;

        $userAuth->expertise = $newUserData['expertise'];
        $userAuth->is_open_hired = $newUserData['is_open_hired'];
        $userAuth->save();

        $skills = $newUserData['skills'];
        $experiences = $newUserData['experiences'];

        for ($i = 0; $i < count($skills); $i++) {
            $skills[$i]['user_id'] = $userAuth->id;
        }

        for ($i = 0; $i < count($experiences); $i++) {
            $experiences[$i]['start_date'] = Carbon::createFromFormat('Y-m-d\TH:i:s+',  $experiences[$i]['start_date']);
            $experiences[$i]['end_date'] = Carbon::createFromFormat('Y-m-d\TH:i:s+',  $experiences[$i]['end_date']);
            $experiences[$i]['user_id'] = $userAuth->id;
        }

        // return response()->json($experiences);

        UserSkill::where('user_id', $userAuth->id)->delete();
        UserSkill::insert($skills);

        Experience::where('user_id', $userAuth->id)->delete();
        Experience::insert($experiences);

        $user = User::with(['skills', 'experiences'])->findOrFail($userAuth->id);

        return response()->json([
            'message' => 'Profile has been updated',
            'user' => $user
        ]);
    }

    public function uploadCV(Request $request)
    {
        $userAuth = Auth::user();
        $student = $userAuth->student;

        $this->validate($request, [
            'file' => 'required|mimetypes:application/pdf|max:1024',
        ]);

        if ($userAuth && $request->hasFile('file')) {
            $image = $request->file('file');
            $extension = $image->extension();
            $imgName = $this->generateRandomString(25) . '.' . $extension;
            $destinationPath = storage_path('app/public/images/cv');
            $image->move($destinationPath, $imgName);

            if ($userAuth->cv) {
                $path = storage_path() . '/app/public/images/cv/' . $student->cv;
                if (file_exists($path)) unlink($path);
            }

            $student->cv = $imgName;
            $student->save();

            return response()->json([
                'message' => 'CV has been Changed',
                'cv' => $student->cv
                ]);
        }
    }

    public function deleteCV(Request $request)
    {
        $userAuth = Auth::user();
        $student = $userAuth->student;

            if ($student->cv) {
                $path = storage_path() . '/app/public/images/cv/' . $student->cv;
                if (file_exists($path)) unlink($path);
            }

            $student->cv = null;
            $student->save();

        return response()->json([
            'message' => 'CV has been deleted',
            'cv' => $student->cv
        ]);
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
