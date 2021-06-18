<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "page-detail-references",
    ];
?>
<div id="wrapper">


    <div class="scriptrightside">

        <div class="clear"></div>

        <?php
            if(isset($optionsl["featured-info"]) && $featured_infos = $optionsl["featured-info"]){
                $featured_infos = explode(EOL,$optionsl["featured-info"]);
                foreach($featured_infos AS $info){
                    ?>
                    <h4><i class="fa fa-check"></i> <?php echo $info; ?></h4>
                    <?php
                }
            }
        ?>

        <div class="scriptpaylas paypasbutonlar">
            <?php include __DIR__.DS."inc".DS."social_share.php"; ?>
        </div>


        <div class="line"></div>
        <div class="clear"></div>
        <?php
            if($page["category_title"]){
                ?>
                <?php echo __("website/page/category"); ?>: <a class="lbtn" href="<?php echo $category_link; ?>"><?php echo $page["category_title"]; ?></a>
                <?php
            }
        ?>

        <?php
            if(isset($optionsl["technical-info"]) && $technical_infos = $optionsl["technical-info"]){
                ?>
                <div class="clear"></div>
                <div class="line"></div>
                <div class="sunucugereksinim">
                    <?php
                        $technical_infos = explode(EOL,$optionsl["technical-info"]);
                        foreach($technical_infos AS $info){
                            ?>
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $info; ?><br>
                            <?php
                        }
                    ?>
                </div>
                <?php
            }
        ?>

        <?php if(isset($options["website"]) && $website = $options["website"]): ?>
            <div class="line"></div>
            <div class="clear"></div>
            <a style="margin-top:0px;" class="yesilbtn gonderbtn" target="_blank" rel="nofollow" href="<?php echo $website; ?>"><?php echo __("website/page/review-website"); ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            <div class="clear"></div>
            <div class="line"></div>
        <?php endif; ?>


    </div>

    <div class="scriptdetayinfo">
        <?php if(isset($page["mockup"]) && $page["mockup"] != ''): ?>
            <img src="<?php echo $page["mockup"]; ?>" width="1000" height="auto">
            <div class="clear"></div>
        <?php endif; ?>


        <div class="clear"></div>

        <?php echo $page["content"]; ?>



    </div>


    <div class="clear"></div>


    <?php if(isset($most_popular) && $most_popular): ?>
        <div class="scriptdetaybenzer">

            <h4 class="scriptlisttitle"><strong><?php echo __("website/page/other-references"); ?></strong></h4>

            <?php
                foreach($most_popular AS $row){
                    $opt     = isset($row["options"]) && $row["options"] ? Utility::jdecode($row["options"],true) : [];
                    $website = isset($opt["website"]) ? $opt["website"] : false;
                    ?>
                    <div class="anascriptlist">
                        <div class="scripthoverinfo">
                            <a href="<?php echo $row["route"];?>" title="<?php echo __("website/references/button-look"); ?>" class="sbtn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <?php if($website): ?>
                                <a href="<?php echo $website; ?>" rel="nofollow" target="_blank"  title="<?php echo __("website/references/button-go-to-website"); ?>" class="sbtn"><i class="fa fa-link" aria-hidden="true"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="padding5">
                            <a href="<?php echo $row["route"];?>"><img src="<?php echo $row["cover_image"];?>" width="auto" height="auto" title="<?php echo $row["title"];?>" alt="<?php echo $row["title"];?>"></a>
                            <h4><strong><?php echo $row["title"];?></strong>
                                <?php if($row["category_name"]): ?>
                                    <br><span>(<?php echo $row["category_name"];?>)</span>
                                <?php endif; ?>
                            </h4>
                        </div>
                    </div>
                    <?php
                }
            ?>


        </div>
    <?php endif; ?>


</div>