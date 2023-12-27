<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests;

use App\Http\Requests\LoaisanphamAddRequest;
use App\Http\Requests\LoaisanphamEditRequest;

use App\Loaisanpham;
use DB;

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
		$data = DB::table('nhom')->get();
		foreach ($data as $key => $val) {
			$nhom[] = ['id' => $val->id, 'name'=> $val->nhom_ten];
		}
		return view('backend.loaisanpham.them',compact('nhom'));
	}

	public function postAdd(LoaisanphamAddRequest $request) {
		$loaisanpham = new Loaisanpham;
		$imageName = $request->file('fImage')->getClientOriginalName();

        $request->file('fImage')->move(
            base_path() . '/public/images/loaisanpham/', $imageName
        );
		$loaisanpham->loaisanpham_ten	= $request->txtLSPName;
		$loaisanpham->nhom_id			= $request->txtLSPParent;
		$loaisanpham->loaisanpham_mo_ta	= $request->txtLSPIntro;
		$loaisanpham->loaisanpham_anh	= $imageName;
		$loaisanpham->loaisanpham_url	= Replace_TiengViet($request->txtLSPName);
		
		$loaisanpham->save();
		return redirect()->route('admin.loaisanpham.list')->with(['flash_level'=>'success','flash_message'=>'Thêm loại sản phẩm thành công!!!']);
	}

	public function getDelete($id)
	{
		$loaisanpham = DB::table('loaisanpham')->where('id',$id)->first();
        $img = 'public/images/loaisanpham/'.$loaisanpham->loaisanpham_anh;
        File::delete($img);
		DB::table('loaisanpham')->where('id',$id)->delete();
        return redirect()->route('admin.loaisanpham.list')->with(['flash_level'=>'success','flash_message'=>'Xóa loại sản phẩm thành công!!!']);
	}

	public function getEdit($id)
	{
		$loaisp = DB::table('loaisanpham')->where('id',$id)->first();
		$data = DB::table('nhom')->get();
		foreach ($data as $key => $val) {
			$nhom[] = ['id' => $val->id, 'name'=> $val->nhom_ten];
		}
		return view('backend.loaisanpham.sua',compact('nhom','loaisp','id'));
	}

	public function postEdit(LoaisanphamEditRequest $request,$id)
	{
		$fImage = $request->fImage;
        $img_current = 'public/images/loaisanpham/'.$request->fImageCurrent;
        if (!empty($fImage )) {
             $filename=$fImage ->getClientOriginalName();
             DB::table('loaisanpham')->where('id',$id)
                            ->update([
                                'loaisanpham_ten' => $request->txtLSPName,
								'loaisanpham_url' => Replace_TiengViet($request->txtLSPName),
								'nhom_id'=>$request->txtLSPParent,
								'loaisanpham_mo_ta'=>$request->txtLSPIntro,
                                'loaisanpham_anh' => $filename
                                ]);
             $fImage ->move(base_path() . '/public/images/loaisanpham/', $filename);
             File::delete($img_current);
        } else {
            DB::table('loaisanpham')->where('id',$id)
                            ->update([
                                'loaisanpham_ten' => $request->txtLSPName,
								'loaisanpham_url' => Replace_TiengViet($request->txtLSPName),
								'nhom_id'=>$request->txtLSPParent,
								'loaisanpham_mo_ta'=>$request->txtLSPIntro
                                ]);
        }
		
		return redirect()->route('admin.loaisanpham.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa loại sản phẩm thành công!!!']);
	}
}
