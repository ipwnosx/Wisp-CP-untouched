<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "knowledgebase",
    ];
?>
<div id="wrapper">

    <div class="sayfacontent">
        <div class="padding20" style="padding-top:0px;">

            <?php if(!isset($category)): ?>
                <div class="bbankaara">
                    <h3><strong><?php echo __("website/knowledgebase/welcome-title"); ?></strong></h3>
                    <h4><?php echo __("website/knowledgebase/welcome-content"); ?></h4>
                    <form action="<?php echo $search_link; ?>" method="GET" id="SearchForm">
                        <input name="q" class="yuzde70" type="text" placeholder="<?php echo __("website/knowledgebase/searchbox-placeholder"); ?>"><a href="javascript:$('#SearchForm').submit();void 0;" class="lbtn"><?php echo __("website/knowledgebase/searchbox-submit-text"); ?></a>
                    </form>
                </div>

                <div class="clear"></div>
                <div class="line" style="margin-bottom:30px;"></div>
            <?php endif; ?>

            <?php
                if($searching)
                    $otitle = __("website/knowledgebase/searching-title",['{query}' => $query]);
                elseif(isset($category))
                    $otitle = $category["title"];
                else
                    $otitle = __("website/knowledgebase/sidebar-most-popular");

            ?>

            <div class="encokokunanbasliklar">

                <h4 class="bbbaslik"><strong><?php echo $otitle;?></strong></h4>
                <div class="breadcrumb">
                <?php
                    if(isset($category) && $category)
                        include __DIR__.DS."inc".DS."header-breadcrumb.php";
                ?>
                </div>

                <?php if(isset($category)): ?>
                    <div class="line"></div>
                <?php endif; ?>
                <div class="clear"></div>

                <?php
                    if(isset($sub_categories) && $sub_categories){
                        foreach($sub_categories AS $cat){
                            ?>
                            <a href="<?php echo $cat["route"];?>">
                                <div class="bbankakonu">
                                    <div class="padding15">
                                        <div><i class="fa fa-folder-o" aria-hidden="true"></i></div>
                                        <div style="float:right;margin-bottom:15px;width:80%;">
                                            <h4><strong><?php echo $cat["title"];?></strong> (<?php echo $cat["article_count"];?>)</h4>
                                            <?php echo $cat["short_content"]; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    }
                ?>




                <?php if(isset($list) && $list): ?>
                    <?php
                    foreach($list AS $item):
                        ?>
                        <h5><a href="<?php echo $item["route"]; ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $item["title"];?></a> <span> - <?php echo __("website/knowledgebase/statistics-info",['{views}' => $item["visit_count"],'{useful}' => $item["useful"]]); ?></span></h5>
                    <?php endforeach; ?>

                    <?php if(isset($pagination)): ?>
                        <div class="clear"></div>
                        <?php echo $pagination; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php
                    $errorType = $searching ? "no-result" : "no-content";
                    ?>
                    <h4 class="error"><?php echo __("website/knowledgebase/".$errorType); ?></h4>

                <?php endif; ?>

            </div>

            <?php if(isset($category) && !Validation::isEmpty(Filter::html_clear($category["content"]))): ?>
                <div class="clear"></div>
                <br>
                <?php echo $category["content"]; ?>
            <?php endif; ?>


        </div>
    </div>

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
            ?>

            <?php
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


</div>