<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\voucherAddRequest;
use App\Http\Requests\voucherEditRequest;
use App\voucher;

use DB;

class voucherController2 extends Controller
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

    public function getList()
    {
        // lấy dữ liệu
        $postData = array(
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/vouchers';
        $data = $this->send_data_access_token($postData,$url,"GET");
        // $data = DB::table('voucher')->orderBy('id','DESC')->get();
    	return view('backend.voucher.danhsach',compact('data'));
    }

    public function getAdd()
    {
    	return view('backend.voucher.them');
    }

    public function postAdd(Request $request)
    {
        // lấy dữ liệu
        $postData = array(
            "code"=> $request->voucher_them_code,
            "expiryDate"=> $request->voucher_them_expiryDate,
            "description"=> $request->voucher_them_description,
            "discountType"=> $request->voucher_them_discountType,
            "voucherType"=> $request->voucher_them_voucherType,
            "discountValue"=> $request->voucher_them_discountValue,
            "maxDiscountValue"=> $request->voucher_them_maxDiscountValue,
            "minimumPurchaseAmount"=> $request->voucher_them_minimumPurchaseAmount,
            "usageLimit"=> $request->voucher_them_usageLimit,
            "active"=> true
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/vouchers';
        $data = $this->send_data_access_token($postData,$url,"POST");

        return redirect()->route('admin.voucher.list')->with(['flash_level'=>'success','flash_message'=>'Thêm voucher thành công!!!']);
    }

    public function getDelete($id)
    {
        // lấy dữ liệu
        $postData = array(
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/vouchers/'.$id;
        $data = $this->send_data_access_token($postData,$url,"DELETE");
        return redirect()->route('admin.voucher.list')->with(['flash_level'=>'success','flash_message'=>'Xóa voucher thành công!!!']);
    }

    public function getEdit($id)
    {
        // lấy dữ liệu
        $postData = array(
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/vouchers/'.$id;
        $data = $this->send_data_access_token($postData,$url,"GET");
        
        return view('backend.voucher.sua',compact('data'));
    }

    public function postEdit(Request $request, $id)
    {
        // lấy dữ liệu
        $postData = array(
            "code"=> $request->voucher_sua_code,
            "expiryDate"=> $request->voucher_sua_expiryDate,
            "description"=> $request->voucher_sua_description,
            "discountType"=> $request->voucher_sua_discountType,
            "voucherType"=> $request->voucher_sua_voucherType,
            "discountValue"=> $request->voucher_sua_discountValue,
            "maxDiscountValue"=> $request->voucher_sua_maxDiscountValue,
            "minimumPurchaseAmount"=> $request->voucher_sua_minimumPurchaseAmount,
            "usageLimit"=> $request->voucher_sua_usageLimit,
            "active"=> $request->voucher_sua_active,
            );
        $url = 'https://pbl6shopfashion-production.up.railway.app/api/vouchers/'.$id;
        $data = $this->send_data_access_token($postData,$url,"PUT");

        return redirect()->route('admin.voucher.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa voucher thành công!!!']);
    }
}
