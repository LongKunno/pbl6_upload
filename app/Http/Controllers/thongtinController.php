<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\thongtinEditRequest;
use App\Http\Requests\thongtinAddRequest;
use App\thongtin;
use App\Sanpham;
use App\Nguyenlieu;
use DB;
use Input,File;

class thongtinController extends Controller
{
    public function getList()
    {
        $data =  DB::table('thongtin')->orderBy('id','DESC')->get();
    	return view('backend.thongtin.danhsach',compact('data'));
    }

    public function getAdd()
    {
        $data = DB::table('sanpham')->orderBy('id','DESC')->get();
    	return view('backend.thongtin.them',compact('data'));
    }

    public function postAdd(thongtinAddRequest $request)
    {
        // $request->file('fImage')->getClientOriginalName();
        $filename=$request->file('fImage')->getClientOriginalName();
        $request->file('fImage')->move(
            base_path() . '/resources/upload/thongtin/', $filename
        );
    	$thongtin = new thongtin;
        $thongtin->thongtin_tieu_de   = $request->txtMNTittle;
        $thongtin->thongtin_tom_tat           = $request->txtMNResum;
        $thongtin->thongtin_noi_dung = $request->txtMNContent;
        $thongtin->thongtin_url   = Replace_TiengViet($request->txtMNTittle);
        $thongtin->thongtin_luot_xem= 1;
        $thongtin->thongtin_anh= $filename;
        $thongtin->thongtin_da_xoa= 1;
        $thongtin->save();

        $data = $request->input('products',[]);
        foreach ($data as  $item) {
            //print_r($item);
            $nguyenlieu = new Nguyenlieu;
            $nguyenlieu->sanpham_id = $item;
            $nguyenlieu->thongtin_id = $thongtin->id;
            $nguyenlieu->save();
        }
        return redirect()->route('admin.thongtin.list')->with(['flash_level'=>'success','flash_message'=>'Đăng tin thành công!!!']);
    }

    public function getDelete($id)
    {
        $thongtin = DB::table('thongtin')->where('id',$id)->first();
        $img = 'resources/upload/thongtin/'.$thongtin->thongtin_anh;
        File::delete($img);
    	DB::table('thongtin')->where('id',$id)->delete();
        return redirect()->route('admin.thongtin.list')->with(['flash_level'=>'success','flash_message'=>'Xóa thành công!!!']);
    }

    public function getEdit($id)
    {
    	$thongtin = DB::table('thongtin')->where('id',$id)->first();
        $nguyenlieu = DB::table('nguyenlieu')->select('sanpham_id')->where('thongtin_id',$id)->get();
        foreach ($nguyenlieu as $key => $val) {
            $nglieu[] = $val->sanpham_id;
        }
        if (!empty($nglieu)) {
        
            $sanpham1 = DB::table('sanpham')
                    ->whereIn('id',$nglieu)
                    ->get();
        } else {
            $sanpham1 = DB::table('sanpham')
                    ->whereIn('id',['0'])
                    ->get();
        }

        if (empty($nglieu)) {
            $sanpham2 = DB::table('sanpham')
                    ->whereNotIn('id',['0'])
                    ->get();
        } else {
            $sanpham2 = DB::table('sanpham')
                    ->whereNotIn('id',$nglieu)
                    ->get();
        }
        return view('backend.thongtin.sua',compact('thongtin','sanpham1','sanpham2'));
    }

    public function postEdit(thongtinEditRequest $request,$id)
    {
    	$fImage = $request->fImage;
        $img_current = '/resources/upload/thongtin/'.$request->fImageCurrent;
        if (!empty($fImage )) {
             $filename=$fImage ->getClientOriginalName();
             DB::table('thongtin')->where('id',$id)
                            ->update([
                                'thongtin_tieu_de'   => $request->txtMNTittle,
                                'thongtin_tom_tat'           => $request->txtMNResum,
                                'thongtin_noi_dung' => $request->txtMNContent,
                                'thongtin_url'   => Replace_TiengViet($request->txtMNTittle),
                                'thongtin_anh'=> $filename
                                ]);
             $fImage ->move(base_path() . '/resources/upload/thongtin/', $filename);
             File::delete($img_current);
        } else {
            DB::table('thongtin')->where('id',$id)
                            ->update([
                                'thongtin_tieu_de'   => $request->txtMNTittle,
                                'thongtin_tom_tat'           => $request->txtMNResum,
                                'thongtin_noi_dung' => $request->txtMNContent,
                                'thongtin_url'   => Replace_TiengViet($request->txtMNTittle)
                                ]);
        }
        
        DB::table('nguyenlieu')->where('thongtin_id',$id)->delete();
        $data = $request->input('products',[]);
        foreach ($data as  $item) {
            $nguyenlieu = new Nguyenlieu;
            $nguyenlieu->sanpham_id = $item;
            $nguyenlieu->thongtin_id = $id;
            $nguyenlieu->save();
        }
        return redirect()->route('admin.thongtin.list')->with(['flash_level'=>'success','flash_message'=>'Edit thành công!!!']);
    }

    public function getEditMaterial($id)
    {
        $nguyenlieu = DB::table('nguyenlieu')->select('sanpham_id')->where('thongtin_id',$id)->get();
        foreach ($nguyenlieu as $key => $val) {
            $nglieu[] = $val->sanpham_id;
        }
        if (!empty($nglieu)) {
        
            $sanpham1 = DB::table('sanpham')
                    ->whereIn('id',$nglieu)
                    ->get();
        } else {
            $sanpham1 = DB::table('sanpham')
                    ->whereIn('id',['0'])
                    ->get();
        }

        if (empty($nglieu)) {
            $sanpham2 = DB::table('sanpham')
                    ->whereNotIn('id',['0'])
                    ->get();
        } else {
            $sanpham2 = DB::table('sanpham')
                    ->whereNotIn('id',$nglieu)
                    ->get();
        }
        return view('backend.thongtin.suanguyenlieu',compact('sanpham1','sanpham2'));
    }

    public function postEditMaterial(Request $request,$id)
    {
        DB::table('nguyenlieu')->where('thongtin_id',$id)->delete();
        $data = $request->input('products',[]);
        foreach ($data as  $item) {
            $nguyenlieu = new Nguyenlieu;
            $nguyenlieu->sanpham_id = $item;
            $nguyenlieu->thongtin_id = $id;
            $nguyenlieu->save();
        }
        return redirect()->route('admin.thongtin.list')->with(['flash_level'=>'success','flash_message'=>'Edit thành công!!!']);
    }

    public function getAddMaterial()
    {
        $sanpham = DB::table('sanpham')->orderBy('id','DESC')->get();
        return view('backend.thongtin.themnguyenlieu',compact('sanpham'));
    }

    public function postAddMaterial(Request $request)
    {
        $data = $request->input('products',[]);
        foreach ($data as  $item) {
            //print_r($item);
            $nguyenlieu = new Nguyenlieu;
            $nguyenlieu->sanpham_id = $item;
            $nguyenlieu->thongtin_id = $request->txtID;
            $nguyenlieu->save();
        }
        return redirect()->route('admin.thongtin.list')->with(['flash_level'=>'success','flash_message'=>'Thêm thành công!!!']);
    }

    public function listMat($id)
    {
        $data =  DB::table('nguyenlieu')->where('thongtin_id',$id)->orderBy('id','DESC')->get();
        return view('backend.thongtin.danhsachnglieu',compact('data'));
    }
}
