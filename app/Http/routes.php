<?php

// Route::get('/', function () {
//     return view('frontend.master');
// });

// Route::controllers([
//  'auth' => 'Auth\AuthController',
//  'password' => 'Auth\PasswordController',
// ]);


// // Authentication Routes...
// $this->get('login', 'Auth\AuthController@showLoginForm');
// $this->post('postlogin', 'Auth\AuthController@login');
// $this->get('logout', 'Auth\AuthController@logout');


// // Registration Routes...
// $this->get('register', 'Auth\AuthController@showRegistrationForm');
// $this->post('register', 'Auth\AuthController@register');

// // Password Reset Routes...
// $this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
// $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
// $this->post('password/reset', 'Auth\PasswordController@reset');




Route::get('/demo2', 'HomeController@demo2');
Route::get('/demo3', 'HomeController@demo3');

Route::get('logout', 'HomeController@logout');

Route::get('login', 'HomeController@login');

Route::post('postlogin', 'HomeController@postlogin');

Route::get('getregister', 'HomeController@getregister');

Route::post('postregister', 'HomeController@postregister');

Route::get('forgot-password', 'HomeController@forgotpassword');

Route::post('forgot-password', 'HomeController@postforgotpassword');

Route::get('forgot-password-otp', 'HomeController@forgot_password_otp');

Route::post('forgot-password-otp', 'HomeController@post_forgot_password_otp');

Route::get('update-imformation', 'HomeController@get_update_imformation');

Route::post('post-update-imformation', 'HomeController@post_update_imformation');

Route::get('hien-san-pham/{id}','HomeController@hiensanpham');

Route::get('/', 'HomeController@index')->name('home');

Route::get('nhom-san-pham/{url_id}', 'HomeController@group');

Route::get('loai-san-pham/{id_category}/{id_brand}', 'HomeController@cates');

Route::get('thong-tin', 'HomeController@thongtin');

Route::get('tuyen-dung', 'HomeController@career');

Route::get('lien-he', 'HomeController@getContact');

Route::post('lien-he', 'HomeController@postContact');

Route::get('khuyen-mai', 'HomeController@promotions');

Route::get('khuyen-mai/{url}', 'HomeController@detailpromotions');

Route::get('thong-tin/{url}', 'HomeController@detailthongtin');

Route::get('san-pham/{url_id}', 'HomeController@product');

Route::get('mua-hang/{id}/{size}',['as'=>'muahang','uses'=>'HomeController@buyding']);

Route::get('order',['as'=>'order','uses'=>'HomeController@orderpage']);

Route::get('gio-hang',['as'=>'giohang','uses'=>'HomeController@cart']);

Route::get('xoa-san-pham/{id}',['as'=>'xoasanpham','uses'=>'HomeController@deleteProduct']);

Route::get('cap-nhat-san-pham/{id}',['as'=>'capnhat','uses'=>'HomeController@updateProduct']);

Route::get('thanh-toan',['as'=>'getThanhtoan','uses'=>'HomeController@getCheckin']);

Route::post('thanh-toan',['as'=>'postThanhtoan','uses'=>'HomeController@postCheckin']);

Route::post('binh-luan',['as'=>'postBinhluan','uses'=>'HomeController@postComment']);

Route::get('ket-qua-tim-kiem',['as'=>'getTimkiem','uses'=>'HomeController@getFind']);

Route::post('ket-qua-tim-kiem',['as'=>'postTimkiem','uses'=>'HomeController@postFind']);
// Route::post('khach-hang',['as'=>'postKhachhang','uses'=>'AuthController@postCustomer']);

