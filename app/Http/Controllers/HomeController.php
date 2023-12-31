<?php

namespace App\Http\Controllers;

use App\Http\Requests;
// use Illuminate\Http\Request;
use Illuminate\Http\Request as RequestAPI;
use DB,Cart,Request,Mail;
use App\Donhang;
use App\Binhluan;
use App\Chitietdonhang;
use App\Http\Requests\ThanhtoanRequest;
use App\Http\Requests\BinhluanRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Request as RequestsRequest;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Psy\Util\Json;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function send_data_address_token($postData,$url,$phuongthuc){
        // Tạo một yêu cầu mới
            $headers = array(
            'Token: c61b8d62-a18d-11ee-a6e6-e60958111f48',
            'Content-Type: application/json'
        );
        $postData = json_encode($postData);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $phuongthuc);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // Thực hiện yêu cầu POST
        $response = curl_exec($ch);
        // Kiểm tra lỗi
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            dd($error);
        }
        // Đóng kết nối cURL
        curl_close($ch);
        return json_decode($response);
    }

    public function send_data_access_token($postData,$url,$phuongthuc){
        if (request()->hasCookie('access_token')) {
            // Tạo một yêu cầu mới
             $headers = array(
                'Authorization: Bearer ' .request()->cookie('access_token'),
                'Content-Type: application/json'
            );
            $postData = json_encode($postData);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $phuongthuc);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            // Thực hiện yêu cầu POST
            $response = curl_exec($ch);
            // Kiểm tra lỗi
            if (curl_errno($ch)) {
                $error = curl_error($ch);
                dd($error);
            }
            // Đóng kết nối cURL
            curl_close($ch);
            return json_decode($response);
        } else {
            dd("vui lòng đăng nhập");
        }
    }

    public function send_data_no_access_token($postData,$url,$phuongthuc){
        $postData = json_encode($postData);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $phuongthuc);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // Thực hiện yêu cầu POST
        $response = curl_exec($ch);
        // Kiểm tra lỗi
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            dd($error);
        }
        // Đóng kết nối cURL
        curl_close($ch);
        return json_decode($response);
    }


















    public function login(){
        return view('auth.login'); 
    }

    // public function isAuthenticated()
    // {
    //     if (request()->hasCookie('access_token')) {
    //         // Access token đã được lưu trong cookie
    //         return true;
    //     } else {
    //         // Access token không tồn tại trong cookie
    //         return false;
    //     }
    // }

    public function logout()
    {
        // Xóa cookie
        return redirect()->to('/')
        ->withCookie(cookie()->forget('access_token'))
        ->withCookie(cookie()->forget('user_id'))
        ->withCookie(cookie()->forget('refresh_token'))
        ->withCookie(cookie()->forget('fullName'));
    }


    public function postLogin(Request $request)
    {
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/auth/authenticate';
        $data = array(
            'username' => Request::input('username'),
            'password' => Request::input('password'),
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
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($curl);
        curl_close($curl);
        // Xử lý phản hồi từ máy chủ
        if ($response) {
            $data = json_decode($response);
            if(isset($data->accessToken)){
                $cookie_access_token = cookie('access_token', $data->accessToken, 60);
                $cookie_fullName = cookie('fullName', $data->fullName, 60);
                $cookie_user_id = cookie('user_id', $data->id, 60);
                $cookie_refresh_token = cookie('refresh_token', $data->refreshToken, 60);
                return redirect()->to('/')
                ->withCookie($cookie_access_token)
                ->withCookie($cookie_user_id)
                ->withCookie($cookie_refresh_token)
                ->withCookie($cookie_fullName);
            }
            else{
                echo "<script>alert('Tài khoản hoặc mặt khẩu không đúng!');</script>";
                return view('auth.login');
            }
            
        } else {
            echo "<script>alert('Không nhận được phản hổi từ máy chủ!');</script>";
            return view('auth.login');
        }
    }

    public function getregister()
    {
        return view('auth.register');
    }

    public function postregister(Request $request)
    {
        $username = Request::input('name');
        $name = Request::input('txtname');
        $email = Request::input('email');
        $password = Request::input('password');
        $password_confirmation = Request::input('password_confirmation');

        # valid
        if(empty($username)){
            $error = "Vui lòng nhập Tên đăng nhập!";
            return view('auth.register',compact('error'));
        }
        if(empty($email)){
            $error = "Vui lòng nhập Email!";
            return view('auth.register',compact('error'));
        }
        if(empty($name)){
            $error = "Vui lòng nhập Tên khách hàng!";
            return view('auth.register',compact('error'));
        }
        if(empty($password)){
            $error = "Vui lòng nhập Mật khẩu!";
            return view('auth.register',compact('error'));
        }
        if(empty($password_confirmation)){
            $error = "Vui lòng nhập Mật khẩu xác nhận!";
            return view('auth.register',compact('error'));
        }
        if($password != $password_confirmation){
            $error = "Mật khẩu xác nhận không chính xác!";
            return view('auth.register',compact('error'));
        }
                
        # Send data
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/auth/register';
        $data = array(
            'email' => $email,
            'username' => $username,
            'name' => $name,
            'password' => $password,
        );
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
            ),
            CURLOPT_RETURNTRANSFER => true,
        );
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($curl);
        curl_close($curl);
        // Xử lý phản hồi từ máy chủ
        if ($response) {
            $data = json_decode($response);

            if(isset($data->accessToken)){
                $cookie_access_token = cookie('access_token', $data->accessToken, 60);
                $cookie_fullName = cookie('fullName', $data->fullName, 60);
                $cookie_user_id = cookie('user_id', $data->id, 60);
                $cookie_refresh_token = cookie('refresh_token', $data->refreshToken, 60);
                echo "<script>alert('Đăng kí tài khoản thành công!');</script>";
                    return redirect()->to('/')
                    ->withCookie($cookie_access_token)
                    ->withCookie($cookie_user_id)
                    ->withCookie($cookie_refresh_token)
                    ->withCookie($cookie_fullName);
            }
            else{
                echo "<script>alert('".$data->error->message."!');</script>";
                return view('auth.register');
            }
            
        } else {
            echo "<script>alert('Không nhận được phản hồi từ server!');</script>";
                return view('auth.register');
        }
    }



    public function forgotpassword()
    {
        return view('auth.forgotpassword');
    }

    public function postforgotpassword(Request $request)
    {
        $username = Request::input('username');
        # valid
        if(empty($username)){
            $error = "Vui lòng nhập Tên đăng nhập!";
            return view('auth.forgotpassword',compact('error'));
        }
        # Send data
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/auth/forgot-password?username='.$username;
        $data = array(
            'username' => $username,
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
        $data  = json_decode($response);
        if (!isset($data->status)) {
            return view('forgot-password-otp');
        } else {
            dd("error: post Register!");
        }
    }

    public function forgot_password_otp(){
        return view('forgot-password-otp');
    }

    public function get_update_imformation(){
        $user_id=request()->cookie('user_id');
        $postData = array(
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/users/'.$user_id;
        $user_info = $this->send_data_access_token($postData,$url,"GET");
        return view('auth.imformation',compact('user_info'));
    }

    public function post_update_imformation(Request $request){
        $user_id=request()->cookie('user_id');
        $postData = array(
            'user_id' => $user_id,
            'username' => Request::input("info_username"),
            'name' => Request::input("info_name"),
            'urlImage' => Request::input("info_urlImage"),
            'address' => Request::input("info_address"),
            'gender' => Request::input("info_gender"),
            'birthday' => Request::input("info_birthday"),
            'phoneNumber' => Request::input("info_phoneNumber"),
            'gmail' => Request::input("info_gmail"),
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/users/'.$user_id;
        $user_info = $this->send_data_access_token($postData,$url,"PUT");
        echo "<script>alert('Cập nhật thông tin thành công!');</script>";
        return view('auth.imformation',compact('user_info'));
    }

    public function index()
    {
        $postData = array();
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/home/12';
        $data = $this->send_data_no_access_token($postData,$api_url,"GET");

        return view('frontend.pages.home',compact('data'));
    }

    public function group($url_id)
    { 
        $page = Request::input('page', 1);
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/getByCategory';
        $api_url = $api_url."?category_id=".$url_id."&page=".$page."&pageSize=9";

        $postData = array();
        $data = $this->send_data_no_access_token($postData,$api_url,"GET");



        $sanpham = $data->items;

        return view('frontend.pages.group',compact('data','sanpham'));
    }


    public function cates($id_category,$id_brand)
    {

        $page = Request::input('page', 1);
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/getByCategory';
        $api_url = $api_url."?brand_id=".$id_brand."&category_id=".$id_category."&page=".$page."&pageSize=9";

        $postData = array();
        $data = $this->send_data_no_access_token($postData,$api_url,"GET");

        $sanpham = $data->items;

        return view('frontend.pages.cates',compact('data','sanpham'));
    }

    public function thongtin()
    {
        $thongtin = DB::table('thongtin')->paginate(9);

        return view('frontend.pages.thongtins',compact('thongtin'));
    }

    public function detailthongtin($url)
    {
        $thongtin = DB::table('thongtin')->where('thongtin_url',$url)->first();
        $id = DB::table('thongtin')->select('id')->where('thongtin_url',$url)->first();
        $id = $id->id;
        $nglieu = DB::table('nguyenlieu')->where('thongtin_id',$id)->get(); 

        return view ('frontend.pages.detailthongtin',compact('thongtin','nglieu'));
    }

    public function getContact()
    {
        return view('frontend.pages.contact');
    }

    public function postContact(Request $request)
    {
        $data = ['mail'=>Request::input('txtMail'),'name'=>Request::input('txtName'),'content'=>Request::input('txtContent')];
        Mail::send('auth.emails.layoutmail', $data, function ($message) {
            $message->from('long@gmail.com', 'Khách hàng');
        
            $message->to('long@gmail.com', 'Admin');
        
            $message->subject('Mail liên hệ!!!');
        });

        echo "<script>
         alert('Cảm ơn bạn đã góp ý! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất');
         window.location='".url('/')."'
        </script>";
    }

    public function promotions()
    {
        // $khuyenmai = DB::table('khuyenmai')->where('khuyenmai_tinh_trang',1)->first();
        // if (!is_null($khuyenmai)) {
        //     $spham = DB::table('sanphamkhuyenmai')
        //     ->where('khuyenmai_id',$khuyenmai->id)
        //     ->get();
        // } else {
        //     $spham = Null;
        // }

        $list_khuyen_mai = [];

        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/promotion';
        $postData = array();
        $khuyenmai = $this->send_data_no_access_token($postData,$api_url,"GET");

        foreach($khuyenmai as $km){
            $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/promotion/detail/'.$km->id;
            $postData = array();
            $spham = $this->send_data_no_access_token($postData,$api_url,"GET");
            $list_khuyen_mai[] = $spham;

        }


        return view('frontend.pages.promotion',compact('list_khuyen_mai'));
    }

    public function detailpromotions($url)
    {
        $khuyenmai = DB::table('khuyenmai')->where('khuyenmai_url',$url)->first();
        $id = DB::table('khuyenmai')->select('id')->where('khuyenmai_url',$url)->first();
        $id = $id->id;
        $spham = DB::table('sanphamkhuyenmai')
            ->where('khuyenmai_id',$id)
            ->get();
        return view ('frontend.pages.detailpromotion',compact('khuyenmai','spham'));
    }

    public function career()
    {
        $tuyendung = DB::table('tuyendung')->where('tuyendung_tinh_trang',1)->first();
        return view('frontend.pages.career',compact('tuyendung'));
    }

    public function product($url_id)
    {
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/detail/'.$url_id;
        $postData = array();
        $data = $this->send_data_no_access_token($postData,$api_url,"GET");
        
        //========== size ============
        $size = [
                    ['id' => 1, 'name' => 'S'],
                    ['id' => 2, 'name' => 'M'],
                    ['id' => 3, 'name' => 'L'],
                    ['id' => 4, 'name' => 'XL'],
                    ['id' => 5, 'name' => 'XXL']
                ];

        return view('frontend.pages.detailpro',compact('data',"size"));
    }

    public function orderpage(Request $request){
        $state = Request::get('state');
        if($state==1){
            return view('frontend.pages.success');
        }else{
            return view('frontend.pages.fail');
        }
        
    }

    public function buyding(Request $request,$id,$size)
    {
        $user_id=request()->cookie('user_id');
        // Xoá sản hết phẩm
        // $postData = array("userId"=> $user_id);
        // $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id."/clean";
        // $data = $this->send_data_access_token($postData,$url,"DELETE");
        $size="S";
        if(!is_null(Request::input("size"))){
            $size = Request::input("size");
        }

        // add sản phẩm vào giỏ hàng
        $postData = array(
                "quantity"=> 1,
                "productId"=> $id,
                "size"=> $size,
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id;
        $data = $this->send_data_access_token($postData,$url,"POST");
    
        return redirect()->route('giohang');
    }

    public function cart()
    {
        $user_id=request()->cookie('user_id');
        // Lấy sản phẩm của giỏ hàng
        $postData = array(
                "userId"=> $user_id
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id;
        $data = $this->send_data_access_token($postData,$url,"GET");

        // data test
        $total = 0;
                //========== size ============
        $size = [
                    ['id' => 1, 'name' => 'S'],
                    ['id' => 2, 'name' => 'M'],
                    ['id' => 3, 'name' => 'L'],
                    ['id' => 4, 'name' => 'XL'],
                    ['id' => 5, 'name' => 'XXL']
        ];

        return view('frontend.pages.cart',compact('data','total','size'));
    }

    public function deleteProduct($id)
    {
        $user_id=request()->cookie('user_id');
        // Xoá sản phẩm của giỏ hàng
        $postData = array(
                $id
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id."?userId=".$user_id;
        $data = $this->send_data_access_token($postData,$url,"DELETE");
        return redirect()->route('giohang');
    }

    public function updateProduct(Request $request,$id)
    {
        $size_ex = [
                    ['id' => 1, 'name' => 'S'],
                    ['id' => 2, 'name' => 'M'],
                    ['id' => 3, 'name' => 'L'],
                    ['id' => 4, 'name' => 'XL'],
                    ['id' => 5, 'name' => 'XXL']
        ]; 

        $data = json_decode($_COOKIE["data_update_cart"]);
        $id = $data->id;
        $size_id = $data->size;
        $size = "S";
        foreach ($size_ex as $item) {
            if ($item['id'] == $size_id) {
                $size = $item['name'];
            }
        }
        $quantity = $data->quantity;
        $user_id=request()->cookie('user_id');
        // cập  nhật sản phẩm của giỏ hàng
        $postData = array(
                "id"=> $id,
                "quantity"=> $quantity,
                "size"=> $size
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id."/".$id;
        $data = $this->send_data_access_token($postData,$url,"PUT");
        return redirect()->route('giohang');
    }

    public function getCheckin()
    {
        $user_id=request()->cookie('user_id');
        $postData = array();
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/users/'.$user_id;
        $khachhang = $this->send_data_access_token($postData,$url,"GET");

        # Lấy sản phẩm từ giỏ hàng và giữ lại những sp có trong cok
        $array_id_sp = json_decode($_COOKIE['selectedCheckboxValues']);
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id;
        $sanpham = $this->send_data_access_token($postData,$url,"GET");
        $sanpham = array_filter($sanpham, function($item) use ($array_id_sp) {
            return in_array($item->id, $array_id_sp);
        });

        $url = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province';
        $response = $this->send_data_address_token($postData,$url,"POST");
        $thanhpho = $response->data;
        foreach ($thanhpho as $key => $val) {
            $list_thanhpho[] = ['id' => $val->ProvinceID, 'name'=> $val->ProvinceName];
        }
        

        $list_giamgia = [];
        $list_freeship = [];
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/vouchers?active=true';
        $response = $this->send_data_address_token($postData,$url,"GET");
        $data = $response->content;

        foreach ($data as $key => $val) {
            if($val->voucherType=="FREE_SHIP")
                $list_freeship[] = ['id' => $val->id, 'name'=> $val->description];
            if($val->voucherType=="PURCHASE")
                $list_giamgia[] = ['id' => $val->id, 'name'=> $val->description];
        }

        $list_quan=[];
        $list_phuong=[];

        $total = 0;


        return view('frontend.pages.checkin',compact('khachhang','sanpham','total','list_thanhpho','list_quan','list_phuong','list_giamgia','list_freeship'));
    }

    public function postCheckin(Request $request)
    {
        $user_id=request()->cookie('user_id');

        # Lấy sản phẩm từ giỏ hàng và giữ lại những sp có trong cok
        $postData = [];
        $array_id_sp = json_decode($_COOKIE['selectedCheckboxValues']);
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id;
        $sanpham = $this->send_data_access_token($postData,$url,"GET");
        $sanpham = array_filter($sanpham, function($item) use ($array_id_sp) {
            return in_array($item->id, $array_id_sp);
        });

        $orderStatus = "UNCONFIRMED";
        $paymentMethod = Request::get('select_thanhtoan');
        $shippingAddress = Request::get('shippingAddress');
        $phoneNumber = Request::get('txtNNPhone');
        $note = Request::get('note');
        $name = Request::get('txtNNName');
        $totalPayment = Request::get('totalPayment');
        $totalProductAmount = Request::get('totalProductAmount');
        $shippingFee = Request::get('shippingFee');
        $discountAmount = Request::get('discountAmount');
        $discountShippingFee = Request::get('discountShippingFee');

        $idsVoucher=[];
        $voucher_freeship = Request::get('select_giamgiavanchuyen');
        $voucher_giamgia = Request::get('select_giamgiasanpham');
        if($voucher_freeship!=""){
            $idsVoucher[]=$voucher_freeship;
        }
        if($voucher_giamgia!=""){
            $idsVoucher[]=$voucher_giamgia;
        }

        $orderItems = $sanpham;
        $wardCode = Request::get('select_phuong');
        $districtId = Request::get('select_quan');



        $postData = array(
            "orderStatus" => $orderStatus,
            "paymentMethod"=> $paymentMethod,
            "name"=> $name,
            "shippingAddress"=> $shippingAddress,
            "phoneNumber"=> $phoneNumber,
            "note"=> $note,
            "totalPayment"=> $totalPayment,
            "totalProductAmount"=> $totalProductAmount,
            "shippingFee"=> $shippingFee,
            "discountAmount"=> $discountAmount,
            "discountShippingFee"=> $discountShippingFee,
            "idsVoucher"=> $idsVoucher,
            "orderItems"=> $orderItems,
            "userId"=> $user_id,
            "wardCode"=> $wardCode,
            "districtId"=> $districtId,

        );

        $url = 'https://pbl6shopfashion-production.up.railway.app/api/orders';
        $response = $this->send_data_access_token($postData,$url,"POST");
        
        
        echo "<script>
          alert('Bạn đã đặt mua sản phẩm thành công!');
          window.location = '".$response->urlPayment."';</script>";
    }

    public function postComment(Request $request)
    {
        dd("đang phát triển");
        $user_id=request()->cookie('user_id');
        // $binhluan_ten = $request->txtName;
        // $binhluan_email = $request->txtEmail;
        $binhluan_noi_dung = Request::get("txtContent");
        // $binhluan_trang_thai = 0;
        $sanpham_id = Request::get("txtID");
        $rate = 5;
        // post comment
        $postData = array();
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/comment?rate='.$rate.'&userId='.$user_id.'&productId='.(int)$sanpham_id.'&orderItemId='.$orderItemId.'&content='.$binhluan_noi_dung;
        $data = $this->send_data_access_token($postData,$url,"POST");
        dd($data);
        
        
        
         echo "<script>
          alert('Cảm ơn bạn đã góp ý!');
          window.location = '".url('/')."';</script>";
    }

    public function getFind()
    {

        return view('frontend.pages.product');
    }

    public function postFind()
    {
        $keyword = Request::input('txtSeach');
        // $keyword = Request::input('txtSeach');
        // $sanpham = DB::table('sanpham')
        //     ->where('sanpham_ten','like','%'.$keyword.'%')
        //     ->orWhere('sanpham_url','like','%'.$keyword.'%')
        //     ->join('lohang', 'sanpham.id', '=', 'lohang.sanpham_id')
        //     ->select(DB::raw('max(lohang.id) as lomoi'),'sanpham.id','sanpham.sanpham_ten','sanpham.sanpham_url','sanpham.sanpham_khuyenmai','sanpham.sanpham_anh', 'lohang.lohang_so_luong_nhap','lohang.lohang_so_luong_hien_tai','lohang.lohang_gia_ban_ra')
        //         ->groupBy('sanpham.id')
        //     ->paginate(5);

        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/searchAll';
        $api_url = $api_url."?keyword=".$keyword."&page=1"."&pageSize=999";
        $postData = array();
        $data = $this->send_data_access_token($postData,$api_url,"GET");
        return view('frontend.pages.product',compact('data'));
    }
 
    // ===========================================================================================================================================================================

    // public function index()
    // {
    //     // $loaisp =  DB::table('loaisanpham')->get();
    //     // $sanpham = DB::table('sanpham')
    //     //     ->join('lohang', 'sanpham.id', '=', 'lohang.sanpham_id')
    //     //     ->select(DB::raw('max(lohang.id) as lomoi'),'sanpham.id','sanpham.sanpham_ten','sanpham.sanpham_url','sanpham.sanpham_khuyenmai','sanpham.sanpham_anh', 'lohang.lohang_so_luong_nhap','lohang.lohang_so_luong_hien_tai','lohang.lohang_gia_ban_ra')
    //     //         ->groupBy('sanpham.id')
    //     //         ->orderBy('id','DESC')
    //     //     ->paginate(12);
    //     // // print_r($loaisp);
    //     // return view ('frontend.pages.home',compact('loaisp','sanpham'));
    //     $response = file_get_contents('http://localhost/pbl6/api');
    //     $data = json_decode($response);
    //     $sanpham = $data->sanpham; 
    //     $loaisp = $data->loaisp;
    //     return view ('frontend.pages.home',compact('loaisp','sanpham'));
    // }
    // public function group($url)
    // {
    //     $id = DB::table('nhom')->select('id')->where('nhom_url',$url)->first();
    //     $i = $id->id;
    //     $id = DB::table('loaisanpham')->select('id')->where('nhom_id',$i)->get();
    //     foreach ($id as $key => $val) {
    //         $ids[] = $val->id;
    //     }
    //     $nhom = DB::table('nhom')->where('id',$i)->first();
    //     $sanpham = DB::table('sanpham')
    //         ->whereIn('sanpham.loaisanpham_id',$ids)
    //         ->join('lohang', 'sanpham.id', '=', 'lohang.sanpham_id')
    //         ->select(DB::raw('max(lohang.id) as lomoi'),'sanpham.id','sanpham.sanpham_ten','sanpham.sanpham_url','sanpham.sanpham_khuyenmai','sanpham.sanpham_anh', 'lohang.lohang_so_luong_nhap','lohang.lohang_so_luong_hien_tai','lohang.lohang_gia_ban_ra')
    //         ->groupBy('sanpham.id')
    //         ->paginate(15);
    //     return view('frontend.pages.group',compact('sanpham','nhom'));
    // }

    // public function cates($url)
    // {
    //     $idLSP = DB::table('loaisanpham')->select('id')->where('loaisanpham_url',$url)->first();
    //     $i = $idLSP->id;
    //     $loaisanpham = DB::table('loaisanpham')->where('id',$i)->first();
    //     $sanpham = DB::table('sanpham')
    //         ->where('sanpham.loaisanpham_id',$i)
    //         ->join('lohang', 'sanpham.id', '=', 'lohang.sanpham_id')
    //         ->select(DB::raw('max(lohang.id) as lomoi'),'sanpham.id','sanpham.sanpham_ten','sanpham.sanpham_url','sanpham.sanpham_khuyenmai','sanpham.sanpham_anh', 'lohang.lohang_so_luong_nhap','lohang.lohang_so_luong_hien_tai','lohang.lohang_gia_ban_ra')
    //             ->groupBy('sanpham.id')
    //         ->paginate(15);
    //     $nhom = DB::table('nhom')->where('id',$loaisanpham->nhom_id)->first();
    //     return view('frontend.pages.cates',compact('sanpham','loaisanpham','nhom'));
    // }

    // public function thongtin()
    // {
    //     $thongtin = DB::table('thongtin')->paginate(9);
    //     return view ('frontend.pages.thongtins',compact('thongtin'));
    // }

    // public function detailthongtin($url)
    // {
    //     $thongtin = DB::table('thongtin')->where('thongtin_url',$url)->first();
    //     $id = DB::table('thongtin')->select('id')->where('thongtin_url',$url)->first();
    //     $id = $id->id;
    //     // print_r($i);
    //     $nglieu = DB::table('nguyenlieu')->where('thongtin_id',$id)->get();
    //     // print_r($nglieu);
    //     return view ('frontend.pages.detailthongtin',compact('thongtin','nglieu'));
    // }

    // public function getContact()
    // {
    //     return view ('frontend.pages.contact');
    // }

    // public function postContact(Request $request)
    // {
    //     $data = ['mail'=>Request::input('txtMail'),'name'=>Request::input('txtName'),'content'=>Request::input('txtContent')];
    //     Mail::send('auth.emails.layoutmail', $data, function ($message) {
    //         $message->from('long@gmail.com', 'Khách hàng');
        
    //         $message->to('long@gmail.com', 'Admin');
        
    //         $message->subject('Mail liên hệ!!!');
    //     });

    //     echo "<script>
    //      alert('Cảm ơn bạn đã góp ý! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất');
    //      window.location='".url('/')."'
    //     </script>";
    // }

    // public function promotions()
    // {
    //     $khuyenmai = DB::table('khuyenmai')->where('khuyenmai_tinh_trang',1)->first();
    //     if (!is_null($khuyenmai)) {
    //         $spham = DB::table('sanphamkhuyenmai')
    //         ->where('khuyenmai_id',$khuyenmai->id)
    //         ->get();
    //     } else {
    //         $spham = Null;
    //     }
    //     // print_r($km_old);
    //     return view ('frontend.pages.promotion',compact('khuyenmai','spham'));
    // }

    // public function detailpromotions($url)
    // {
    //     $khuyenmai = DB::table('khuyenmai')->where('khuyenmai_url',$url)->first();
    //     $id = DB::table('khuyenmai')->select('id')->where('khuyenmai_url',$url)->first();
    //     $id = $id->id;
    //     // print_r($i);
    //     $spham = DB::table('sanphamkhuyenmai')
    //         ->where('khuyenmai_id',$id)
    //         ->get();
    //     //$spham = DB::table('sanpham')->whereIn('id',$sphamid)->get();
    //     //print_r($spham);
    //     return view ('frontend.pages.detailpromotion',compact('khuyenmai','spham'));
    // }

    // public function career()
    // {
    //     $tuyendung = DB::table('tuyendung')->where('tuyendung_tinh_trang',1)->first();
    //     // print_r($tuyendung);
    //     return view('frontend.pages.career',compact('tuyendung'));
    // }

    // public function product($url)
    // {
    //     $idLSP = DB::table('sanpham')->select('id')->where('sanpham_url',$url)->first();
    //     $id = $idLSP->id;
    //     $sanpham = DB::table('sanpham')
    //         ->where('sanpham.id',$id)
    //         ->join('lohang', 'sanpham.id', '=', 'lohang.sanpham_id')
    //         ->join('donvitinh','sanpham.donvitinh_id', '=', 'donvitinh.id' )
    //         ->join('loaisanpham','sanpham.loaisanpham_id' , '=', 'loaisanpham.id')
    //         ->select(DB::raw('max(lohang.id) as lomoi'),'sanpham.id','sanpham.sanpham_ten','sanpham.sanpham_url','sanpham.sanpham_khuyenmai','sanpham.sanpham_anh', 'lohang.lohang_so_luong_nhap','lohang.lohang_so_luong_hien_tai','lohang.lohang_gia_ban_ra','donvitinh.donvitinh_ten','loaisanpham.loaisanpham_ten','sanpham.loaisanpham_id','sanpham.sanpham_anh','sanpham.sanpham_mo_ta')
    //         ->groupBy('sanpham.id')
    //         ->first();
        
    //     $hinhsanpham = DB::table('hinhsanpham')->where('sanpham_id',$id)->get();
    //     $loaisanpham = DB::table('loaisanpham')->where('id',$sanpham->loaisanpham_id)->first();
    //     $nhom = DB::table('nhom')->where('id',$loaisanpham->nhom_id)->first();
    //     $binhluan = DB::table('binhluan')->where([['sanpham_id',$id],['binhluan_trang_thai',1],])->get();
    //     return view('frontend.pages.detailpro',compact('sanpham','hinhsanpham','loaisanpham','nhom','binhluan'));
    //     // print_r($loaisanpham);
    // }

    // public function buyding(Request $request,$id)
    // {
    //     // print_r($id);
    //     $sanpham = DB::select('select * from sanpham where id = ?',[$id]);
    //     // print_r($sanpham);
    //     if ($sanpham[0]->sanpham_khuyenmai == 1) {
    //         $muasanpham = DB::select('select sp.id,sp.sanpham_ten,lh.lohang_ky_hieu, lh.lohang_gia_ban_ra, sp.id, km.khuyenmai_phan_tram from sanpham as sp, lohang as lh, voucher as ncc, sanphamkhuyenmai as spkm, khuyenmai as km  where km.khuyenmai_tinh_trang = 1 and sp.id = spkm.sanpham_id and spkm.khuyenmai_id = km.id and ncc.id = lh.voucher_id and lh.sanpham_id = sp.id and sp.id = ?', [$id]);
    //         $giakm = $muasanpham[0]->lohang_gia_ban_ra - $muasanpham[0]->lohang_gia_ban_ra*$muasanpham[0]->khuyenmai_phan_tram*0.01;
    //         print_r($giakm);
    //         Cart::add(array( 'id' => $muasanpham[0]->id, 'name' => $muasanpham[0]->sanpham_ten, 'qty' => 1, 'price' => $giakm));
    //     } else {
    //         $muasanpham = DB::select('select sp.id,sp.sanpham_ten,lh.lohang_ky_hieu, lh.lohang_gia_ban_ra from sanpham as sp, lohang as lh, voucher as ncc  where ncc.id = lh.voucher_id and lh.sanpham_id = sp.id and sp.id = ?',[$id]);
    //         $gia = $muasanpham[0]->lohang_gia_ban_ra;
    //         Cart::add(array( 'id' => $muasanpham[0]->id, 'name' => $muasanpham[0]->sanpham_ten, 'qty' => 1, 'price' => $gia));
    //     }
    //     $content = Cart::content();
    //     // print_r($content);
    //     return redirect()->route('giohang');
    // }

    // public function cart()
    // {
    //     $content = Cart::content();
    //   
    //     $total = Cart::total();
    //     return view('frontend.pages.cart',compact('content','total'));
    // }

    // public function deleteProduct($id)
    // {
    //     Cart::remove($id);
    //     return redirect()->route('giohang');
    // }

    // public function updateProduct()
    // {
    //     if(Request::ajax()) {
    //         $id = Request::get('id');
    //         $qty = Request::get('qty');
    //         Cart::update($id,$qty);
    //         echo "oke";
    //     }
    // }

    // public function getCheckin()
    // {
    //     $content = Cart::content();
    //     // print_r($content);
    //     $total = Cart::total();
    //     // echo "string";
    //     // print_r($total);
    //     return view('frontend.pages.checkin',compact('content','total'));
    // }

    // public function postCheckin(ThanhtoanRequest $request)
    // {
    //     $content = Cart::content();
    //     $total = Cart::total();

    //     $donhang = new Donhang;
    //     $donhang->donhang_nguoi_nhan = $request->txtNNName;
    //     $donhang->donhang_nguoi_nhan_email = $request->txtNNEmail;
    //     $donhang->donhang_nguoi_nhan_sdt = $request->txtNNPhone;
    //     $donhang->donhang_nguoi_nhan_dia_chi = $request->txtNNAddr;
    //     $donhang->donhang_ghi_chu = $request->txtNNNote;
    //     $donhang->donhang_tong_tien = $total;
    //     $donhang->khachhang_id = $request->txtKHID;
    //     $donhang->tinhtranghd_id = 1;
    //     $donhang->save();

    //     foreach ($content as $item) {
    //         $detail = new Chitietdonhang;
    //         $detail->sanpham_id = $item->id;
    //         $detail->donhang_id = $donhang->id;
    //         $detail->chitietdonhang_so_luong = $item->qty;
    //         $detail->chitietdonhang_thanh_tien = $item->price*$item->qty;
    //         $detail->save();
    //     }
    //     $kh = DB::table('khachhang')->where('id', $request->txtKHID)->first();
    //     // print_r($kh);
    //     $donhang = [
    //         'id'=> $donhang->id,
    //         'donhang_nguoi_nhan'=> $request->txtNNName,
    //         'donhang_nguoi_nhan_email' => $request->txtNNEmail,
    //         'donhang_nguoi_nhan_sdt' => $request->txtNNPhone,
    //         'donhang_nguoi_nhan_dia_chi' => $request->txtNNAddr,
    //         'donhang_ghi_chu' => $request->txtNNNote,
    //         'donhang_tong_tien' => $total,
    //         'khachhang_id' => $request->txtKHID,
    //         'khachhang_email'=>$kh->khachhang_email,
    //         ];
    //     // print_r($donhang);
    //     Mail::send('auth.emails.hoadon', $donhang, function ($message) use ($donhang) {
    //         $message->from('long@gmail.com', 'ADMIN');
        
    //         $message->to($donhang['khachhang_email'], 'a');
        
    //         $message->subject('Hóa đơn mua hàng tại Shop Giày Đà Nẵng!!!');
    //     });

    //     Mail::send('auth.emails.hoadon', $donhang, function ($message) use ($donhang) {
    //         $message->from('long@gmail.com', 'ADMIN');
        
    //         $message->to('long@gmail.com', 'KHÁCH HÀNG');
        
    //         $message->subject('Hóa đơn mua hàng tại Shop Giày Đà Nẵng!!!');
    //     });

    //     Cart::destroy();
    //     echo "<script>
    //       alert('Bạn đã đặt mua sản phẩm thành công!');
    //       window.location = '".url('/')."';</script>";
    // }

    // public function postComment(BinhluanRequest $request)
    // {
    //     $binhluan = new Binhluan;
    //     $binhluan->binhluan_ten = $request->txtName;
    //     $binhluan->binhluan_email = $request->txtEmail;
    //     $binhluan->binhluan_noi_dung = $request->txtContent;
    //     $binhluan->binhluan_trang_thai = 0;
    //     $binhluan->sanpham_id = $request->txtID;
    //     $binhluan->save();
    //      echo "<script>
    //       alert('Cảm ơn bạn đã góp ý!');
    //       window.location = '".url('/')."';</script>";
    // }

    // public function getFind()
    // {

    //     return view('frontend.pages.product');
    // }

    // public function postFind()
    // {
    //     $keyword = Request::input('txtSeach');
    //     $sanpham = DB::table('sanpham')
    //         ->where('sanpham_ten','like','%'.$keyword.'%')
    //         ->orWhere('sanpham_url','like','%'.$keyword.'%')
    //         ->join('lohang', 'sanpham.id', '=', 'lohang.sanpham_id')
    //         ->select(DB::raw('max(lohang.id) as lomoi'),'sanpham.id','sanpham.sanpham_ten','sanpham.sanpham_url','sanpham.sanpham_khuyenmai','sanpham.sanpham_anh', 'lohang.lohang_so_luong_nhap','lohang.lohang_so_luong_hien_tai','lohang.lohang_gia_ban_ra')
    //             ->groupBy('sanpham.id')
    //         ->paginate(10);
    //     return view('frontend.pages.product',compact('sanpham'));
    // }
}
