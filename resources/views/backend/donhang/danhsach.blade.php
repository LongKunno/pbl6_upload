@extends('backend.master')
@section('title')
    <h3 class="page-header">
        Đơn hàng
    </h3>
@stop
@section('content')               
<div class="panel panel-default">
<div class="panel-heading" style="height: 50px;">
    <b><i>Danh sách đơn hàng</i></b>
    <button id="button_chuyendoitrangthaidonhang" type="button" class="btn btn-outline-success" style="color: white;border-color: #204d74;background-color: #3774a9;float:right;height:30px;">Xác nhận</button>
    <select id="select_tintrangdonhang" class="form-control" style="width: 200px;float:right;height:30px;margin-right:30px;">
        <?php
        echo '<option value="">-- Tình trạng đơn hàng --</option>';
        foreach ($order_status as $option) {
            echo '<option value="' . $option["id"] . '">' . $option["name"] . '</option>';
        }
        ?>
    </select>
</div>
<!-- /.panel-heading -->
<div class="panel-body">
<div class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <br>
        <div class="dataTable_wrapper">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr align="center">
                    <th></th>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt hàng</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($data as $item)
                <tr class="odd gradeX">
                    <td><input type="checkbox" id="checkbox_donhang" name="checkbox_donhang" value="{!! $item->id !!}"></td>
                    <td>{!! $item->id !!}</td>
                    <td>{!! $item->name !!}</td>
                    <td>{!! $item->orderStatus !!}</td>
                    <td>{!! $item->totalProductAmount !!}</td>
                    <td>{!! $item->orderDate !!}</td>
                    
                    <td align="center">
                    <a href="{!! URL::route('admin.donhang.getEdit1', $item->id ) !!}" 
                        type="button" class="btn btn-primary" 
                        data-toggle="tooltip" data-placement="left" 
                        title="Thông tin chi tiết">
                        <i class="fa fa-crosshairs"></i>
                    </a>
                    <a href="{!! URL::route('admin.donhang.pdf', $item->id ) !!}" 
                       type="button" class="btn btn-default" 
                       data-toggle="tooltip" data-placement="left" 
                       title="In hóa đơn">
                        <i class="fa fa-print"></i>
                    </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        </div>

        </div>
        </div>

    <!-- /.row -->
</div>
</div>
<script>
    $(document).ready(function(){
        $("#button_chuyendoitrangthaidonhang").click(function(){
            var selectedCheckboxes = $('input[type="checkbox"]:checked');
            var selectedValues = [];
            selectedCheckboxes.each(function() {
                var value = $(this).val();
                selectedValues.push(value);
            });
            if($("#select_tintrangdonhang").val()!=""){
                // Gửi yêu cầu Ajax
                $.ajax({
                    method: "PUT",
                    url: 'https://pbl6shopfashion-production.up.railway.app/api/orders?orderStatus='+$("#select_tintrangdonhang").val(),
                    contentType: "application/json",
                    data: JSON.stringify(selectedValues),
                    success: function(response){
                        $('#loading').hide();
                        console.log(response);
                        alert("Thành công!");
                        location.reload();
                    },
                    error: function(response){
                        $('#loading').hide();
                        console.log(response.responseText);
                        alert("Thất bại!");
                    }
                })     
            }
        })
    })
</script>
@stop
