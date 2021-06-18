<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");

        $plugins    = ['dataTables','dataTables-buttons','jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var list_table;

        $(document).ready(function(){
            list_table = $('#list_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }
                ],
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

            changeDateRange(document.getElementById("DateRange"));

        });

        function changeDateRange(element){
            var selection = $(element).val(),from_date,to_date;

            if(selection === 'custom' && '<?php echo $filter_range; ?>' !== 'custom'){
                $("#DateFrom").val('').focus().removeAttr("readonly");
                $("#DateTo").val('').removeAttr("readonly");
            }else{

                from_date   = '<?php echo $filter_from; ?>';
                to_date     = '<?php echo $filter_to; ?>';

                $("#DateFrom").attr("required",true);
                $("#DateTo").attr("required",true);

                if(selection === 'last_7_days'){
                    from_date = '<?php echo DateManager::old_date(['week' => 1],'Y-m-d'); ?>';
                    to_date = '<?php echo DateManager::Now('Y-m-d'); ?>';
                }else if(selection === 'this_month'){
                    from_date = '<?php echo DateManager::Now("Y-m")."-01"; ?>';
                    to_date = '<?php echo DateManager::Now('Y-m-d'); ?>';
                }else if(selection === 'last_month'){
                    from_date = '<?php echo DateManager::old_date(['month' => 1],"Y-m")."-01"; ?>';
                    to_date = '<?php echo DateManager::old_date(['month' => 1],"Y-m-t"); ?>';
                }else if(selection === 'this_year'){
                    from_date = '<?php echo DateManager::Now("Y")."-01-01"; ?>';
                    to_date = '<?php echo DateManager::Now("Y-12-t"); ?>';
                }else if(selection === 'last_year'){
                    from_date = '<?php echo DateManager::old_date(['year' => 1],"Y")."-01-01"; ?>';
                    to_date = '<?php echo DateManager::old_date(['year' => 1],"Y-12-t"); ?>';
                }else if(selection === 'all_times'){
                    from_date = '';
                    to_date = '';
                }else{
                    $("#DateFrom").attr("required",false);
                    $("#DateTo").attr("required",false);
                }

                if(selection === "custom"){
                    $("#DateFrom").removeAttr("readonly");
                    $("#DateTo").removeAttr("readonly");
                }else{
                    $("#DateFrom").attr("readonly",true);
                    $("#DateTo").attr("readonly",true);
                }

                $("#DateFrom").val(from_date);
                $("#DateTo").val(to_date);
            }
        }
    </script>
    <style type="text/css">
    </style>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">
            <div class="icerikbaslik">
                <h1>
                    <strong><img width="150" src="<?php echo $tadress; ?>images/wanalytics.svg"/></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="reports">

                <div class="reports-content">

                    <div class="icerikbaslik">
                        <h1>
                            <strong><?php echo $page_title;  ?></strong>
                        </h1>

                        <div class="reportsdate">
                            <form action="<?php echo $links["controller"]; ?>" method="get" id="FilterForm">
                                <label for="DateRange">
                                    <span><?php echo __("admin/wanalytics/element-date-range"); ?></span>
                                    <select required name="range" id="DateRange" onchange="changeDateRange(this);">
                                        <?php
                                            foreach(__("admin/wanalytics/element-date-range-items") AS $k=>$v){
                                                $selected = $filter_range == $k ? ' selected' : '';
                                                ?>
                                                <option<?php echo $selected; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </label>

                                <label for="DateFrom">
                                    <span><?php echo __("admin/wanalytics/element-date-start"); ?></span>
                                    <input type="date" id="DateFrom" name="from" value="<?php echo $filter_from; ?>" required>
                                </label>
                                <label for="DateTo">
                                    <span><?php echo __("admin/wanalytics/element-date-end"); ?></span>
                                    <input type="date" id="DateTo" name="to" value="<?php echo $filter_to; ?>" required>
                                </label>
                                <label for="ChartView">
                                    <span><?php echo __("admin/wanalytics/element-language"); ?></span>
                                    <select name="language" id="SelectLanguage">
                                        <option value=""><?php echo ___("needs/allOf"); ?></option>
                                        <?php
                                            if(isset($lang_list) && $lang_list){
                                                foreach($lang_list AS $row){
                                                    $selected = false;
                                                    if($filter_lang == $row["key"]) $selected = ' selected';
                                                    ?>
                                                    <option<?php echo $selected; ?> value="<?php echo $row["key"]; ?>"><?php echo $row["name"]; ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </label>
                                <button style="display: none;" type="submit">Submit</button>
                                <a class="lbtn" href="javascript:void 0;" onclick="$('#FilterForm button').click();"><i class="fa fa-search"></i></a>
                            </form>
                        </div>
                    </div>

                    <div class="reportsinfotitle">
                        <?php echo __("admin/wanalytics/report-note-4"); ?>
                    </div>

                    <div class="reportfoundinfo">
                        <h4>
                            <?php
                                echo __("admin/wanalytics/report-note-2",[
                                    '{count}'       => $result_count,
                                    '{from_date}'   => DateManager::format(Config::get("options/date-format"),$filter_from),
                                    '{to_date}'     => DateManager::format(Config::get("options/date-format"),$filter_to),
                                ]);
                            ?>
                        </h4>
                    </div>

                    <div class="clear"></div>
                    <?php
                        if(!$filter_lang) include __DIR__.DS."wanalytics-fetch-chart-viewer.php";
                    ?>


                    <?php if(!$filter_lang): ?>
                        <table width="100%" id="list_table" class="table table-striped table-borderedx table-condensed nowrap">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="center" style="opacity: 0;">#</th>
                                <th align="center"><?php echo __("admin/wanalytics/list-table-languages"); ?></th>
                                <th align="center"><?php echo __("admin/wanalytics/list-table-clients"); ?></th>
                            </tr>
                            </thead>
                            <tbody align="Center" style="border-top:none;">
                            <?php
                                if(isset($list) && $list){
                                    foreach($list AS $k=>$row){
                                        $k+=1;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $k; ?></td>
                                            <td align="center"><?php echo $row["name"]; ?></td>
                                            <td align="center"><?php echo $row["count"]; ?> (%<?php echo $row["rate"]; ?>)</td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>


                <?php include __DIR__.DS."wanalytics-sidebar.php"; ?>
            </div>

            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>