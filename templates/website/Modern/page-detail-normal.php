<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "page-detail-normal",
    ];
?>
<div id="wrapper">
    <div class="sayfacontent"<?php echo !$sidebar_status ? ' style="width:100%;"' : '';?>>

        <div style="padding:20px;">
            <?php echo $page["content"]; ?>
        </div>
    </div>

    <?php
        if($sidebar_status):
            ?>
            <div class="sidebar">
                <div class="sidelinks">
                    <?php
                        if(sizeof($sidebar)>0){
                            foreach($sidebar AS $side){
                                ?><a href="<?php echo $side["link"]; ?>"><span><?php echo $side["title"];?></span></a><?php
                            }
                        }
                    ?>
                </div>
            </div>
        <?php endif; ?>
</div>