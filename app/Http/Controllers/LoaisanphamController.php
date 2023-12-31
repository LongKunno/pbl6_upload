<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests;

use App\Http\Requests\LoaisanphamAddRequest;
use App\Http\Requests\LoaisanphamEditRequest;

use App\Loaisanpham;
use DB;
use CURLFile;
use Input,File;

class LoaisanphamController extends Controller
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
		// $data =  DB::table('loaisanpham')->orderBy('id','DESC')->get();
		$api_url = 'https://pbl6shopfashion-production.up.railway.app/api/category';
        $postData = array();
        $data = $this->send_data_no_access_token($postData,$api_url,"GET");

		return view('backend.loaisanpham.danhsach',compact('data'));
	}

	public function getAdd() {
		return view('backend.loaisanpham.them');
	}

	public function postAdd(Request $request) {
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/category/add';
        $file = $request->file('fImage');

        if ($file) {

            // Tạo một yêu cầu POST mới
            $postData = array(
                'image' => new CURLFile($file->getPathname(), 'image/jpeg', $file->getClientOriginalName()),
                'name' => $request->txtLSPName,
                'desc' => $request->txtLSPIntro
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

            // Xử lý kết quả từ server Java (response)
            // dd($response);

            // Đóng kết nối cURL
            curl_close($ch);
        } else {
            return redirect()->route('admin.loaisanpham.list')->with(['flash_level'=>'danger','flash_message'=>'Vui lòng chọn ảnh!!!']);
        }
		return redirect()->route('admin.loaisanpham.list')->with(['flash_level'=>'success','flash_message'=>'Thêm loại sản phẩm thành công!!!']);
	}

	public function getDelete($id)
	{
		$api_url_product = 'https://pbl6shopfashion-production.up.railway.app/api/category/'.$id;
        $postData = array();
        $data_product = $this->send_data_access_token($postData,$api_url_product,"DELETE");

        return redirect()->route('admin.loaisanpham.list')->with(['flash_level'=>'success','flash_message'=>'Xóa loại sản phẩm thành công!!!']);
	}

	public function getEdit($id)
	{
        $api_url_product = 'https://pbl6shopfashion-production.up.railway.app/api/category/getCategoryById?id='.$id;
        $postData = array();
        $category = $this->send_data_access_token($postData,$api_url_product,"GET");

		return view('backend.loaisanpham.sua',compact('category'));
	}

	public function postEdit(Request $request,$id)
	{

        $url = 'https://pbl6shopfashion-production.up.railway.app/api/category/update/'.$id;
        $file = $request->file('fImage');

        if ($file) {

            // Tạo một yêu cầu POST mới
            $postData = array(
                'image' => new CURLFile($file->getPathname(), 'image/jpeg', $file->getClientOriginalName()),
                "id" => $id,
                "name" => $request->txtLSPName,
                "desc" => $request->txtLSPIntro,
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
		
		return redirect()->route('admin.loaisanpham.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa loại sản phẩm thành công!!!']);
	}
}
