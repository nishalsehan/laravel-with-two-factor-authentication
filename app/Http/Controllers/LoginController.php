<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!isset($_SESSION))
        {
            session_start();
        }
        if($_SESSION['auth']) {
            return redirect(route('home.index'));
        }else {
            return view('auth.login');
        }
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

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $count = User::where('email','=',$request->email)->count();

        if($count == 1){

            $user = User::where('email','=',$request->email)->first();

            if(Hash::check($request->password,$user->password)){

                Alert::success('Successful', 'Verified Successfully');

                $code = mt_rand(100000, 999999);
                $contact = $user->contact;
                $to = $user->contact;

                $user = "94775928331";
                $password = "8115";
                $text = urlencode("Your verification code is ".$code);

                $baseurl ="http://www.textit.biz/sendmsg";
                $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
                $ret = file($url);

                $res= explode(":",$ret[0]);

                if (trim($res[0])=="OK")
                {
                    //echo "Message Sent - ID : ".$res[1];
                    return view('auth.two_factor',compact('contact','code'));
                }
                else
                {
                    return Redirect::back()->withErrors(['password' => 'Server Error!']);

                }


            }else{

                return Redirect::back()->withErrors(['password' => 'Authentication Fail']);

            }

        }else{

            return Redirect::back()->withErrors(['email' => 'Authentication Fail. Please check the email']);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $verification_code = $request->no_01 . $request->no_02 . $request->no_03 . $request->no_04 . $request->no_05 . $request->no_06;

        $code = $request->code;

        $contact = $request->contact;

        if($request->no_01 == '' ||$request->no_02 == '' ||$request->no_03 == '' ||$request->no_04 == '' ||$request->no_05 == '' ||$request->no_06 == ''){

            return view('auth.two_factor', compact('contact', 'code'));

        }else{
            if ($verification_code == $code) {

                if(!isset($_SESSION))
                {
                    session_start();
                }

                $_SESSION['auth'] = true;
                return redirect(route('home.index'));

            } else {

                return view('auth.two_factor', compact('contact', 'code'));

            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
