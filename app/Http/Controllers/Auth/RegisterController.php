<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\User;
use App\Student;
use App\DepartmentHeader;
use App\InternshipManager;
use App\Company;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        validator($request->all());

        $user['role'] = $request->role;
        $user['first_name'] = $request->firstName;
        $user['family_name'] = $request->lastName;
        $user['email'] = $request->email;
        $user['password'] = bcrypt($request->password);
        $user['phone'] = $request->phoneNumber;
        $user['address'] = $request->address;
        $user['gender'] = $request->gender;

        $user = User::create($user);

        if ($request->role === 'student') {

            $student['user_id'] = $user->getKey();
            $student['student_card'] = $request->card;
            $student['security_number'] = $request->social;
            $student['birthday'] = $request->birthDate;
            $student['birth_place'] = $request->birthPlace;
            $student['department_id'] = $request->department;
            $student['speciality'] = $request->speciality;
            $student['grade'] = $request->grade;
            $student['available'] = true;

            $student = Student::create($student);
            // if ($student) {
                return response()->json($student);
            // }
        }
        elseif ($request->role === 'header') {
            $header['user_id'] = $user->getKey();
            $header['department_id'] = $request->department;

            $header = DepartmentHeader::create($header);
            if ($header) {
                return response()->json($header);
            }
        }
        else {

            $manager['user_id'] = $user->getKey();
            $manager['company_id'] = $request->company;
            $manager['validation'] = false;

            if ($request->company === 'other') {
                $company['name'] = $request->newCompany;
                $company['address'] = $request->address;
                $company = Company::create($company);

                $manager['company_id'] = $company->getKey();
            }

            $manager = InternshipManager::create($manager);
            if ($manager) {
                return response()->json($manager);
            }
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
    protected function validator(array $data)
    {
        if ($data['role'] === 'student') {
            return Validator::make($data, [
                'firstName' => 'required|max:255',
                'familyName' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
                'phone' => 'required|max:255',
                'address' => 'required|max:255',
                'gender' => 'required|max:255',
                'student_card' => 'required|max:255',
                'security_number' => 'required|max:255',
                'birthday' => 'required',
                'birth_place' => 'required|max:255',
                'speciality' => 'required|max:255',
                'grade' => 'required|max:255',
            ]);
        }
        elseif ($data['role'] === 'header') {
            return Validator::make($data, [
                'firstName' => 'required|max:255',
                'familyName' => 'max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
                'phone' => 'required|max:255',
                'address' => 'required|max:255',
                'gender' => 'required|max:255',
            ]);
        }
        else {
            return Validator::make($data, [
                'firstName' => 'required|max:255',
                'familyName' => 'max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
                'phone' => 'required|max:255',
                'address' => 'required|max:255',
                'gender' => 'required|max:255',
            ]);
        }
    }

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


// remember_token varcahar 100
// department_id
