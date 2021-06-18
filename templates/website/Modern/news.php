<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "news",
    ];
?>
<div id="wrapper">

    <div class="listeleme">

        <?php
            if(isset($list) && $list && sizeof($list)>0):
                foreach($list AS $row):
                    ?>
                    <div class="list">
                        <a href="<?php echo $row["route"];?>"><img src="<?php echo $row["image"];?>" width="344" height="210"></a>
                        <div class="padding15"><h4><a href="<?php echo $row["route"];?>"><?php echo $row["short_title"];?></a></h4>
                            <p><?php echo $row["short_content"];?></p></div>
                    </div>
                <?php endforeach; ?>
                <?php echo (isset($pagination)) ? $pagination : false; ?>
            <?php else: ?>
                <h4><?php echo __("website/news/no-content"); ?></h4>
            <?php endif; ?>

    </div>

    <?php if($sidebar_status==1): ?>
        <div class="sidebar" id="rightsidebar">
            <?php if($most_read_status==1 && isset($most_read) && sizeof($most_read)>0): ?>
                <h4><?php echo __("website/news/most-read"); ?></h4>
                <div class="sidelinks">
                    <?php foreach($most_read AS $row): ?>
                        <a href="<?php echo $row["route"]; ?>"><span><?php echo $row["title"]; ?></span></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>