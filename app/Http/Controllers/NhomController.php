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
    public function getList()
    {
    	$data = DB::table('nhom')->get();
    	return view('backend.nhom.danhsach',compact('data'));
    }

    public function getAdd()
    {
    	return view('backend.nhom.them');
    }

    public function postAdd(NhomAddRequest $request)
    {
    	// $nhom = new Nhom;
        // $imageName = $request->file('fImage')->getClientOriginalName();

        // $request->file('fImage')->move(
        //     base_path() . '/resources/upload/nhom/', $imageName
        // );
    	// $nhom->nhom_ten   = $request->txtNName;
    	// $nhom->nhom_url   = Replace_TiengViet($request->txtNName);
    	// $nhom->nhom_mo_ta = $request->txtNIntro;
        // $nhom->nhom_anh = $request->imageName;
    	// $nhom->save();

        // return redirect()->route('admin.nhom.list')->with(['flash_level'=>'success','flash_message'=>'Thêm nhóm sản phẩm thành công!!!']);

        //=========================================================================
        // $url = 'http://192.168.55.111:8080/api/category/add';
        // $data = array(
        //     'image' => $request->file('fImage'),
        //     'name' => $request->txtNName,
        //     'desc' => $request->txtNIntro,
        // );
        // dd($data);

        // $options = array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_POST => true,
        //     CURLOPT_POSTFIELDS => json_encode($data),
        //     CURLOPT_HTTPHEADER => array(
        //         'Content-Type: application/json',
        //         'Content-Length: ' . strlen(json_encode($data))
        //     ),
        //     CURLOPT_RETURNTRANSFER => true
        // );


        // $curl = curl_init();
        // curl_setopt_array($curl, $options);
        // $response = curl_exec($curl);
        // curl_close($curl);

        // // Xử lý phản hồi từ máy chủ
        // if ($response) {
        //     $datareturn = json_decode($response);
        //     dd($datareturn);
        // } else {
        //     dd("Load dữ liệu thất bại");
        // }


        $url = 'http://192.168.55.111:8080/api/category/add';
        $file = $request->file('fImage');

        if ($file) {
            $data = array(
                'name' => $request->txtNName,
                'desc' => $request->txtNIntro,
            );

            // Tạo một yêu cầu POST mới
            $postData = array(
                'image' => new CURLFile($file->getPathname(), 'image/jpeg', $file->getClientOriginalName()),
                'name' => $data['name'],
                'desc' => $data['desc']
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

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
            dd("Không tìm thấy file ảnh");
        }
    return view('backend.nhom.them');




    }

    public function getEdit($id) {
    	$nhom = DB::table('nhom')->where('id',$id)->first();
    	return view('backend.nhom.sua',compact('nhom'));
    }

    public function postEdit(NhomEditRequest $request, $id)
    {
        $fImage = $request->fImage;
        $img_current = 'resources/upload/nhom/'.$request->fImageCurrent;
        if (!empty($fImage )) {
             $filename=$fImage ->getClientOriginalName();
             DB::table('nhom')->where('id',$id)
                            ->update([
                                'nhom_ten'   => $request->txtNName,
                                'nhom_url'   => Replace_TiengViet($request->txtNName),
                                'nhom_mo_ta' => $request->txtNIntro,
                                'nhom_anh' => $filename
                                ]);
             $fImage ->move(base_path() . '/resources/upload/nhom/', $filename);
             File::delete($img_current);
        } else {
            DB::table('nhom')->where('id',$id)
                            ->update([
                                'nhom_ten'   => $request->txtNName,
                                'nhom_url'   => Replace_TiengViet($request->txtNName),
                                'nhom_mo_ta' => $request->txtNIntro
                                ]);
        }

    	return redirect()->route('admin.nhom.list')->with(['flash_level'=>'success','flash_message'=>'Cập nhật nhóm sản phẩm thành công!!!']);
    }

    public function getDelete($id)
	{
        $nhom = DB::table('nhom')->where('id',$id)->first();
        $img = 'resources/upload/nhom/'.$nhom->nhom_anh;
        File::delete($img);
		DB::table('nhom')->where('id',$id)->delete();
        return redirect()->route('admin.nhom.list')->with(['flash_level'=>'success','flash_message'=>'Xóa loại sản phẩm thành công!!!']);
	}
}
