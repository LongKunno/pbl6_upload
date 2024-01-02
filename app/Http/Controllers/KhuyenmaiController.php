<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\KhuyenmaiAddRequest;
use App\Http\Requests\KhuyenmaiEditRequest;
use App\Sanpham;
use App\Khuyenmai;
use App\Sanphamkhuyenmai;
use DB;
use File,Input;

class KhuyenmaiController extends Controller
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
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/promotion';
        $postData = array();
        $data = $this->send_data_access_token($postData,$api_url,"GET");

    	return view('backend.khuyenmai.danhsach',compact('data'));
    }

    public function getAdd()
    {
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/searchAll';
        $api_url = $api_url."?page=1"."&pageSize=999";
        $postData = array();
        $data = $this->send_data_access_token($postData,$api_url,"GET");

        $data_product=[];
        foreach ($data->items as $key => $val) {
            $data_product[] = ['id' => $val->product_id, 'name'=> $val->product_name];
        }

    	return view('backend.khuyenmai.them',compact('data_product'));
    }

    public function postAdd(Request $request)
    {
        $list_product_id="";
        foreach ($request->products as $key => $val) {
            $list_product_id = $list_product_id.$val.',' ;
        }
        

        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/promotion';
        $postData = array(
            "promotionName" => $request->txtKMTittle,
            "discountType" => $request->khuyenmai_them_discountType,
            "desc" => $request->txtKMContent,
            "value" => $request->txtKMPer,
            "startAt" => $request->khuyenmai_them_startDate,
            "endAt" => $request->khuyenmai_them_endDate,
            "productIds" => $list_product_id,
        );
        $data = $this->send_data_access_token($postData,$api_url,"POST");
        

        return redirect()->route('admin.khuyenmai.list')->with(['flash_level'=>'success','flash_message'=>'Thêm thành công!!!']);
    }

    public function getDelete($id)
    {
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/promotion/'.$id.'?promotionId='.$id;
        $postData = array(
        );
        $data = $this->send_data_access_token($postData,$api_url,"DELETE");

        return redirect()->route('admin.khuyenmai.list')->with(['flash_level'=>'success','flash_message'=>'Xóa thành công!!!']);
    }

    public function getEdit($id)
    {
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/searchAll';
        $api_url = $api_url."?page=1"."&pageSize=999";
        $postData = array();
        $data = $this->send_data_access_token($postData,$api_url,"GET");

        $data_product=[];
        foreach ($data->items as $key => $val) {
            $data_product[] = ['id' => $val->product_id, 'name'=> $val->product_name];
        }

    	$api_url = 'https://pbl6shopfashion-production.up.railway.app/api/promotion/detail/'.$id;
        $postData = array();
        $data = $this->send_data_access_token($postData,$api_url,"GET");

        $list_discountType = [
                    ['id' => 'PERCENTAGE', 'name' => 'PERCENTAGE'],
                    ['id' => 'AMOUNT', 'name' => 'AMOUNT'],
        ];


        return view('backend.khuyenmai.sua',compact('data','data_product','list_discountType'));
    }

    public function postEdit(Request $request,$id)
    {
        $list_product_id="";
        foreach ($request->products as $key => $val) {
            $list_product_id = $list_product_id.$val.',' ;
        }
        

        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/promotion/'.$id.'?promotionId='.$id;
        $postData = array(
            "promotionName" => $request->txtKMTittle,
            "discountType" => $request->khuyenmai_them_discountType,
            "description" => $request->txtKMContent,
            "discountValue" => $request->txtKMPer,
            "startAt" => $request->khuyenmai_them_startDate,
            "endAt" => $request->khuyenmai_them_endDate,
            "productIds" => $list_product_id,
        );
        $data = $this->send_data_access_token($postData,$api_url,"PUT");

        return redirect()->route('admin.khuyenmai.list')->with(['flash_level'=>'success','flash_message'=>'Edit thành công!!!']);
    }

    public function getAddPromotion()
    {
        $sanpham = DB::table('sanpham')->where('sanpham_da_xoa',1)->orderBy('id','DESC')->get();
        return view('backend.khuyenmai.themsanphamkm',compact('sanpham'));
    }

    public function postAddPromotion(Request $request)
    {
        $data = $request->input('products',[]);
        foreach ($data as  $item) {
            DB::table('sanpham')
                ->where('id',$item)
                ->update([
                        'sanpham_khuyenmai'=> 1,
                    ]);
            //print_r($item);
            $sanphamkhuyenmai = new Sanphamkhuyenmai;
            $sanphamkhuyenmai->sanpham_id = $item;
            $sanphamkhuyenmai->khuyenmai_id = $request->txtID;
            $sanphamkhuyenmai->save();
            
        }
        return redirect()->route('admin.khuyenmai.list')->with(['flash_level'=>'success','flash_message'=>'Thêm thành công!!!']);
    }

    public function getEditPromotion($id)
    {
        //$tylegia = DB::table('sanphamkhuyenmai')->where('khuyenmai_id',$id)->get();
        $spkhuyenmai = DB::table('sanphamkhuyenmai')->select('sanpham_id')->where('khuyenmai_id',$id)->get();
        foreach ($spkhuyenmai as $key => $val) {
            $khmai[] = $val->sanpham_id;
        }
        if (!empty($khmai)) {
        
            $sanpham1 = DB::table('sanpham')
                    ->whereIn('id',$khmai)
                    ->get();
        } else {
            $sanpham1 = DB::table('sanpham')
                    ->whereIn('id',['0'])
                    ->get();
        }

        if (empty($khmai)) {
            $sanpham2 = DB::table('sanpham')
                    ->whereNotIn('id',['0'])
                    ->get();
        } else {
            $sanpham2 = DB::table('sanpham')
                    ->whereNotIn('id',$khmai)
                    ->get();
        }
        return view('backend.khuyenmai.suasanphamkm',compact('sanpham1','sanpham2'));
    }


public function postEditPromotion(Request $request,$id)
    {
        $ids = DB::table('sanphamkhuyenmai')->select('sanpham_id')->where('khuyenmai_id',$id)->get();
        // print_r($ids);
        foreach ($ids as $val) {
            $p = DB::table('sanpham')
                ->where('id',$val->sanpham_id)
                ->update([
                        'sanpham_khuyenmai'=> 0
                    ]);
        }
        DB::table('sanphamkhuyenmai')->where('khuyenmai_id',$id)->delete();
        
        //Them $val moi
        $data = $request->input('products',[]);
        //print_r($data);
        
        foreach ($data as  $item) {
            $u = DB::table('sanpham')
                ->where('id',$item)
                ->update(['sanpham_khuyenmai' => 1]);
            $sanphamkhuyenmai = new Sanphamkhuyenmai;
            $sanphamkhuyenmai->sanpham_id = $item;
            $sanphamkhuyenmai->khuyenmai_id = $id;
            $sanphamkhuyenmai->save(); 
            
        }
        return redirect()->route('admin.khuyenmai.list')->with(['flash_level'=>'success','flash_message'=>'Edit thành công!!!']);
    }

}