// Route Backend
Route::group(['prefix' => 'admin'], function() {
    Route::get('bang-dieu-khien', ['as'=>'admin.index','uses'=>'AdminController@index']);
    Route::group(['prefix' => 'loaisanpham'], function() {
    	Route::get('danhsach',['as'=>'admin.loaisanpham.list','uses'=>'LoaisanphamController@getList']);
        Route::get('them',['as'=>'admin.loaisanpham.getAdd','uses'=>'LoaisanphamController@getAdd']);
        Route::post('them',['as'=>'admin.loaisanpham.postAdd','uses'=>'LoaisanphamController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.loaisanpham.getDelete','uses'=>'LoaisanphamController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.loaisanpham.getEdit','uses'=>'LoaisanphamController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.loaisanpham.postEdit','uses'=>'LoaisanphamController@postEdit']);
    });

    Route::group(['prefix' => 'nhom'], function() {
        Route::get('danhsach',['as'=>'admin.nhom.list','uses'=>'NhomController@getList']);
        Route::get('them',['as'=>'admin.nhom.getAdd','uses'=>'NhomController@getAdd']);
        Route::post('them',['as'=>'admin.nhom.postAdd','uses'=>'NhomController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.nhom.getDelete','uses'=>'NhomController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.nhom.getEdit','uses'=>'NhomController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.nhom.postEdit','uses'=>'NhomController@postEdit']);
    });

    Route::group(['prefix' => 'donvitinh'], function() {
        Route::get('danhsach',['as'=>'admin.donvitinh.list','uses'=>'DonvitinhController@getList']);
        Route::get('them',['as'=>'admin.donvitinh.getAdd','uses'=>'DonvitinhController@getAdd']);
        Route::post('them',['as'=>'admin.donvitinh.postAdd','uses'=>'DonvitinhController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.donvitinh.getDelete','uses'=>'DonvitinhController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.donvitinh.getEdit','uses'=>'DonvitinhController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.donvitinh.postEdit','uses'=>'DonvitinhController@postEdit']);
    });

    Route::group(['prefix' => 'lohang'], function() {
        Route::get('danhsach',['as'=>'admin.lohang.list','uses'=>'LohangController@getList']);
        Route::get('them',['as'=>'admin.lohang.getAdd','uses'=>'LohangController@getAdd']);
        Route::post('them',['as'=>'admin.lohang.postAdd','uses'=>'LohangController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.lohang.getDelete','uses'=>'LohangController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.lohang.getEdit','uses'=>'LohangController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.lohang.postEdit','uses'=>'LohangController@postEdit']);
        Route::get('nhap-hang/{id}',['as'=>'admin.lohang.getNhaphang','uses'=>'LohangController@getNhaphang']);
        Route::post('nhap-hang/{id}',['as'=>'admin.lohang.postNhaphang','uses'=>'LohangController@postNhaphang']);
    });

    Route::group(['prefix' => 'voucher'], function() {
    	Route::get('danhsach',['as'=>'admin.voucher.list','uses'=>'voucherController2@getList']);
        Route::get('them',['as'=>'admin.voucher.getAdd','uses'=>'voucherController2@getAdd']);
        Route::post('them',['as'=>'admin.voucher.postAdd','uses'=>'voucherController2@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.voucher.getDelete','uses'=>'voucherController2@getDelete']);
        Route::post('xoa/{id}',['as'=>'admin.voucher.postDelete','uses'=>'voucherController2@postDelete']);
        Route::get('sua/{id}',['as'=>'admin.voucher.getEdit','uses'=>'voucherController2@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.voucher.postEdit','uses'=>'voucherController2@postEdit']);
    });

    Route::group(['prefix' => 'tuyendung'], function() {
        Route::get('danhsach',['as'=>'admin.tuyendung.list','uses'=>'TuyendungController@getList']);
        Route::get('them',['as'=>'admin.tuyendung.getAdd','uses'=>'TuyendungController@getAdd']);
        Route::post('them',['as'=>'admin.tuyendung.postAdd','uses'=>'TuyendungController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.tuyendung.getDelete','uses'=>'TuyendungController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.tuyendung.getEdit','uses'=>'TuyendungController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.tuyendung.postEdit','uses'=>'TuyendungController@postEdit']);
    });

    Route::group(['prefix' => 'khachhang'], function() {
        Route::get('danhsach',['as'=>'admin.khachhang.list','uses'=>'KhachhangController@getList']);
        Route::get('them',['as'=>'admin.khachhang.getAdd','uses'=>'KhachhangController@getAdd']);
        Route::post('them',['as'=>'admin.khachhang.postAdd','uses'=>'KhachhangController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.khachhang.getDelete','uses'=>'KhachhangController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.khachhang.getEdit','uses'=>'KhachhangController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.khachhang.postEdit','uses'=>'KhachhangController@postEdit']);
        Route::get('xem-lich-su-mua-hang/{id}',['as'=>'admin.khachhang.getHistory','uses'=>'KhachhangController@getHistory']);
    });

    Route::group(['prefix' => 'thongtin'], function() {
        Route::get('danhsach',['as'=>'admin.thongtin.list','uses'=>'thongtinController@getList']);
        Route::get('them',['as'=>'admin.thongtin.getAdd','uses'=>'thongtinController@getAdd']);
        Route::post('them',['as'=>'admin.thongtin.postAdd','uses'=>'thongtinController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.thongtin.getDelete','uses'=>'thongtinController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.thongtin.getEdit','uses'=>'thongtinController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.thongtin.postEdit','uses'=>'thongtinController@postEdit']);
        Route::get('them-nguyen-lieu',['as'=>'admin.thongtin.getAddMaterial','uses'=>'thongtinController@getAddMaterial']);
        Route::post('them-nguyen-lieu',['as'=>'admin.thongtin.postAddMaterial','uses'=>'thongtinController@postAddMaterial']);
        Route::get('sua-nguyen-lieu/{id}',['as'=>'admin.thongtin.getEditMaterial','uses'=>'thongtinController@getEditMaterial']);
        Route::post('sua-nguyen-lieu/{id}',['as'=>'admin.thongtin.postEditMaterial','uses'=>'thongtinController@postEditMaterial']);
        Route::post('ds-nguyen-lieu/{id}',['as'=>'admin.thongtin.listMat','uses'=>'thongtinController@listMat']);
    });

    Route::group(['prefix' => 'nhanvien'], function() {
        Route::get('danhsach',['as'=>'admin.nhanvien.list','uses'=>'NhanvienController@getList']);
        Route::get('them',['as'=>'admin.nhanvien.getAdd','uses'=>'NhanvienController@getAdd']);
        Route::post('them',['as'=>'admin.nhanvien.postAdd','uses'=>'NhanvienController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.nhanvien.getDelete','uses'=>'NhanvienController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.nhanvien.getEdit','uses'=>'NhanvienController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.nhanvien.postEdit','uses'=>'NhanvienController@postEdit']);
    });

    Route::group(['prefix' => 'sanpham'], function() {
        Route::get('danhsach',['as'=>'admin.sanpham.list','uses'=>'SanphamController@getList']);
        Route::get('them',['as'=>'admin.sanpham.getAdd','uses'=>'SanphamController@getAdd']);
        Route::post('them',['as'=>'admin.sanpham.postAdd','uses'=>'SanphamController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.sanpham.getDelete','uses'=>'SanphamController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.sanpham.getEdit','uses'=>'SanphamController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.sanpham.postEdit','uses'=>'SanphamController@postEdit']);
        Route::get('xoahinh/{id}',['as'=>'admin.sanpham.delImage','uses'=>'SanphamController@delImage']);
    });

    Route::group(['prefix' => 'khuyenmai'], function() {
        Route::get('danhsach',['as'=>'admin.khuyenmai.list','uses'=>'KhuyenmaiController@getList']);
        Route::get('them',['as'=>'admin.khuyenmai.getAdd','uses'=>'KhuyenmaiController@getAdd']);
        Route::post('them',['as'=>'admin.khuyenmai.postAdd','uses'=>'KhuyenmaiController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.khuyenmai.getDelete','uses'=>'KhuyenmaiController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.khuyenmai.getEdit','uses'=>'KhuyenmaiController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.khuyenmai.postEdit','uses'=>'KhuyenmaiController@postEdit']);
        Route::get('them-san-pham-km',['as'=>'admin.khuyenmai.getAddPromotion','uses'=>'KhuyenmaiController@getAddPromotion']);
        Route::post('them-san-pham-km',['as'=>'admin.khuyenmai.postAddPromotion','uses'=>'KhuyenmaiController@postAddPromotion']);
        Route::get('sua-san-pham-km/{id}',['as'=>'admin.khuyenmai.getEditPromotion','uses'=>'KhuyenmaiController@getEditPromotion']);
        Route::post('sua-san-pham-km/{id}',['as'=>'admin.khuyenmai.postEditPromotion','uses'=>'KhuyenmaiController@postEditPromotion']);
    });

    Route::group(['prefix' => 'binhluan'], function() {
        Route::get('danhsach',['as'=>'admin.binhluan.list','uses'=>'BinhluanController@getList']);
        Route::get('xoa/{id}',['as'=>'admin.binhluan.getDelete','uses'=>'BinhluanController@getDelete']);
        Route::get('chap-nhan/{id}',['as'=>'admin.binhluan.getEdit','uses'=>'BinhluanController@getEdit']);
        Route::get('khong-chap-nhan/{id}',['as'=>'admin.binhluan.getEdit1','uses'=>'BinhluanController@getEdit1']);
    });

    Route::group(['prefix' => 'donhang'], function() {
        Route::get('danhsach',['as'=>'admin.donhang.list','uses'=>'DonhangController@getList']);
        Route::get('xem-don-hang/{id}',['as'=>'admin.donhang.getEdit','uses'=>'DonhangController@getEdit']);
        Route::post('xem-don-hang/{id}',['as'=>'admin.donhang.postEdit','uses'=>'DonhangController@postEdit']);
        Route::get('sua-thong-tin-giao-hang/{id}',['as'=>'admin.donhang.getEdit1','uses'=>'DonhangController@getEdit1']);
        Route::post('sua-thong-tin-giao-hang/{id}',['as'=>'admin.donhang.postEdit1','uses'=>'DonhangController@postEdit1']);
        Route::get('sua-thong-tin-thanh-toan/{id}',['as'=>'admin.donhang.getEdit2','uses'=>'DonhangController@getEdit2']);
        Route::post('sua-thong-tin-thanh-toan/{id}',['as'=>'admin.donhang.postEdit2','uses'=>'DonhangController@postEdit2']);
        Route::get('in-hoa-don/{id}',['as'=>'admin.donhang.pdf','uses'=>'DonhangController@pdf']);
    });

    Route::group(['prefix' => 'thongke'], function() {
        Route::get('tong-quan',['as'=>'admin.thongke.list','uses'=>'ThongkeController@getList']);
        Route::get('san-pham-nhap-vao',['as'=>'admin.thongke.nhapvao','uses'=>'ThongkeController@getNhapvao']);
        Route::get('san-pham-ban-ra',['as'=>'admin.thongke.banra','uses'=>'ThongkeController@getBanra']);
        Route::get('san-pham-hien-co',['as'=>'admin.thongke.hienco','uses'=>'ThongkeController@getHienco']);
        Route::get('san-pham-doi-tra',['as'=>'admin.thongke.doitra','uses'=>'ThongkeController@getDoitra']);
        Route::get('san-pham-ban-chay',['as'=>'admin.thongke.banchay','uses'=>'ThongkeController@getBanchay']);
        Route::get('san-pham-ton-nhieu',['as'=>'admin.thongke.tonnhieu','uses'=>'ThongkeController@getTonnhieu']);
        Route::get('san-pham-het-han',['as'=>'admin.thongke.hethan','uses'=>'ThongkeController@getHethan']);
        Route::get('san-pham-con-han',['as'=>'admin.thongke.conhan','uses'=>'ThongkeController@getConhan']);
    });

    Route::group(['prefix' => 'quangcao'], function() {
        Route::get('danhsach',['as'=>'admin.quangcao.list','uses'=>'QuangcaoController@getList']);
        Route::get('them',['as'=>'admin.quangcao.getAdd','uses'=>'QuangcaoController@getAdd']);
        Route::post('them',['as'=>'admin.quangcao.postAdd','uses'=>'QuangcaoController@postAdd']);
        Route::get('xoa/{id}',['as'=>'admin.quangcao.getDelete','uses'=>'QuangcaoController@getDelete']);
        Route::get('sua/{id}',['as'=>'admin.quangcao.getEdit','uses'=>'QuangcaoController@getEdit']);
        Route::post('sua/{id}',['as'=>'admin.quangcao.postEdit','uses'=>'QuangcaoController@postEdit']);
        Route::get('cap-nhat/{id}/{status}',['as'=>'admin.quangcao.getChance','uses'=>'QuangcaoController@getChance']);
    });
});

// Password reset link request routes...
Route::get('admin/login',['as'=>'admin.login.getLogin','uses'=>'Auth\AuthController@getLogin']);
Route::post('admin/login',['as'=>'admin.login.postLogin','uses'=>'Auth\AuthController@postLogin']);
Route::get('admin/logout',['as'=>'admin.login.getLogout','uses'=>'Auth\AuthController@getLogout']);


//Truyền Api
Route::get('/api', 'HomeController@api_index');
Route::get('/api/nhom-san-pham/{url}', 'HomeController@api_group');
Route::get('api/loai-san-pham/{url}', 'HomeController@api_cates');
Route::get('/api/thong-tin', 'HomeController@api_thongtin');
Route::get('/api/thong-tin/{url}', 'HomeController@api_detailthongtin');
Route::get('/api/khuyen-mai', 'HomeController@api_promotions');
Route::get('/testapi', 'HomeController@testapi');