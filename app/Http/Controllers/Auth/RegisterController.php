<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function register (Request $request)
    {
        if ($request->role === 'Student') {

            $user['role'] = $request->role;
            $user['first_name'] = $request->firstName;
            $user['last_name'] = $request->lastName;
            $user['email'] = $request->email;
            // $user['password'] = $request->password;
            $user['password'] = bcrypt($request->password);
            $user['phone_number'] = $request->phoneNumber;
            $user['address'] = $request->address;
            $user['gender'] = $request->gender;

            $user = User::create($user);


            $student['user_id'] = $user->getKey();
            $student['student_card'] = $request->card;
            $student['student_social'] = $request->social;
            $student['birth_date'] = $request->birthDate;
            $student['birth_place'] = $request->birthPlace;
            $student['university'] = $request->birthPlace;
            $student['faculty'] = $request->birthPlace;
            $student['department'] = $request->birthPlace;
            $student['speciality'] = $request->birthPlace;
            $student['speciality'] = $request->birthPlace;

            Student::create($student)
            return response()->json($user);
        }
        elseif ($request->role === 'Head') {

        }
        else {
            # code...
        }
    }
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    // protected function registered(Request $request, User $user)
    // {
    //     if ($user instanceof MustVerifyEmail) {
    //         return response()->json(['status' => trans('verification.sent')]);
    //     }

    //     return response()->json($user);
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     if ($data['role'] === 'student') {
    //         return Validator::make($data, [
    //             'firstName' => 'required|max:255',
    //             'lastName' => 'required|max:255',
    //             'email' => 'required|email|max:255|unique:users',
    //             'password' => 'required|min:6',
    //         ]);
    //     }
    //     elseif ($data['role'] === 'head') {
    //         return Validator::make($data, [
    //             'firstName' => 'required|max:255',
    //             'lastName' => 'max:255',
    //             'email' => 'required|email|max:255|unique:users',
    //             'password' => 'required|min:6',
    //         ]);
    //     }
    //     else {
    //         return Validator::make($data, [
    //             'firstName' => 'required|max:255',
    //             'lastName' => 'max:255',
    //             'email' => 'required|email|max:255|unique:users',
    //             'password' => 'required|min:6',
    //         ]);
    //     }
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role' => $data['role'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
