<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\GiaohangRequest;
use App\Donhang;
use App\Lohang;
use DB;
use PDF;

class DonhangController extends Controller
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
    	$api_url = 'https://pbl6shopfashion-production.up.railway.app/api/orders';
        $postData = array();
        $data_init = $this->send_data_access_token($postData,$api_url,"GET");
        $data = $data_init->content;

		$order_status = [
                    ['id' => "CONFIRMED", 'name' => 'CONFIRMED'],
                    ['id' => "PACKAGING", 'name' => 'PACKAGING'],
                    ['id' => "IN_TRANSIT", 'name' => 'IN_TRANSIT'],
                    ['id' => "DELIVERED", 'name' => 'DELIVERED'],
					['id' => "CANCELLED", 'name' => 'CANCELLED'],
					['id' => "RETURN_EXCHANGE", 'name' => 'RETURN_EXCHANGE'],
					['id' => "REFUNDED", 'name' => 'REFUNDED'],
					['id' => "PREPARING_PAYMENT", 'name' => 'PREPARING_PAYMENT'],
        ];

    	return view('backend.donhang.danhsach',compact('data',"order_status"));
    }

    public function getEdit($id)
    {
    	$data = DB::table('tinhtranghd')->get();
		foreach ($data as $key => $val) {
			$tinhtrang[] = ['id' => $val->id, 'name'=> $val->tinhtranghd_ten];
		}
    	$donhang = DB::table('donhang')->where('id',$id)->first();
    	$khachhang = DB::table('khachhang')->where('id',$donhang->khachhang_id)->first();
    	$chitiet = DB::table('chitietdonhang')->where('donhang_id',$donhang->id)->get();
    	return view('backend.donhang.sua',compact('donhang','tinhtrang','khachhang','chitiet'));
    }

    public function postEdit(Request $request,$id)
    {
    	$donhang = DB::table('donhang')->where('id',$id)->first();
    	$status1 = $donhang->tinhtranghd_id;
    	$status2 = $request->selStatus;
    	// $idSP = DB::table('chitietdonhang')->select('sanpham_id','chitietdonhang_so_luong')->where('donhang_id',$id)->get();
    	// // print_r($idSP);
    	// foreach ($idSP as $key => $val) {
    	// 	$idLHM = Db::table('lohang')->where('sanpham_id',$val->sanpham_id)->max('id');
    	// 	$lohang = DB::table('lohang')->where('id',$idLHM)->first();
    	// 	print_r($lohang);
    	// }

    	if ($status1 != $status2 && $status2 == 2) {
    		DB::table('donhang')->where('id',$id)
    			->update([
    					'tinhtranghd_id' => $status2,
    				]);
    		$idSP = DB::table('chitietdonhang')
    			->select('sanpham_id','chitietdonhang_so_luong')
    			->where('donhang_id',$id)->get();
	    	foreach ($idSP as $key => $val) {
	    		$idLHM = Db::table('lohang')->where('sanpham_id',$val->sanpham_id)->max('id');
	    		$lohang = DB::table('lohang')->where('id',$idLHM)->first();
	    		DB::table('lohang')
	    			->where('id',$idLHM)
	    			->update([
	    				'lohang_so_luong_da_ban' => $lohang->lohang_so_luong_da_ban + $val->chitietdonhang_so_luong,
	    				'lohang_so_luong_hien_tai' => $lohang->lohang_so_luong_hien_tai - $val->chitietdonhang_so_luong,
	    				]);
	    	}
    	}elseif ($status1 != $status2 && $status2 == 3) {
    		DB::table('donhang')->where('id',$id)
    			->update([
    					'tinhtranghd_id' => $status2,
    				]);
    		$idSP = DB::table('chitietdonhang')
    			->select('sanpham_id','chitietdonhang_so_luong')
    			->where('donhang_id',$id)->get();
	    	foreach ($idSP as $key => $val) {
	    		$idLHM = Db::table('lohang')->where('sanpham_id',$val->sanpham_id)->max('id');
	    		$lohang = DB::table('lohang')->where('id',$idLHM)->first();
	    		DB::table('lohang')
	    			->where('id',$idLHM)
	    			->update([
	    				'lohang_so_luong_doi_tra' => $lohang->lohang_so_luong_doi_tra + $val->chitietdonhang_so_luong,
	    				'lohang_so_luong_hien_tai' => $lohang->lohang_so_luong_hien_tai + $val->chitietdonhang_so_luong,
	    				'lohang_so_luong_da_ban' => $lohang->lohang_so_luong_da_ban - $val->chitietdonhang_so_luong,
	    				]);
	    	}
    	}elseif ($status1 != $status2 && $status2 == 4) {
    		DB::table('donhang')->where('id',$id)
    			->update([
    					'tinhtranghd_id' => $status2,
    				]);
    		$idSP = DB::table('chitietdonhang')
    			->select('sanpham_id','chitietdonhang_so_luong')
    			->where('donhang_id',$id)->get();
	    	foreach ($idSP as $key => $val) {
	    		$idLHM = Db::table('lohang')->where('sanpham_id',$val->sanpham_id)->max('id');
	    		$lohang = DB::table('lohang')->where('id',$idLHM)->first();
	    		DB::table('lohang')
	    			->where('id',$idLHM)
	    			->update([
	    				'lohang_so_luong_da_ban' => $lohang->lohang_so_luong_da_ban + $val->chitietdonhang_so_luong,
	    				'lohang_so_luong_hien_tai' => $lohang->lohang_so_luong_hien_tai - $val->chitietdonhang_so_luong,
	    				]);
	    	}
    	}
    	else {
    		DB::table('donhang')->where('id',$id)
    			->update([
    					'tinhtranghd_id' => $status2,
    				]);
    	}
    	
    	return redirect()->route('admin.donhang.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa thành công!!!']);
    	
    }
    public function getEdit1($id)
    {
    	$user_id=request()->cookie('user_id');
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/orders/'.$id;
        $data = $this->send_data_access_token([],$api_url,"GET");

		$order_status = [
                    ['id' => "CONFIRMED", 'name' => 'CONFIRMED'],
                    ['id' => "PACKAGING", 'name' => 'PACKAGING'],
                    ['id' => "IN_TRANSIT", 'name' => 'IN_TRANSIT'],
                    ['id' => "DELIVERED", 'name' => 'DELIVERED'],
					['id' => "CANCELLED", 'name' => 'CANCELLED'],
					['id' => "RETURN_EXCHANGE", 'name' => 'RETURN_EXCHANGE'],
					['id' => "REFUNDED", 'name' => 'REFUNDED'],
					['id' => "PREPARING_PAYMENT", 'name' => 'PREPARING_PAYMENT'],
        ];


    	return view('backend.donhang.suagiaohang',compact('data','order_status'));
    }

    public function postEdit1(Request $request,$id)
    {
		$postData = [];
		$postData[]=$id;
		
		if($request->select_order_status!=null){
			$url = 'https://pbl6shopfashion-production.up.railway.app/api/orders?orderStatus='.$request->select_order_status;
		}else{
			return redirect()->route('admin.donhang.list')->with(['flash_level'=>'danger','flash_message'=>'Không nhân được giá trị !!!']);
		}
		
        $data = $this->send_data_access_token($postData, $url, "PUT");

    	return redirect()->route('admin.donhang.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa thành công!!!']);
    }

    public function getEdit2($id)
    {
		dd("get");
    	$data = DB::table('tinhtranghd')->get();
		foreach ($data as $key => $val) {
			$tinhtrang[] = ['id' => $val->id, 'name'=> $val->tinhtranghd_ten];
		}
    	$donhang = DB::table('donhang')->where('id',$id)->first();
    	$khachhang = DB::table('khachhang')->where('id',$donhang->khachhang_id)->first();
    	$chitiet = DB::table('chitietdonhang')->where('donhang_id',$donhang->id)->get();
    	return view('backend.donhang.suathanhtoan',compact('donhang','tinhtrang','khachhang','chitiet'));
    }
    public function postEdit2(Request $request,$id)
    {
		dd("post");
    	// $idSP = DB::table('chitietdonhang')->select('sanpham_id')->where('donhang_id',$id)->get();
    	$sp= DB::select('select sanpham_id,chitietdonhang_so_luong,chitietdonhang_thanh_tien,(chitietdonhang_thanh_tien/chitietdonhang_so_luong) as gia from chitietdonhang where donhang_id = ?', [$id]);
    	// print_r(count($idSP));
    	$data = $request->input('products',[]);
    	// print_r($data);
    	for ($i=0; $i < count($sp); $i++) { 
    		$a = $sp[$i]->sanpham_id;
    		DB::table('chitietdonhang')
    			->where([['sanpham_id',$a],['donhang_id',$id] ])
    			->update([
    				'chitietdonhang_so_luong'=>$request->txtQuant[$i],
    				'chitietdonhang_thanh_tien'=>($request->txtQuant[$i]*$sp[$i]->gia),
    				]);
    	}

    	//Delete san pham khoi gio hang

    	foreach ($data as  $val) {
    		DB::table('chitietdonhang')
    			->where([['sanpham_id',$val],['donhang_id',$id] ])
    			->delete();
    	}

    	//Tinh lai tong gia tri don hang

    	$tong = DB::select('select sum(chitietdonhang_thanh_tien) as tong from chitietdonhang where donhang_id = ?', [$id]);
    	// print_r($tong[0]->tong);
    	$p = DB::table('donhang')
    		->where('id',$id)
    		->update([
    			'donhang_tong_tien' =>$tong[0]->tong,
    			]);

    	return redirect()->route('admin.donhang.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa thành công!!!']);
    }

    public function pdf($id)
    {
        // $donhang = DB::table('donhang')->where('id',$id)->first();
        // $chitietdonhang = DB::table('chitietdonhang')->where('donhang_id',$id)->get();
        // $khachhang = DB::table('khachhang')->where('id',$donhang->khachhang_id)->first();

		$api_url = 'https://pbl6shopfashion-production.up.railway.app/api/orders/'.$id;
        $postData = array();
        $donhang = $this->send_data_access_token($postData,$api_url,"GET");

		$api_url = 'https://pbl6shopfashion-production.up.railway.app/api/users/'.$donhang->userId;
        $postData = array();
        $khachhang = $this->send_data_access_token($postData,$api_url,"GET");

        // print_r($khachhang);
        $pdf = PDF::loadView('backend.donhang.hoadon',compact('donhang', 'khachhang'));
        return $pdf->stream();
    }
}
