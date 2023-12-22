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
            dd("Vui lòng đăng nhập");
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
        // $data1 = DB::table('sanpham')
            
        //     ->get();
        //     // print_r($data1);
        // foreach ($data1 as $item) {
        //     $data2 = DB::table('sanphamkhuyenmai')->where('sanpham_id',$item->id)->get();
        //     // print_r($data2);
        //     foreach ($data2 as $val1) {
        //         if (!is_null($val1)) {
        //         $data3 = DB::table('khuyenmai')->where('id',$val1->khuyenmai_id)->first();
        //         // print_r($data3);
        //         // $data3 = DB::table('khuyenmai')->where('id',$data2->khuyenmai_id)->first();
        //         if ($data3->khuyenmai_tinh_trang == 0) {
        //             $u = DB::table('sanpham')
        //                 ->where('id',$item->id)
        //                 ->update(['sanpham_khuyenmai' => 0 ]);
        //             }

        //         else{
        //             $u = DB::table('sanpham')
        //                 ->where('id',$item->id)
        //                 ->update(['sanpham_khuyenmai' => 1 ]);
        //         }
        //         // print_r($u);
        //         }
        //     }   
        // }
        // $data = DB::table('sanpham')
        //     ->orderBy('id','DESC')->get();
    	// return view('backend.sanpham.danhsach',compact('data'));

        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/getAll?pageSize=9999';

        $postData = array();
        $data = $this->send_data_no_access_token($postData,$api_url,"GET");

        return view('backend.sanpham.danhsach',compact('data'));
    }

    public function getAdd()
    {
        
        // $units = DB::table('donvitinh')->get();
        // foreach ($units as $key => $val) {
        //     $unit[] = ['id' => $val->id, 'name'=> $val->donvitinh_ten];
        // }
        // $cates = DB::table('loaisanpham')->get();
        // foreach ($cates as $key => $val) {
        //     $cate[] = ['id' => $val->id, 'name'=> $val->loaisanpham_ten];
        // }

        //========== category ============
        $api_url_category = 'https://pbl6shopfashion-production.up.railway.app/api/category';
        $postData = array();
        $data_category = $this->send_data_no_access_token($postData,$api_url_category,"GET");
        foreach ($data_category as $key => $val) {
            $category[] = ['id' => $val->id, 'name'=> $val->name];
        }
        //========== brand ============
        $api_url_brand = 'https://pbl6shopfashion-production.up.railway.app/api/brand';
        $postData = array();
        $data_brand = $this->send_data_no_access_token($postData,$api_url_brand,"GET");
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
        //========== promation ============
        $promotion = [
                    ['id' => 1, 'name' => 'Khuyến mãi 20/11'],
                    ['id' => 2, 'name' => 'Khuyến mãi 11/11'],
                    ['id' => 3, 'name' => 'Khuyến mãi tháng 12'],
                ];

    	return view('backend.sanpham.them',compact('category','brand','unit','size','promotion'));
    }

    // public function postAdd(SanphamAddRequest $request)
    // {
    //     // $filename=$request->file('txtSPImage')->getClientOriginalName();
    //     // $request->file('txtSPImage')->move(
    //     //     base_path() . '/public/images/sanpham/', $filename
    //     // );
    // 	// $sanpham = new Sanpham;
    //     // $sanpham->sanpham_ky_hieu   = $request->txtSPSignt;
    //     // $sanpham->sanpham_ten           = $request->txtSPName;
    //     // $sanpham->sanpham_url           = Replace_TiengViet($request->txtSPName);
    //     // $sanpham->sanpham_mo_ta = $request->txtSPIntro;
    //     // $sanpham->sanpham_anh = $filename;
    //     // $sanpham->loaisanpham_id = $request->txtSPCate;
    //     // $sanpham->donvitinh_id = $request->txtSPUnit;
       
    //     // $sanpham->sanpham_khuyenmai = 0;
    //     // $sanpham->save();
            
    //     $files =[];
    //     if ($request->file('txtSPImage1')) {
    //         $files[] = $request->file('txtSPImage1');
    //     }
    //     if ($request->file('txtSPImage2')) {
    //         $files[] = $request->file('txtSPImage2');
    //     } 
    //     if ($request->file(' txtSPImage3')) {
    //         $files[] = $request->file('txtSPImage3');
    //     }
    //     if ($request->file('txtSPImage4')) {
    //         $files[] = $request->file('txtSPImage4');
    //     } 
    //     if ($request->file('txtSPImage5')) {
    //         $files[] = $request->file('txtSPImage5');
    //     }


    //     $url = 'https://pbl6shopfashion-production.up.railway.app/api/product';

    //     if (count($files) != 0) {
    //         $data = array(
    //             'name' => $request->txtSPName,
    //             'desc' => $request->txtSPIntro,
    //         );
    //         $image_list = [];
    //         foreach ($files as $file) {
    //             $image_list[] = new CURLFile($file->getPathname(), 'image/jpeg', $file->getClientOriginalName());
    //         }
    //         dd($image_list);


    //         // Tạo một yêu cầu POST mới
    //         $postData = array(
    //             'images' => http_build_query($image_list),
    //             'name' => $data['name'],
    //             'desc' => $data['desc']
    //         );

    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         curl_setopt($ch, CURLOPT_POST, true);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //         // Thực hiện yêu cầu POST
    //         $response = curl_exec($ch);

    //         // Kiểm tra lỗi
    //         if (curl_errno($ch)) {
    //             $error = curl_error($ch);
    //             dd($error);
    //         }

    //         // Xử lý kết quả từ server Java (response)
    //         echo("<script>alert('Thêm sản phẩm thành công');</script>");
    //         dd("ok");

    //         // Đóng kết nối cURL
    //         curl_close($ch);
    //     } else {
    //         dd("Không tìm thấy file ảnh");
    //     }
    //     dd("Không tìm thấy file ảnh2");
    // return view('backend.nhom.them');

    //     // $names =[];   

    //     // foreach ($files as $file) {
    //     //     if(!empty($file)){
    //     //         $filename=$file->getClientOriginalName();
    //     //         $file->move(
    //     //             base_path().'/public/images/chitietsanpham/', $filename
    //     //         );

    //     //         $hinh = new Hinhsanpham; 
    //     //         $hinh->hinhsanpham_ten = $filename;
    //     //         $hinh->sanpham_id = $sanpham->id;
    //     //         $hinh->save();
    //     //     }
    //     // }

    //     return redirect()->route('admin.sanpham.list')->with(['flash_level'=>'success','flash_message'=>'Thêm loại sản phẩm thành công!!!']);
    // }

    public function getDelete($id)
    {   
        $binhluan = DB::table('binhluan')->where('sanpham_id',$id)->get();
        foreach ($binhluan as $val) {
            
            DB::table('binhluan')->where('sanpham_id',$id)->delete();
        }
        DB::table('lohang')->where('sanpham_id',$id)->delete();
        $chitiet = DB::table('hinhsanpham')->where('sanpham_id',$id)->get();
        foreach ($chitiet as $val) {
            $image = 'public/images/chitietsanpham/'.$val->hinhsanpham_ten;
            File::delete($image);
            DB::table('hinhsanpham')->where('sanpham_id',$id)->delete();
        }
    	$sanpham = DB::table('sanpham')->where('id',$id)->first();
        $img = 'public/images/sanpham/'.$sanpham->sanpham_anh;
        File::delete($img);
        DB::table('sanpham')->where('id',$id)->delete();

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
        foreach ($data_category as $key => $val) {
            $category[] = ['id' => $val->id, 'name'=> $val->name];
        }
        //========== brand ============
        $api_url_brand = 'https://pbl6shopfashion-production.up.railway.app/api/brand';
        $postData = array();
        $data_brand = $this->send_data_no_access_token($postData,$api_url_brand,"GET");
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
        //========== promation ============
        $promotion = [
                    ['id' => 1, 'name' => 'Khuyến mãi 20/11'],
                    ['id' => 2, 'name' => 'Khuyến mãi 11/11'],
                    ['id' => 3, 'name' => 'Khuyến mãi tháng 12'],
                ];

        return view('backend.sanpham.sua',compact('category','brand','unit','size','promotion','data_product'));
    }

    public function postEdit($id, SanphamEditRequest $request)
    {
        $sanpham = Sanpham::find($id);
        $sanpham->sanpham_ky_hieu   = Request::input('txtSPSignt');
        $sanpham->sanpham_ten       = Request::input('txtSPName');
        $sanpham->sanpham_url       = Replace_TiengViet(Request::input('txtSPName'));
        $sanpham->sanpham_mo_ta     = Request::input('txtSPIntro');
        $sanpham->loaisanpham_id    = Request::input('txtSPCate');
        $sanpham->donvitinh_id      = Request::input('txtSPUnit');
       
        $img_current = 'public/images/sanpham/'.Request::input('fImageCurrent');
        if (!empty(Request::file('fImage'))) {
             $filename=Request::file('fImage')->getClientOriginalName();
             $sanpham->sanpham_anh = $filename;
             Request::file('fImage')->move(base_path() . '/public/images/sanpham/', $filename);
             File::delete($img_current);
        } else {
            echo "File empty";
        }

        if(!empty(Request::file('fEditImage'))) {
            foreach (Request::file('fEditImage') as $file) {
                $detail_img = new Hinhsanpham();
                if (isset($file)) {
                    $detail_img->hinhsanpham_ten = $file->getClientOriginalName();
                    $detail_img->sanpham_id = $id;
                    $file->move('public/images/chitietsanpham/', $file->getClientOriginalName());
                    $detail_img->save();
                } 
          }
        }

        $sanpham->save();

        return redirect()->route('admin.sanpham.list')->with(['flash_level'=>'success','flash_message'=>'Chỉnh sửa sản phẩm thành công!!!']);
    }

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
