<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class KhachhangController extends Controller
{

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
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            // Thực hiện yêu cầu POST
            $response = json_decode(curl_exec($ch));
            // Kiểm tra lỗi
            if (curl_errno($ch)) {
                $error = curl_error($ch);
                dd($error);
            }
            if(isset($response->status)){
                if($response->status!=200){
                    dd($response->error);
                }
            }
            // Đóng kết nối cURL
            curl_close($ch);
            return $response;
        } else {
            return view('auth.login'); 
        }
    }

    public function send_data_no_access_token($postData,$url,$phuongthuc){
        $user_id = request()->cookie('user_id');
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


    public function getList()
    {
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/users';
        $postData = array();
        $data_init = $this->send_data_access_token($postData,$api_url,"GET");
        $data = $data_init->content;

    	return view('backend.khachhang.danhsach',compact('data'));
    }

    public function getAdd()
    {
    	# code...
    }

    public function postAdd()
    {
    	# code...
    }

    public function getDelete($id)
    {
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/users/'.$id;
        $postData = array();
        $data_init = $this->send_data_access_token($postData,$api_url,"GET");
        if($data_init->role=="ADMIN")
            return redirect()->route('admin.khachhang.list')->with(['flash_level'=>'danger','flash_message'=>'Không thể khoá tài khoản Admin!!!']);

        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/users/lock-user/'.$id;
        $postData = array();
        $data_init = $this->send_data_access_token($postData,$api_url,"PUT");
        if($data_init){
            return redirect()->route('admin.khachhang.list')->with(['flash_level'=>'success','flash_message'=>'Khoá tài khoản thành công!!!']);
        }else{
            return redirect()->route('admin.khachhang.list')->with(['flash_level'=>'warning','flash_message'=>'Mở khoá tài khoản thành công!!!']);
        }
    }

    public function getEdit()
    {
    	# code...
    }

    public function postEdit()
    {
    	# code...
    }

    public function getHistory($id)
    {
        $khachhang = DB::table('khachhang')->where('id',$id)->first();
        $donhang = DB::table('donhang')->where('khachhang_id',$id)->get();
        return view('backend.khachhang.lichsu',compact('khachhang','donhang'));
    }
}
