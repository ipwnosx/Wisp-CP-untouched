<div class="reportside">
    <script src="https://use.fontawesome.com/aaf32c1a9b.js"></script>

    <ul>
        <?php
            $icons      = [
                'overview'      => 'fa fa-tachometer',
                'clients'       => 'fa fa-users',
                'sales'         => 'fa fa-shopping-cart',
                'financial'     => 'fa fa-line-chart',
                'tickets'       => 'fa fa-life-ring',
            ];
            if(isset($page_maps) && $page_maps){
                foreach($page_maps AS $k=>$children){
                    $name = __("admin/wanalytics/sidebar-".$k);
                    if(!$name) $name = $k;
                    ?>
                    <li>
                        <a<?php echo $route_1 == $k ? ' id="reportsideactive"' : ''; ?><?php echo $children ? ' class="toggle"' : ''; ?> href="<?php echo $children ? '' : $links["base"].$k; ?>"><span><i class="<?php echo $icons[$k]; ?>" aria-hidden="true"></i><?php echo $name; ?></span></a>
                        <?php
                            if($children){
                                ?>
                                <ul class="inner"<?php echo $route_1 == $k ? ' style="display:block;"' : ''; ?>>
                                    <?php
                                        foreach($children AS $i){
                                            $i_name = __("admin/wanalytics/sidebar-".$k."-".$i);
                                            if(!$i_name) $i_name = $k."-".$i;
                                            $selected = $route_1 == $k && $route_2 == $i;
                                            ?>
                                            <li><a<?php echo $selected ? ' id="reportsideactive"' : ''; ?> href="<?php echo $links["base"].$k.'/'.$i; ?>"><span><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo $i_name; ?></span></a></li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                                <?php
                            }
                        ?>

                    </li>
                    <?php
                }
            }
        ?>
    </ul>
</div>