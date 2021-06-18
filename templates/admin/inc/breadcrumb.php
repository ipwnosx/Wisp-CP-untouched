<div class="sayfayolu">
    <?php
        $breadcrumbs = [];
        if(isset($breadcrumb) && $breadcrumb){
            if(sizeof($breadcrumb)>0){
                foreach($breadcrumb AS $k=>$crumb){
                    if($k == 0){
                        $breadcrumbs[] = '<a href="'.$crumb["link"].'"><strong>'.$crumb["title"].'</strong></a>';
                    }else{
                        $breadcrumbs[] = ($crumb["link"] == '') ? '<a>'.$crumb["title"].'</a>' : '<a href="'.$crumb["link"].'">'.$crumb["title"].'</a>';
                    }
                }
                echo implode(' / ',$breadcrumbs);
            }
        }
    ?>
</div>