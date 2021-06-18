<h4 style="float: left;"><strong><?php echo $module->lang["tx82"]; ?></strong></h4>

<a style="float:right;" class="lbtn" href="javascript:void(0);" id="sendCtrlAltDelButton">CTRL + ALT + DEL</a>


<div class="clear"></div>

<div class="line"></div>

<div style="background:#000;color:white;width:100%;height:350px;display: inline-block;">

    <style type="text/css">
        #top_bar {
            background-color: #6e84a3;
            color: white;
            font: bold 12px Helvetica;
            padding: 6px 5px 4px 5px;
            border-bottom: 1px outset;
        }
        #status {
            text-align: center;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            var _script;

            _script = document.createElement('script');
            _script.setAttribute('type','text/javascript');
            _script.setAttribute('src','<?php echo $module->url; ?>noVNC/vendor/promise.js');
            document.body.appendChild(_script);

            _script = document.createElement('script');
            _script.setAttribute('type','text/javascript');
            _script.setAttribute('src','<?php echo $module->url; ?>noVNC/module-support-test.js');
            document.body.appendChild(_script);

            _script = document.createElement('script');
            _script.setAttribute('type','text/javascript');
            _script.setAttribute('src','<?php echo $module->url; ?>noVNC/module-loader-polyfill.js');
            document.body.appendChild(_script);


            _script = document.createElement('script');
            _script.setAttribute('type','module');
            _script.setAttribute('src','<?php echo $module->area_link; ?>?operation=operation_server_automation&use_method=vnc-js&token=<?php echo base64_encode($console["wss_url"]."||".$console["password"]); ?>');
            document.body.appendChild(_script);
        });

        var checkDiv = setInterval(function(){
            if($("#screen > div").length > 0)
            {
                $("#screen > div").attr("style",'display: flex; width: 100%; height: 100%; overflow: auto; background:#000;');
                clearInterval(checkDiv);
            }
        },300);
    </script>

    <div id="top_bar">
        <div id="uhu"></div>
        <div id="status"><?php echo __("website/others/datatable-sLoadingRecords"); ?></div>
    </div>
    <div id="screen">
        <!-- This is where the remote screen will appear -->
    </div>
    <div class="clear"></div>
</div>

<div class="clear"></div>
<div class="line"></div>


<a href="javascript:open_m_page('home'); void 0;" class="hostbtn"><i class="fa fa-chevron-circle-left"></i> <?php echo $module->lang["turn-back"]; ?></a>