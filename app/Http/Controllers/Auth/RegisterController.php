<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Customer;
use App\HealthcareAssistant;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        //dd($data['name']);
        if($data['account_type']=='customer'){
            
            $user_id = 'CU'.mt_rand(100000,999999);

            dd($data);

            $customer = new Customer();
            $customer->name = $data['name'];
            $customer->user_id = $user_id;
            $customer->email = $data['email'];
            $customer->gender = $data['gender'];
            $customer->nic = $data['nic'];

            $filenameWithExt_image = $data['image']->getClientOriginalName();
            $filename_image = pathinfo($filenameWithExt_image, PATHINFO_FILENAME);
            $extension_image = $data['image']->getClientOriginalExtension();
            $fileNameToStore_image = $filename_image . '_' . time() . '.' . $extension_image;
            $path_image = $data['image']->storeAs('public/', $fileNameToStore_image);
            
            $customer->image = $fileNameToStore_image;
            $customer->phone = $data['phone'];
            $customer->save();

            $default_customer = [
                'user_id' => $user_id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => 'active',
                'type' => 'customer'
            ];
    
             $user = User::create($default_customer);
             return $user->assignRole(['name' => 'customer']);

        }else{


            $user_id = 'HA'.mt_rand(100000,999999);

            $assistant = new HealthcareAssistant();
            $assistant->name = $data['name'];
            $assistant->user_id = $user_id;
            $assistant->email = $data['email'];
            $assistant->phone = $data['phone'];
            $assistant->rating = 0.0;
            $assistant->ratingCount = 0;
            $assistant->status = 'active';
            $assistant->gender = $data['gender'];
            $assistant->nic = $data['nic'];
            $assistant->district = $data['district'];
            $assistant->age = $data['age'];
            $assistant->dob = $data['dob'];
            $assistant->emp_type = $data['status'];
            $assistant->description = $data['description'];

            $filenameWithExt_image = $data['image']->getClientOriginalName();
            $filename_image = pathinfo($filenameWithExt_image, PATHINFO_FILENAME);
            $extension_image = $data['image']->getClientOriginalExtension();
            $fileNameToStore_image = $filename_image . '_' . time() . '.' . $extension_image;
            $path_image = $data['image']->storeAs('public/', $fileNameToStore_image);
            
            $assistant->image = $fileNameToStore_image;
            $assistant->save();

            $default_assistant = [
                'user_id' => $user_id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => 'active',
                'type' => 'assistant'
            ];
    
            $user = User::create($default_assistant);
            return $user->assignRole(['name' => 'assistant']);
        }
        // return User::create([
        //     'user_id' => $user_id,
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        //     'status' => 'active'
        // ]);
    }
}
