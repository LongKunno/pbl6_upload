<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\voucherAddRequest;
use App\Http\Requests\voucherEditRequest;
use App\voucher;

use DB;

class voucherController extends Controller
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

    public function getList()
    {
        // lấy dữ liệu
        $postData = array(
            );
        $url = 'http://localhost:8080/api/vouchers';
        $data = $this->send_data_access_token($postData,$url,"GET");
        // $data = DB::table('voucher')->orderBy('id','DESC')->get();
    	return view('backend.voucher.danhsach',compact('data'));
    }

    public function getAdd()
    {
    	return view('backend.voucher.them');
    }

    public function postAdd(voucherAddRequest $request)
    {
    	$voucher = new voucher;
        $voucher->voucher_ten = $request->txtNCCName;
        $voucher->voucher_dia_chi = $request->txtNCCAdress;
        $voucher->voucher_sdt = $request->txtNCCPhone;
        $voucher->save();
        return redirect()->route('admin.voucher.list')->with(['flash_level'=>'success','flash_message'=>'Thêm voucher thành công!!!']);
    }

    public function getDelete($id)
    {
        // lấy dữ liệu
        $postData = array(
            );
        $url = 'http://localhost:8080/api/vouchers/'.$id;
        $data = $this->send_data_access_token($postData,$url,"DELETE");
        return redirect()->route('admin.voucher.list')->with(['flash_level'=>'success','flash_message'=>'Xóa voucher thành công!!!']);
    }

    public function getEdit($id)
    {
        // lấy dữ liệu
        $postData = array(
            );
        $url = 'http://localhost:8080/api/vouchers/'.$id;
        $data = $this->send_data_access_token($postData,$url,"GET");
    	// $data = DB::table('voucher')->where('id',$id)->first();
        return view('backend.voucher.sua',compact('data'));
    }

    public function postEdit(voucherEditRequest $request, $id)
    {
        $voucher = DB::table('voucher')->where('id',$id)->update([
            'voucher_ten'=> $request->txtNCCName,
            'voucher_dia_chi' => $request->txtNCCAdress,
            'voucher_sdt' => $request->txtNCCPhone
            ]);
        return redirect()->route('admin.voucher.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa voucher thành công!!!']);
    }
}
