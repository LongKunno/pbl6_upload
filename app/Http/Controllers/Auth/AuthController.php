<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Khachhang;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\BinaryOp\Equal;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    //Xác thực dữ liệu
    protected function validator(array $data)
    {
        $rules = [
            'name' =>'required|unique:users,name',
            'email' =>'required|unique:users,email|regex:^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})^',
            'password' => 'required|min:3|confirmed',
            'password_confirmation' =>'required|same:password',
            'txtname' =>'required|unique:khachhang,khachhang_ten',
            'txtphone' =>'required',
            'txtadr' =>'required'
        ];

        $messages = [
            'required'=> 'Vui lòng không để trống trường này!',
            'name.unique'   =>'Dữ liệu này đã tồn tại!',
            'txtname.unique'   =>'Dữ liệu này đã tồn tại!',
            'email.unique'  =>'Dữ liệu này đã tồn tại!',
            'email.regex'  =>'Email không đúng định dạng!',
            'password_confirmation.same' =>'Mật khẩu không trùng khớp!'
        ];
        //make:kiểm tra trạng thái
        return Validator::make($data,$rules,$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'loainguoidung_id' => 2,
        ]);
        // $id = DB::table('users')->select('id')->where('email',$data['email'])->first();
        // print_r($id);
        Khachhang::create([
            'khachhang_ten' => $data['txtname'],
            'khachhang_email' => $data['email'],
            'khachhang_sdt' => $data['txtphone'],
            'khachhang_dia_chi' => $data['txtadr'],
            'user_id' => $user->id,
        ]);
        return $user;
    }

    public function getLogin()
    {
        //echo "<script type='text/javascript'>alert('abc');</script>";
        //dung trong admin/login trong tuong hop nhap tk mk sai
        return view('backend.login');
        //return redirect()->route('admin.index');
    }

    public function postLogin(LoginRequest $request)
    {
        // $data = DB::table('users')->get();
		// foreach ($data as $key => $val) {
        //     if($request->username==$val->email and Hash::check($request->password,$val->password) and $val->loainguoidung_id==1)
        //     return redirect()->route('admin.index');
		// }
        
        
        // return redirect()->back();

        //======================================


        $url = 'http://192.168.216.17:8080/api/auth/authenticate';
        $data = array(
            'username' => $request->username,
            'password' => $request->password,
        );

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
            ),
            CURLOPT_RETURNTRANSFER => true
        );


        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);

        // Xử lý phản hồi từ máy chủ
        if ($response) {
            $data = json_decode($response);
            dd($data);
        } else {

        }
        return redirect()->route('admin.index');



        
        /*-----------------------------------*/ 
        /*if (Auth::attempt(['name' => $request->username, 'password' => bcrypt($request->password), 'loainguoidung_id'=>1])) {
            // Authentication passed...
            return redirect()->route('admin.index');
        }
        else {
            return redirect()->back();
        }*/
    }

    public function logout()
    {
        $data = Auth::user()->loainguoidung_id;
        /*if ($data == 2) {
            Auth::logout();
            return redirect('/');
        } else {
            Auth::logout();
            return redirect()->route('admin.login.getLogin');
        }*/
        
        Auth::logout();
        return redirect('/');
    }

}