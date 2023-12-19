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

    public function testapi(){
        $response = file_get_contents('http://192.168.242.205:8080/product');
        $data = json_decode($response);
        return $data;
    }

    public function send_data_access_token($postData,$url,$phuongthuc){
        $user_id = request()->cookie('user_id');
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
            dd("Vui lòng đăng nhập");
        }
    }

    public function send_data_no_access_token($postData,$url,$phuongthuc){
        $user_id = request()->cookie('user_id');
        if (request()->hasCookie('access_token')) {
            $postData = json_encode($postData);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $phuongthuc);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
            dd("Vui lòng đăng nhập");
        }
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
                dd("error: Tài khoản hoặc mặt khẩu không đúng!");
            }
            
        } else {
            dd("error: postLogin!");
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
            CURLOPT_RETURNTRANSFER => true
        );
        $curl = curl_init();
        curl_setopt_array($curl, $options);
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
                dd("error: Đăng kí không thành công!");
            }
            
        } else {
            dd("error: post Register!");
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

    public function index()
    {
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/home/12';
        $response = file_get_contents($api_url);
        $data = json_decode($response);
        // print_r($loaisp);
        return view('frontend.pages.home',compact('data'));
    }

    public function group($url_id)
    { 
        $page = Request::input('page', 1);
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/getByCategory';
        $api_url = $api_url."?category_id=".$url_id."&page=".$page."&pageSize=9";
        $response = file_get_contents($api_url);
        $data = json_decode($response);
        $sanpham = $data->items;

        return view('frontend.pages.group',compact('data','sanpham'));
    }


    public function cates($id_category,$id_brand)
    {

        $page = Request::input('page', 1);
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/getByCategory';
        $api_url = $api_url."?brand_id=".$id_brand."&category_id=".$id_category."&page=".$page."&pageSize=9";
        $response = file_get_contents($api_url);
        $data = json_decode($response);
        $sanpham = $data->items;

        return view('frontend.pages.cates',compact('data','sanpham'));
    }

    public function thongtin()
    {
        $thongtin = DB::table('thongtin')->paginate(9);
        return view ('frontend.pages.thongtins',compact('thongtin'));
    }

    public function detailthongtin($url)
    {
        $thongtin = DB::table('thongtin')->where('thongtin_url',$url)->first();
        $id = DB::table('thongtin')->select('id')->where('thongtin_url',$url)->first();
        $id = $id->id;
        // print_r($i);
        $nglieu = DB::table('nguyenlieu')->where('thongtin_id',$id)->get();
        // print_r($nglieu);
        return view ('frontend.pages.detailthongtin',compact('thongtin','nglieu'));
    }

    public function getContact()
    {
        return view ('frontend.pages.contact');
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
        $khuyenmai = DB::table('khuyenmai')->where('khuyenmai_tinh_trang',1)->first();
        if (!is_null($khuyenmai)) {
            $spham = DB::table('sanphamkhuyenmai')
            ->where('khuyenmai_id',$khuyenmai->id)
            ->get();
        } else {
            $spham = Null;
        }
        return view ('frontend.pages.promotion',compact('khuyenmai','spham'));
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
        $response = file_get_contents($api_url);
        $data = json_decode($response);
        // $hinhsanpham_url = $data->hinhsanpham_url;
        // dd($hinhsanpham_url[0]->imageUrl);



        // $idLSP = DB::table('sanpham')->select('id')->where('id',$url_id)->first();
        // // $id = $idLSP->id;
        // $id=17;
        // $sanpham = DB::table('sanpham')
        //     ->where('sanpham.id',$id)
        //     ->join('lohang', 'sanpham.id', '=', 'lohang.sanpham_id')
        //     ->join('donvitinh','sanpham.donvitinh_id', '=', 'donvitinh.id' )
        //     ->join('loaisanpham','sanpham.loaisanpham_id' , '=', 'loaisanpham.id')
        //     ->select(DB::raw('max(lohang.id) as lomoi'),'sanpham.id','sanpham.sanpham_ten','sanpham.sanpham_url','sanpham.sanpham_khuyenmai','sanpham.sanpham_anh', 'lohang.lohang_so_luong_nhap','lohang.lohang_so_luong_hien_tai','lohang.lohang_gia_ban_ra','donvitinh.donvitinh_ten','loaisanpham.loaisanpham_ten','sanpham.loaisanpham_id','sanpham.sanpham_anh','sanpham.sanpham_mo_ta')
        //     ->groupBy('sanpham.id')
        //     ->first();
        
        // $hinhsanpham = DB::table('hinhsanpham')->where('sanpham_id',$id)->get();
        // $loaisanpham = DB::table('loaisanpham')->where('id',$sanpham->loaisanpham_id)->first();
        // $nhom = DB::table('nhom')->where('id',$loaisanpham->nhom_id)->first();
        // $binhluan = DB::table('binhluan')->where([['sanpham_id',$id],['binhluan_trang_thai',1],])->get();

        return view('frontend.pages.detailpro',compact('sanpham','hinhsanpham','loaisanpham','nhom','binhluan','data'));
    }

    public function buyding(Request $request,$id)
    {
        $user_id=request()->cookie('user_id');
        // Xoá sản hết phẩm
        // $postData = array("userId"=> $user_id);
        // $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id."/clean";
        // $data = $this->send_data_access_token($postData,$url,"DELETE");

        // add sản phẩm vào giỏ hàng
        $postData = array(
                "quantity"=> 1,
                "productId"=> $id,
                "size"=> "S"
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
        $total = 999999;
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
            $id = Request::get('id');
            $quantity = Request::input('quantity');
            $size = Request::get('size');
        dd("dang phat trien".$id. $quantity. $size);
        if(Request::ajax()) {
            $id = Request::get('id');
            $qty = Request::get('qty');
        }
        $user_id=request()->cookie('user_id');
        // Xoá sản phẩm của giỏ hàng
        $postData = array(
                "userId"=> $user_id,
                "id"=> 0,
                "quantity"=> 0,
                "createdAt"=> "2023-12-15T15:28:56.900Z",
                "productId"=> 0,
                "size"=> "S"
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.$user_id;
        $data = $this->send_data_access_token($postData,$url,"DELETE");
        dd($data);
        return redirect()->route('giohang');
    }

    public function getCheckin()
    {
        $content = Cart::content();
        $total = Cart::total();
        // echo "string";
        // print_r($total);
        return view('frontend.pages.checkin',compact('content','total'));
    }

    public function postCheckin(ThanhtoanRequest $request)
    {
        $content = Cart::content();
        $total = Cart::total();

        $donhang = new Donhang;
        $donhang->donhang_nguoi_nhan = $request->txtNNName;
        $donhang->donhang_nguoi_nhan_email = $request->txtNNEmail;
        $donhang->donhang_nguoi_nhan_sdt = $request->txtNNPhone;
        $donhang->donhang_nguoi_nhan_dia_chi = $request->txtNNAddr;
        $donhang->donhang_ghi_chu = $request->txtNNNote;
        $donhang->donhang_tong_tien = $total;
        $donhang->khachhang_id = $request->txtKHID;
        $donhang->tinhtranghd_id = 1;
        $donhang->save();

        foreach ($content as $item) {
            $detail = new Chitietdonhang;
            $detail->sanpham_id = $item->id;
            $detail->donhang_id = $donhang->id;
            $detail->chitietdonhang_so_luong = $item->qty;
            $detail->chitietdonhang_thanh_tien = $item->price*$item->qty;
            $detail->save();
        }
        $kh = DB::table('khachhang')->where('id', $request->txtKHID)->first();
        // print_r($kh);
        $donhang = [
            'id'=> $donhang->id,
            'donhang_nguoi_nhan'=> $request->txtNNName,
            'donhang_nguoi_nhan_email' => $request->txtNNEmail,
            'donhang_nguoi_nhan_sdt' => $request->txtNNPhone,
            'donhang_nguoi_nhan_dia_chi' => $request->txtNNAddr,
            'donhang_ghi_chu' => $request->txtNNNote,
            'donhang_tong_tien' => $total,
            'khachhang_id' => $request->txtKHID,
            'khachhang_email'=>$kh->khachhang_email,
            ];
        // print_r($donhang);
        // Mail::send('auth.emails.hoadon', $donhang, function ($message) use ($donhang) {
        //     $message->from('long@gmail.com', 'ADMIN');
        
        //     $message->to($donhang['khachhang_email'], 'a');
        
        //     $message->subject('Hóa đơn mua hàng tại Shop Giày Đà Nẵng!!!');
        // });

        // Mail::send('auth.emails.hoadon', $donhang, function ($message) use ($donhang) {
        //     $message->from('long@gmail.com', 'ADMIN');
        
        //     $message->to('long@gmail.com', 'KHÁCH HÀNG');
        
        //     $message->subject('Hóa đơn mua hàng tại Shop Giày Đà Nẵng!!!');
        // });

        Cart::destroy();
        echo "<script>
          alert('Bạn đã đặt mua sản phẩm thành công!');
          window.location = '".url('/')."';</script>";
    }

    public function postComment(BinhluanRequest $request)
    {
        
        $user_id=request()->cookie('user_id');
        // $binhluan_ten = $request->txtName;
        // $binhluan_email = $request->txtEmail;
        $binhluan_noi_dung = $request->txtContent;
        // $binhluan_trang_thai = 0;
        $sanpham_id = $request->txtID;
        $rate = 5;
        // post comment
        $postData = array(

            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/comment?rate='.$rate.'&userId='.$user_id.'&productId='.(int)$sanpham_id.'&content='.$binhluan_noi_dung;
        $data = $this->send_data_access_token($postData,$url,"POST");
        
        
        
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
        // $keyword = Request::input('txtSeach');
        // $sanpham = DB::table('sanpham')
        //     ->where('sanpham_ten','like','%'.$keyword.'%')
        //     ->orWhere('sanpham_url','like','%'.$keyword.'%')
        //     ->join('lohang', 'sanpham.id', '=', 'lohang.sanpham_id')
        //     ->select(DB::raw('max(lohang.id) as lomoi'),'sanpham.id','sanpham.sanpham_ten','sanpham.sanpham_url','sanpham.sanpham_khuyenmai','sanpham.sanpham_anh', 'lohang.lohang_so_luong_nhap','lohang.lohang_so_luong_hien_tai','lohang.lohang_gia_ban_ra')
        //         ->groupBy('sanpham.id')
        //     ->paginate(5);

        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/getByCategory';
        $api_url = $api_url."?category_id=".$url_id."&page=1"."&pageSize=9";
        $response = file_get_contents($api_url);
        $sanpham = json_decode($response);

        return view('frontend.pages.product',compact('sanpham'));
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
