<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "knowledgebase-detail",
    ];
?>
<div id="wrapper">

    <div class="sayfacontent"<?php echo !$sidebar_status ? ' style="width:100%;"' : '';?>>

        <div class="padding20" style="padding-top:0px;">
            <h4 class="bbbaslik"><strong><?php echo $page["title"]; ?></strong></h4>
           
           <div class="breadcrumb"> <?php include __DIR__.DS."inc".DS."header-breadcrumb.php"; ?></div>

            <div class="line"></div>
            <div class="clear"></div>
            
            <?php echo $page["content"]; ?>

            <?php if($visibility_ticket): ?>
                <div class="clear"></div>
                <div class="openticket" style="text-align:center;margin:25px auto;width:100%;border:1px solid #ccc;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;">
                    <div class="padding20">
                        <h4><?php echo __("website/knowledgebase/openticket1"); ?></h4>
                        <p><?php echo __("website/knowledgebase/openticket2"); ?></p>
                        <a href="<?php echo $tickets_link; ?>" class="lbtn"><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo __("website/knowledgebase/openticket3"); ?></a>
                    </div>
                </div>
            <?php endif; ?>



            <!-- voting bar -->
            <div class="line"></div>

            <div class="faydalimi">

                <script type="text/javascript">
                    function voting_result(result) {
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    alert(solve.message);
                                }else{
                                    $("#votingContent").fadeOut(100,function () {
                                        $("#"+solve.status).fadeIn(100);
                                    });
                                }
                            }else
                                console.log(result);
                        }
                    }
                </script>
                <div id="votingContent">
                    <h5><strong><?php echo __("website/knowledgebase/question-text"); ?></strong></h5>
                    <a title="<?php echo __("website/knowledgebase/useful-text"); ?>" href="javascript:void(0);" class="green sbtn mio-ajax-submit" mio-ajax-options='{"type":"direct","result":"voting_result","action":"<?php echo $canonical_link; ?>?vote=useful&token=<?php echo Validation::get_csrf_token('kbase',false); ?>","waiting_text":"<?php echo addslashes(__("website/others/button4-pending"));?>"}'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>

                    <a title="<?php echo __("website/knowledgebase/useless-text"); ?>" href="javascript:void(0);" style="margin-right:10px;" class="red sbtn mio-ajax-submit" mio-ajax-options='{"type":"direct","result":"voting_result","action":"<?php echo $canonical_link; ?>?vote=useless&token=<?php echo Validation::get_csrf_token('kbase',false); ?>","waiting_text":"<?php echo addslashes(__("website/others/button4-pending"));?>"}'><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
                </div>
                <div id="successful-1" style="display: none;"><strong style="color:#81c04e"><?php echo __("website/knowledgebase/useful-success"); ?></strong></div>
                <div id="successful-2" style="display: none;"><strong style="color:#F44336"><?php echo __("website/knowledgebase/useless-success"); ?></strong></div>
                <div id="successful-3" style="display: none;"><strong style="color:#F44336"><?php echo __("website/knowledgebase/vote-again"); ?></strong></div>

                <div class="clearmob"></div>

                <span class="bbkonuinfo"><?php echo __("website/knowledgebase/detail-info",['{views}' => $page["visit_count"],'{useful}' => $page["useful"]]);?></span>
            </div>
            <!-- voting bar end -->

        </div>


    </div>

    <?php if($sidebar_status): ?>
        <div class="sidebar">
            <div class="sidelinks">

                <?php
                    if($categories){
                        ?>
                        <h4><?php echo __("website/knowledgebase/sidebar-categories"); ?></h4>
                        <?php
                        foreach($categories AS $row){
                            ?><a href="<?php echo $row["route"]; ?>"><span><?php echo $row["title"];?> (<strong><?php echo $row["article_count"]; ?></strong>)</span></a><?php
                        }
                        ?>
                        <div class="clear"></div>
                        <?php
                    }

                    if($most_popular){
                        ?>
                        <h4 style="margin-top:25px;"><?php echo __("website/knowledgebase/most-popular-articles"); ?></h4>
                        <?php
                        foreach($most_popular AS $row){
                            ?><a href="<?php echo $row["route"]; ?>"><span><?php echo $row["title"];?></span></a><?php
                        }
                        ?>
                        <div class="clear"></div>
                        <?php
                    }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="clear"></div>

</div>