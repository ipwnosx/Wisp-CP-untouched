<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "articles",
    ];
?>
<div id="wrapper">

    <div class="listeleme">
        <h2 class="listbaslik"><?php echo (isset($category)) ? $category["title"] : __("website/articles/left-title"); ?></h2>

        <?php
            if(isset($list) && $list && sizeof($list)>0):
                foreach($list AS $row):
                    ?>
                    <div class="list">
                        <a href="<?php echo $row["route"];?>"><img src="<?php echo $row["image"];?>" width="344" height="210"></a>
                        <div class="bloginfos">
                            <div style="padding:3px 7px;;">
                                <?php if($row["category_name"] != ''): ?>
                                    <a href="<?php echo $row["category_route"];?>"><?php echo $row["category_name"];?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="padding15">
                            <h4><a href="<?php echo $row["route"];?>"><?php echo $row["short_title"];?></a></h4>
                            <p><?php echo $row["short_content"];?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php echo (isset($pagination)) ? $pagination : false; ?>
            <?php else: ?>
                <h4><?php echo __("website/articles/no-content"); ?></h4>
            <?php endif; ?>

        <?php if(isset($category) && Filter::html_clear($category["content"])): ?>
            <?php echo $category["content"]; ?>
        <?php endif; ?>

    </div>

    <?php if($sidebar_status==1): ?>
        <div class="sidebar" id="rightsidebar">
            <?php if($category_status==1 && isset($categories) && $categories): ?>
                <h4 style=""><?php echo __("website/articles/categories"); ?></h4>
                <div class="sidelinks">
                    <?php foreach($categories AS $row): ?>
                        <a href="<?php echo $row["route"]; ?>"><span><?php echo $row["title"]; ?></span></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if($most_read_status==1 && isset($most_read) && $most_read): ?>
                <h4 style="margin-top:25px;"><?php echo __("website/articles/most-read"); ?></h4>
                <div class="sidelinks">
                    <?php foreach($most_read AS $row): ?>
                        <a href="<?php echo $row["route"]; ?>"><span><?php echo $row["title"]; ?></span></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>