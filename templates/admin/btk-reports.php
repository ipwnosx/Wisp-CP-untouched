<!DOCTYPE html>
<html>
<head>
    <?php
        $search_query   = [];
        if(isset($start) && $start) $search_query["start"] = $start;
        if(isset($end) && $end) $search_query["end"] = $end;
        if(isset($type) && $type) $search_query["type"] = $type;
        $search_query   = http_build_query($search_query);

        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                    },
                ],
                "pageLength": 30,
                "bLengthChange" : false,
                "bInfo":false,
                "searching": false,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax"]; echo $search_query ?  "?".$search_query : ''; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong>BTK Rapor Yönetimi</strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

           

            <div class="clear"></div>


<div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p>Bilgi Teknolojileri ve İletişim Kurumu'nda yer sağlayıcı statüsünde kayıtlı bulunan kuruluşlar için, barındırdığı ve/veya tescil ettirdiği alan adlarına ait bilgileri ayrı ayrı CSV dosya formatında hazırlayıp https://ysb.btk.gov.tr adresinden bildirim esnasında oluşturduğu  kullanıcı adı ve şifresini kullanarak (Alan Adı Bilgi Dosyasını Yükle) linkinden her ayın ilk haftasında düzenli olarak sisteme yüklemesi gerekmektedir. Aşağıdaki alan üzerinden ilgili raporlarınızı oluşturup çıktı alarak, gerekli yükleme işlemini kolaylıkla sağlayabilirsiniz.</p>
                                </div>
                            </div>

                            <div class="clear"></div>


            
            <form action="<?php echo $links["controller"]; ?>" method="get" id="searchForm">
                <input type="hidden" name="create" value="true">
            	<div class="formcon">
            		<div class="yuzde30">
            			Tarih Aralığı
            		</div>
            		<div class="yuzde70">
            			<?php echo __("admin/invoices/bills-search-start-date"); ?>
                <input class="width200" name="start" type="date" value="<?php echo isset($start) ? $start : ''; ?>">
                <?php echo __("admin/invoices/bills-search-end-date"); ?>
                <input class="width200" name="end" type="date" value="<?php echo isset($end) ? $end : ''; ?>">
            		</div>
            	</div>

            	<div class="formcon">
            		<div class="yuzde30">
            			Rapor Türü
            		</div>
            		<div class="yuzde70">
            			<input<?php echo !isset($type) || $type == 1 ? ' checked' : ''; ?> type="radio" name="type" value="1" id="type_1" class="radio-custom">
                <label style="margin-right: 10px;margin-bottom:5px; " for="type_1" class="radio-custom-label">Barındırılan Alan Adları ve Hostingler</label>
                <br>
                <input<?php echo isset($type) && $type == 2 ? ' checked' : ''; ?> type="radio" name="type" value="2" id="type_2" class="radio-custom">
                <label style="margin-right: 10px; " for="type_2" class="radio-custom-label">Sadece Alan Adı Kaydı</label>            		
            		</div>
            	</div>

            	<div class="formcon">
            		<div class="yuzde30">
            			
            		</div>
            		<div class="yuzde70">
            			<a href="javascript:$('#searchForm').submit();void 0;" title="" class="lbtn">Rapor Oluştur</a>      		
            		</div>
            	</div>

            </form>

            <div class="clear"></div>

            <?php if(Filter::GET("create")): ?>
                <div class="kdvinfo">
                    <h5 style="margin-top: 5px;">Seçilen Kriterlerde <strong><?php echo $filteredTotal; ?></strong> Adet Sonuç Bulundu.</h5>

                    <?php if($filteredTotal): ?>
                        <div class="faturalinks" style="float:right;width:auto;">
                            <a target="_blank" href="<?php echo $links["csv-export"]."?".$search_query; ?>" id="gelarama" class="blue lbtn">CSV Çıktı Al</a>
                        </div>
                    <?php endif; ?>
                </div>

                <br>
                <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="left">#</th>
                        <th align="center" data-orderable="false">Alan Adı</th>
                        <th align="center" data-orderable="false">Sahibi</th>
                        <th align="center" data-orderable="false">Telefon</th>
                        <th align="center" data-orderable="false">E-Posta</th>
                        <th align="center" data-orderable="false">Tescil Tarihi</th>
                        <th align="center" data-orderable="false">Tescil Bitiş Tarihi</th>
                        <th align="center" data-orderable="false">Açıklama</th>
                    </tr>
                    </thead>
                    <tbody align="center" style="border-top:none;"></tbody>
                </table>
            <?php endif; ?>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>