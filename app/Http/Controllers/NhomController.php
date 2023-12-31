<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NhomAddRequest;
use App\Http\Requests\NhomEditRequest;
use App\Nhom;
use DB;
use Input,File;
use CURLFile;


class NhomController extends Controller
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
    	// $data = DB::table('nhom')->get();
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/brand';
        $postData = array();
        $data = $this->send_data_no_access_token($postData,$api_url,"GET");

    	return view('backend.nhom.danhsach',compact('data'));
    }

    public function getAdd()
    {
    	return view('backend.nhom.them');
    }

    public function postAdd(NhomAddRequest $request)
    {
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/brand/add';
        $file = $request->file('fImage');

        if ($file) {

            // Tạo một yêu cầu POST mới
            $postData = array(
                'image' => new CURLFile($file->getPathname(), 'image/jpeg', $file->getClientOriginalName()),
                'name' => $request->txtNName,
                'desc' => $request->txtNIntro
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
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
        } else {
            return redirect()->route('admin.nhom.list')->with(['flash_level'=>'danger','flash_message'=>'Vui lòng chọn ảnh!!!']);
        }
    return redirect()->route('admin.nhom.list')->with(['flash_level'=>'success','flash_message'=>'Thêm nhóm sản phẩm thành công!!!']);

    }

    public function getEdit($id) {
    	$api_url_product = 'https://pbl6shopfashion-production.up.railway.app/api/brand/getBrandById?id='.$id;
        $postData = array();
        $nhom = $this->send_data_access_token($postData,$api_url_product,"GET");

    	return view('backend.nhom.sua',compact('nhom'));
    }

    public function postEdit(Request $request, $id)
    {
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/brand/update/'.$id;
        $file = $request->file('fImage');

        if ($file) {

            // Tạo một yêu cầu POST mới
            $postData = array(
                'image' => new CURLFile($file->getPathname(), 'image/jpeg', $file->getClientOriginalName()),
                "id" => $id,
                "name" => $request->txtNName,
                "desc" => $request->txtNIntro,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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
        } else {
            return redirect()->route('admin.loaisanpham.list')->with(['flash_level'=>'danger','flash_message'=>'Vui lòng chọn ảnh!!!']);
        }

    	return redirect()->route('admin.nhom.list')->with(['flash_level'=>'success','flash_message'=>'Cập nhật nhóm sản phẩm thành công!!!']);
    }

    public function getDelete($id)
	{
        $api_url_product = 'https://pbl6shopfashion-production.up.railway.app/api/brand/'.$id;
        $postData = array();
        $data_product = $this->send_data_access_token($postData,$api_url_product,"DELETE");

        return redirect()->route('admin.nhom.list')->with(['flash_level'=>'success','flash_message'=>'Xóa nhóm sản phẩm thành công!!!']);
	}
}
