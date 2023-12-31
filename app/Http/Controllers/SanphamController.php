<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\HomeController;
use App\Http\Requests\SanphamAddRequest;
use App\Http\Requests\SanphamEditRequest;
use App\Sanpham;
use App\Hinhsanpham;
use App\Donvitinh;
use DB;
use Request;
use Input,File;
use CURLFile;
class SanphamController extends Controller
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

        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/getAll?pageSize=9999';
        $postData = array();
        $data = $this->send_data_no_access_token($postData,$api_url,"GET");

        return view('backend.sanpham.danhsach',compact('data'));
    }

    public function getAdd()
    {
        //========== category ============
        $api_url_category = 'https://pbl6shopfashion-production.up.railway.app/api/category';
        $postData = array();
        $data_category = $this->send_data_no_access_token($postData,$api_url_category,"GET");
        $category=[];
        foreach ($data_category as $key => $val) {
            $category[] = ['id' => $val->id, 'name'=> $val->name];
        }
        //========== brand ============
        $api_url_brand = 'https://pbl6shopfashion-production.up.railway.app/api/brand';
        $postData = array();
        $data_brand = $this->send_data_no_access_token($postData,$api_url_brand,"GET");
        $brand=[];
        foreach ($data_brand as $key => $val) {
            $brand[] = ['id' => $val->id, 'name'=> $val->name];
        }
        //========== promotion ============
        $api_url_promotion = 'https://pbl6shopfashion-production.up.railway.app/api/promotion';
        $postData = array();
        $data_promotion = $this->send_data_no_access_token($postData,$api_url_promotion,"GET");
        $promotion=[];
        foreach ($data_promotion as $key => $val) {
            $promotion[] = ['id' => $val->id, 'name'=> $val->name];
        }
        
        //========== unit ============
        $unit = [
                    ['id' => 1, 'name' => 'Cái'],
                    ['id' => 2, 'name' => 'Đôi'],
                    ['id' => 3, 'name' => 'Combo']
                ];
        //========== size ============
        $size = [
                    ['id' => 1, 'name' => 'S'],
                    ['id' => 2, 'name' => 'M'],
                    ['id' => 3, 'name' => 'L'],
                    ['id' => 4, 'name' => 'XL'],
                    ['id' => 5, 'name' => 'XXL']
                ];

    	return view('backend.sanpham.them',compact('category','brand','unit','size','promotion'));
    }

    public function getDelete($id)
    {   
        $api_url_product = 'https://pbl6shopfashion-production.up.railway.app/api/product/'.$id;
        $postData = array();
        $data_product = $this->send_data_no_access_token($postData,$api_url_product,"DELETE");

        return redirect()->route('admin.sanpham.list')->with(['flash_level'=>'success','flash_message'=>'Xóa loại sản phẩm thành công!!!']);
    }

    public function getEdit($id)
    {
        //========== data product ============
        $api_url_product = 'https://pbl6shopfashion-production.up.railway.app/api/product/product_detail?id='.$id;
        $postData = array();
        $data_product = $this->send_data_no_access_token($postData,$api_url_product,"GET");

        //========== category ============
        $api_url_category = 'https://pbl6shopfashion-production.up.railway.app/api/category';
        $postData = array();
        $data_category = $this->send_data_no_access_token($postData,$api_url_category,"GET");
        $category=[];
        foreach ($data_category as $key => $val) {
            $category[] = ['id' => $val->id, 'name'=> $val->name];
        }
        //========== brand ============
        $api_url_brand = 'https://pbl6shopfashion-production.up.railway.app/api/brand';
        $postData = array();
        $data_brand = $this->send_data_no_access_token($postData,$api_url_brand,"GET");
        $brand=[];
        foreach ($data_brand as $key => $val) {
            $brand[] = ['id' => $val->id, 'name'=> $val->name];
        }
        //========== unit ============
        $unit = [
                    ['id' => 1, 'name' => 'Cái'],
                    ['id' => 2, 'name' => 'Đôi'],
                    ['id' => 3, 'name' => 'Combo']
                ];
        //========== size ============
        $size = [
                    ['id' => 1, 'name' => 'S'],
                    ['id' => 2, 'name' => 'M'],
                    ['id' => 3, 'name' => 'L'],
                    ['id' => 4, 'name' => 'XL'],
                    ['id' => 5, 'name' => 'XXL']
                ];
        //========== promotion ============
        $api_url_promotion = 'https://pbl6shopfashion-production.up.railway.app/api/promotion';
        $postData = array();
        $data_promotion = $this->send_data_no_access_token($postData,$api_url_promotion,"GET");
        $promotion=[];
        foreach ($data_promotion as $key => $val) {
            $promotion[] = ['id' => $val->id, 'name'=> $val->name];
        }

        return view('backend.sanpham.sua',compact('category','brand','unit','size','promotion','data_product'));
    }

    // public function postEdit($id, SanphamEditRequest $request)
    // {
    //     $sanpham = Sanpham::find($id);
    //     $sanpham->sanpham_ky_hieu   = Request::input('txtSPSignt');
    //     $sanpham->sanpham_ten       = Request::input('txtSPName');
    //     $sanpham->sanpham_url       = Replace_TiengViet(Request::input('txtSPName'));
    //     $sanpham->sanpham_mo_ta     = Request::input('txtSPIntro');
    //     $sanpham->loaisanpham_id    = Request::input('txtSPCate');
    //     $sanpham->donvitinh_id      = Request::input('txtSPUnit');
       
    //     $img_current = 'public/images/sanpham/'.Request::input('fImageCurrent');
    //     if (!empty(Request::file('fImage'))) {
    //          $filename=Request::file('fImage')->getClientOriginalName();
    //          $sanpham->sanpham_anh = $filename;
    //          Request::file('fImage')->move(base_path() . '/public/images/sanpham/', $filename);
    //          File::delete($img_current);
    //     } else {
    //         echo "File empty";
    //     }

    //     if(!empty(Request::file('fEditImage'))) {
    //         foreach (Request::file('fEditImage') as $file) {
    //             $detail_img = new Hinhsanpham();
    //             if (isset($file)) {
    //                 $detail_img->hinhsanpham_ten = $file->getClientOriginalName();
    //                 $detail_img->sanpham_id = $id;
    //                 $file->move('public/images/chitietsanpham/', $file->getClientOriginalName());
    //                 $detail_img->save();
    //             } 
    //       }
    //     }

    //     $sanpham->save();

    //     return redirect()->route('admin.sanpham.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa sản phẩm thành công!!!']);
    // }

    public function delImage($id){
        if (Request::ajax()) {
            $idHinh = (int)Request::get('idHinh');
            $image_detail = Hinhsanpham::find($idHinh);
            if(!empty($image_detail)) {
                $img = 'public/images/chitietsanpham/'.$image_detail->hinhsanpham_ten;
                //print_r($img);
                //if(File::isFile($img)) {
                    File::delete($img);
                //}
                $image_detail->delete();
            }
            return "Oke";
        }
    }
}
