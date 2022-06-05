<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Promo_code;
use Illuminate\Support\Facades\Hash;
use App\Core\ReturnMessage;
use Laravel\Passport\Passport;  //import Passport here
use App\Http\Requests\RequestUserRequest;
use App\Http\Requests\RequestLoginUserRequest;

class AuthController extends Controller
{
    public function register(RequestUserRequest $request)
    {
          

        $name = $request->name;
        $password = Hash::make($request->password);
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;


        
        $reg_user = new User();
        $reg_user->name = $name;
        $reg_user->password = $password;
        $reg_user->email = $email;
        $reg_user->phone = $phone;
        $reg_user->address = $address;

        $reg_user->save();
        
        $accessToken = $reg_user->createToken('authToken')->accessToken;

       
            //to get promo_code
            $user_id = $reg_user->id;
            $data_count = Promo_code::count();
            $plus = rand (1 , 9);
            $last_id_count = $data_count + $plus;
            $id_length = strlen($last_id_count);
            $id_total_length = 6 - $id_length;
            $last_data_id = "";
            for ($i = 0; $i < $id_total_length; $i++) {
                $letter = chr(rand(65,90));
                $last_data_id .= $letter;
            }
            $last_data_id .= $last_id_count;

            $start_date               = date("Y-m-d");
            $end_date                 = date('Y-m-d', strtotime($start_date. ' + 5 days'));
            $promo_amt                = 1000;
            $created_at               = date("Y-m-d H:i:s");

        
            //generating promocode
            $promo = new Promo_code();
            $promo->code = $last_data_id;
            $promo->start_date = $start_date;
            $promo->end_date   = $end_date;
            $promo->promo_amt  = $promo_amt;
            $promo->created_by = $user_id;
            $promo->user_id = $user_id;
            $promo->save();

        
        return response(['statusCode'=>'201','message'=>'Success','user' => $reg_user,'promo_code' => $promo, 'access_token' => $accessToken], ReturnMessage::CREATED);
    }

    public function login(RequestLoginUserRequest $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['statusCode'=>'400','message' => 'This User does not exist, check your details'], ReturnMessage::BAD_REQUEST);
        }

        
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['statusCode'=>'200','message'=>'Success','user' => auth()->user(), 'access_token' => $accessToken],ReturnMessage::OK);
    }

    public function logout(Request $request)
    {
    $accessToken = auth()->logout();
    return response(['statusCode'=>'200','message' => 'You have been successfully logged out.'], ReturnMessage::OK);
    }
}