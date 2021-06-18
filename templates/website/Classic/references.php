<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "references",
    ];
?>
<div id="wrapper">

    <div class="reference">

        <div class="pakettitle">
            <h1><strong><?php echo (isset($category)) ? $category["title"] : __("website/references/content-title"); ?></strong></h1>
            <?php if(!isset($category)): ?>
                <div class="line"></div>
                <h2><?php echo __("website/references/content-slogan"); ?></h2>
            <?php endif; ?>
        </div>

        <?php if($category_status==1 && isset($categories) && $categories): ?>
            <div class="referenceselect">
                <select onchange="window.location.href = this.options[this.selectedIndex].value;">
                    <option value="<?php echo $references_link; ?>"><?php echo __("website/references/please-select-your-category"); ?></option>
                    <?php foreach($categories AS $row): ?>
                        <option<?php echo isset($category) && $category["id"] == $row["id"] ? ' selected' : '';?> value="<?php echo $row["route"]; ?>"><?php echo $row["title"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>


        <?php
            if(isset($list) && $list && sizeof($list)>0){
                foreach($list AS $row){
                    $options = isset($row["options"]) && $row["options"] ? Utility::jdecode($row["options"],true) : [];
                    $website = isset($options["website"]) ? $options["website"] : false;
                    ?>
                    <div class="anascriptlist">
                        <div class="scripthoverinfo">
                            <a href="<?php echo $row["route"];?>" title="<?php echo __("website/references/button-look"); ?>" class="sbtn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <?php if($website): ?>
                                <a href="<?php echo $website; ?>" rel="nofollow" target="_blank"  title="<?php echo __("website/references/button-go-to-website"); ?>" class="sbtn"><i class="fa fa-link" aria-hidden="true"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="padding5">
                            <a href="<?php echo $row["route"];?>"><img src="<?php echo $row["image"];?>" width="auto" height="auto" title="<?php echo $row["title"];?>" alt="<?php echo $row["title"];?>"></a>
                            <h4><strong><?php echo $row["short_title"];?></strong>
                                <?php if($row["category_name"]): ?>
                                    <br><span>(<?php echo $row["category_name"];?>)</span>
                                <?php endif; ?>
                            </h4>
                        </div>
                    </div>
                <?php } ?>
                <?php echo (isset($pagination)) ? $pagination : false; ?>
            <?php }else{ ?>
                <h3 class="error"><?php echo __("website/references/no-content"); ?></h3>
            <?php } ?>

        <?php if(isset($category) && Filter::html_clear($category["content"])): ?>
            <br><br><?php echo $category["content"]; ?>
        <?php endif; ?>


    </div>

</div>
