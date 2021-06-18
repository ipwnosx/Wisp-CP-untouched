<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("PRODUCTS_OPERATION");
        $plugins        = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <style type="text/css">
        #datatable tbody tr td:nth-child(1),#datatable tbody tr td:nth-child(5) {text-align: left;}
    </style>
    <script>
        var table;
        $(document).ready(function() {
            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    },
                    {
                        "targets": [1,2,3,4,5,6,7],
                        "orderable": false
                    }
                ],
                "aaSorting" : [[0, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-origins"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function open_long_msg(id){
            var div = $("#"+id);

            open_modal("long_msg_modal",{title:div.data("title")});
            $("#long_msg_content").html(div.html());

        }
    </script>

</head>
<body>


<div id="long_msg_modal" style="display: none;">
    <div id="long_msg_content"></div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/products/page-sms-origins"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>
            <br>

            <div id="editOrigin" style="display: none;" data-izimodal-title="Başlık Düzenle">
                <div class="padding20">

                    <form action="<?php echo $links["orders"]; ?>" method="post" id="editOrigin" enctype="multipart/form-data">
                        <input type="hidden" name="operation" value="update_sms_origin">
                        <input type="hidden" name="oid" id="origin_id" value="">

                        <div class="formcon">
                            <div class="yuzde30">Durum</div>
                            <div class="yuzde70">

                                <input type="radio" name="status" value="waiting" class="radio-custom" id="origin_status_waiting">
                                <label class="radio-custom-label" for="origin_status_waiting" style="margin-right: 15px;">Onay Bekliyor</label>

                                <input type="radio" name="status" value="active" class="radio-custom" id="origin_status_active">
                                <label class="radio-custom-label" for="origin_status_active" style="margin-right: 15px;">Aktif</label>
                                <input type="radio" name="status" value="inactive" class="radio-custom" id="origin_status_inactive">
                                <label class="radio-custom-label" for="origin_status_inactive" style="margin-right: 15px;">Pasif</label>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">Başlık</div>
                            <div class="yuzde70">
                                <input type="text" name="name" value="" id="origin_name">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">Açıklama</div>
                            <div class="yuzde70">
                                <select onchange="$('#origin_status_message').val($(this).val());">
                                    <option value="">--Şablon Seçiniz--</option>
                                    <?php
                                        if(___("constants/category-sms/op_notes")){
                                            foreach(___("constants/category-sms/op_notes") AS $item){
                                                ?><option value="<?php echo htmlentities($item["description"],ENT_QUOTES); ?>"><?php echo $item["title"];?></option><?php
                                            }
                                        }
                                    ?>
                                </select>
                                <textarea name="status_message" value="" id="origin_status_message"></textarea>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">Evrak Yükle</div>
                            <div class="yuzde70">
                                <input id="origin_attachments" name="attachments[]" type="file" multiple>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">Oluşturma Tarihi</div>
                            <div class="yuzde70">
                                <input style="width: 200px;" id="origin_cdate" name="cdate" type="datetime-local" placeholder="Yıl-Ay-Gün Saat:Dakika">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">Onaylanma Tarihi</div>
                            <div class="yuzde70">
                                <input style="width: 200px;" id="origin_approved_date" name="approwed_date" type="datetime-local" placeholder="Yıl-Ay-Gün Saat:Dakika">
                            </div>
                        </div>

                        <?php if($privOperation): ?>
                            <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
                                <a id="editOrigin_submit" class="yesilbtn gonderbtn" href="javascript:void(0);"><?php echo __("admin/orders/update-button"); ?></a>
                            </div>
                        <?php endif; ?>

                    </form>
                    <script type="text/javascript">
                        $(document).ready(function(){

                            $("#editOrigin_submit").on("click",function(){
                                MioAjaxElement($(this),{
                                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                    result:"editOrigin_handler",
                                });
                            });

                        });

                        function editOrigin_handler(result){
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#editOrigin "+solve.for).focus();
                                            $("#editOrigin "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#editOrigin "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }
                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,{timer:5000});
                                    }else if(solve.status == "successful"){
                                        alert_success(solve.message,{timer:2000});
                                        table.ajax.reload();
                                    }
                                }else
                                    console.log(result);
                            }
                        }
                    </script>

                </div>
            </div>

            <script type="text/javascript">
                function editOrigin(id){
                    open_modal("editOrigin");
                    var status          = $("#origin_"+id+"_status").val();
                    var name            = $("#origin_"+id+"_name").val();
                    var status_message  = $("#origin_"+id+"_status_message").val();
                    var cdate           = $("#origin_"+id+"_cdate").val();
                    var approved_date   = $("#origin_"+id+"_approved_date").val();

                    $("#origin_id").val(id);
                    $("#editOrigin input[name=status]").prop("checked",false);
                    $("#origin_status_"+status).prop("checked",true);
                    $("#origin_name").val(name);
                    $("#origin_status_message").val(status_message);
                    $("#origin_cdate").val(cdate);
                    $("#origin_approved_date").val(approved_date);
                }

                function deleteOrigin(id){

                    swal({
                        title: 'Başlık Sil',
                        text: "Başlığı gerçekten silmek istiyor musunuz?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet',
                        cancelButtonText: 'Hayır'
                    }).then(function(){

                        var request = MioAjax({
                            action:"<?php echo $links["orders"];?>",
                            method:"POST",
                            data:{operation:"status_sms_origin",id:id,status:"delete"}
                        },true,true);

                        request.done(function(res){
                            if(res != ''){
                                var solve = getJson(res);
                                if(solve && typeof solve == "object"){
                                    if(solve.status == "error"){
                                        swal({
                                            title: 'Hata!',
                                            text: solve.message,
                                            type: 'error',
                                            showConfirmButton: false,
                                            timer: 3000,
                                        });
                                    }else if(solve.status == "successful"){
                                        var timer = 1500;
                                        swal({
                                            title: 'Silindi',
                                            text: 'Başlık başarıyla silinmiştir.',
                                            type: 'success',
                                            showConfirmButton: false,
                                            timer: timer,
                                        });
                                        table.ajax.reload();
                                    }
                                }else
                                    console.log(res);
                            }
                        });
                    });

                }

                function inactiveOrigin(id){

                    swal({
                        title: 'Başlığı Pasif Et',
                        type: 'info',
                        html:
                        '<p>Açıklama: (İsteğe bağlı)</p>'+
                        '<select onchange="$(\'#notu\').val($(this).val());">'+
                        '<option value="">--Şablon Seçiniz--</option>'+
                        <?php
                            if(___("constants/category-sms/op_notes")){
                            foreach(___("constants/category-sms/op_notes") AS $item){
                            ?>'<option value="<?php echo htmlentities($item["description"], ENT_QUOTES); ?>"><?php echo $item["title"];?></option>'+<?php echo "\n";
                        }
                        }
                        ?>
                        '</select>'+
                        '<textarea rows="4" id="notu"></textarea>',
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: false,
                        confirmButtonText: 'Pasif Et',
                        cancelButtonText: 'İptal',
                    }).then(function(){

                        var notu = $("#notu").val();

                        var request = MioAjax({
                            action:"<?php echo $links["orders"];?>",
                            method:"POST",
                            data:{
                                operation:"status_sms_origin",
                                id:id,
                                status:"inactive",
                                note:notu,
                            }
                        },true,true);

                        request.done(function(res){
                            if(res != ''){
                                var solve = getJson(res);
                                if(solve && typeof solve == "object"){
                                    if(solve.status == "error"){
                                        swal({
                                            title: 'Hata!',
                                            text: solve.message,
                                            type: 'error',
                                            showConfirmButton: false,
                                            timer: 3000,
                                        });
                                    }else if(solve.status == "successful"){
                                        var timer = 1500;
                                        swal({
                                            title: 'Pasif Edildi',
                                            text: 'Başlık başarıyla pasif edilmiştir.',
                                            type: 'success',
                                            showConfirmButton: false,
                                            timer: timer,
                                        });
                                        table.ajax.reload();
                                    }
                                }else
                                    console.log(res);
                            }
                        });

                    });

                }

                function activeOrigin(id){
                    var request = MioAjax({
                        action:"<?php echo $links["orders"];?>",
                        method:"POST",
                        data:{operation:"status_sms_origin",id:id,status:"active"}
                    },true,true);

                    request.done(function(res){
                        if(res != ''){
                            var solve = getJson(res);
                            if(solve && typeof solve == "object"){
                                if(solve.status == "error"){
                                    swal({
                                        title: 'Hata!',
                                        text: solve.message,
                                        type: 'error',
                                        showConfirmButton: false,
                                        timer: 3000,
                                    });
                                }else if(solve.status == "successful"){
                                    var timer = 1500;
                                    swal({
                                        title: 'Onaylandı',
                                        text: 'Başlık başarıyla onaylanmıştır.',
                                        type: 'success',
                                        showConfirmButton: false,
                                        timer: timer,
                                    });
                                    table.ajax.reload();
                                }
                            }else
                                console.log(res);
                        }
                    });
                }
            </script>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left">Müşteri</th>
                    <th align="center">Sipariş</th>
                    <th align="center">Başlık Bilgisi</th>
                    <th align="center">Evraklar</th>
                    <th align="left">Açıklama</th>
                    <th align="center">Durum</th>
                    <th align="center">İşlem</th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;"></tbody>
            </table>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>