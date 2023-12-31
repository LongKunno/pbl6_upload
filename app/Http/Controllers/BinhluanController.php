<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Binhluan;

class BinhluanController extends Controller
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
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/comment';
        $postData = array();
        $data = $this->send_data_access_token($postData,$api_url,"GET");

    	return view('backend.binhluan.danhsach',compact('data'));
    }

    public function getDelete($id)
    {
    	$api_url = 'https://pbl6shopfashion-production.up.railway.app/api/comment/'.$id;
        $postData = array();
        $data = $this->send_data_access_token($postData,$api_url,"DELETE");
        return redirect()->route('admin.binhluan.list')->with(['flash_level'=>'success','flash_message'=>'Xóa thành công!!!']);
    }

    public function getEdit($id)
    {
    	DB::table('binhluan')
    		->where('id',$id)
    		->update(['binhluan_trang_thai'=>1]);
    	return redirect()->route('admin.binhluan.list')->with(['flash_level'=>'success','flash_message'=>'Bình luận đã được chấp nhận!!!']);
    }

    public function getEdit1($id)
    {
        DB::table('binhluan')
            ->where('id',$id)
            ->update(['binhluan_trang_thai'=>0]);
        return redirect()->route('admin.binhluan.list')->with(['flash_level'=>'success','flash_message'=>'Bình luận đã bị hủy chấp nhận!!!']);
    }
}
