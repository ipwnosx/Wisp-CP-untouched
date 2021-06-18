<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "page-detail-articles",
    ];
?>
<div id="wrapper">
    <div class="sayfacontent"<?php echo !$sidebar_status ? ' style="width:100%;"' : '';?>>

        <div style="padding:20px;">
            <?php echo $page["content"]; ?>

            <div class="clear"></div>
            <?php echo isset($comment_embed_code) ? $comment_embed_code : false; ?>

        </div>
    </div>

    <?php if($sidebar_status): ?>
        <div class="sidebar">

            <?php if($category_status==1 && isset($categories) && $categories): ?>
                <h4 style=""><?php echo __("website/articles/categories"); ?></h4>
                <div class="sidelinks">
                    <?php foreach($categories AS $row): ?>
                        <a href="<?php echo $row["route"]; ?>"><span><?php echo $row["title"]; ?></span></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if($most_read_status==1 && isset($most_read) && sizeof($most_read)>0): ?>
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