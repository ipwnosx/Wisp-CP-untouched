<div class="stage2">
    <div class="logo"><img src="<?php echo $taddress; ?>images/logo2.svg" /></div>
    <div class="title"><?php echo $lang["stage1"]; ?></div>
    <div style="padding:25px;">

        <div class="notice">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <div class="noticeinfo">
                <?php echo $lang["stage1-text1"]; ?>
            </div>
        </div>

        <?php
            if(!$php){
                ?>
                <div class="formcon">
                <div class="yuzde30"><?php echo $lang["stage1-text4"]; ?></div>
                <div class="yuzde70">
                        <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                        <strong><?php echo $php_v; ?></strong>
                        <span style="font-size:14px;"><?php echo $lang["stage1-text5"]; ?></span>
                    </div>
                </div>
                <?php
            }


            if(!$ioncube){
                ?>
                <div class="formcon">
                    <div class="yuzde30">Ioncube</div>
                    <div class="yuzde70">
                        <?php
                            if($ioncube){
                                ?>
                                <i style="color:#81c04e;font-size:20px;" class="fa fa-check" aria-hidden="true"></i>
                                <strong><?php echo $ioncube_v; ?></strong>
                                <?php
                            }else{
                                if($phpinfo){
                                    ?>
                                    <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                    <span style="font-size:14px;"><?php echo $lang["stage1-text3"]; ?></span>
                                    <?php
                                }else{
                                    ?>
                                    <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                    <span style="font-size:14px;"><?php echo $lang["stage1-text3"]; ?></span>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

            if(!$curl){
                ?>
                <div class="formcon">
                    <div class="yuzde30">cURL</div>
                    <div class="yuzde70">
                        <?php
                            if($curl){
                                ?>
                                <i style="color:#81c04e;font-size:20px;" class="fa fa-check" aria-hidden="true"></i>
                                <?php
                            }else{
                                ?>
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;"><?php echo $lang["stage1-text7"]; ?></span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

            if($file_permissions){
                ?>
                <div class="formcon">
                <div class="yuzde30"><?php echo $lang["error14"]; ?></div>
                <div class="yuzde70">
                    <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                    <span style="font-size:14px;font-weight: 600;margin-bottom: 15px;"><?php echo $lang["error15"]; ?></span><br><br>
                    <div class="clear"></div>
                    <?php
                        foreach($file_permissions AS $f)
                        {
                            echo $f."<br />";
                        }
                    ?>
                 </div>
                </div>
                <?php
            }


            if(!$pdo){
                ?>
                <div class="formcon">
                    <div class="yuzde30">PDO & MySQL</div>
                    <div class="yuzde70">
                        <?php
                            if($pdo){
                                ?>
                                <i style="color:#81c04e;font-size:20px;" class="fa fa-check" aria-hidden="true"></i>
                                <?php
                            }else{
                                ?>
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;"><?php echo $lang["stage1-text9"]; ?></span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

            if(!$zip){
                ?>
                <div class="formcon">
                    <div class="yuzde30">ZipArchive</div>
                    <div class="yuzde70">
                        <?php
                            if($zip){
                                ?>
                                <i style="color:#81c04e;font-size:20px;" class="fa fa-check" aria-hidden="true"></i>
                                <?php
                            }else{
                                ?>
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;"><?php echo $lang["stage1-text8"]; ?></span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

            if(!$mbstring){
                ?>
                <div class="formcon">
                    <div class="yuzde30">MUltiByte String</div>
                    <div class="yuzde70">
                        <?php
                            if($mbstring){
                                ?>
                                <i style="color:#81c04e;font-size:20px;" class="fa fa-check" aria-hidden="true"></i>
                                <?php
                            }else{
                                ?>
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;"><?php echo $lang["stage1-text10"]; ?></span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

            if(!$openssl){
                ?>
                <div class="formcon">
                    <div class="yuzde30">OpenSSL</div>
                    <div class="yuzde70">
                        <?php
                            if($openssl){
                                ?>
                                <i style="color:#81c04e;font-size:20px;" class="fa fa-check" aria-hidden="true"></i>
                                <?php
                            }else{
                                ?>
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;"><?php echo $lang["stage1-text11"]; ?></span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

            if(!$gd){
                ?>
                <div class="formcon">
                    <div class="yuzde30">GD</div>
                    <div class="yuzde70">
                        <?php
                            if($gd){
                                ?>
                                <i style="color:#81c04e;font-size:20px;" class="fa fa-check" aria-hidden="true"></i>
                                <?php
                            }else{
                                ?>
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;"><?php echo $lang["stage1-text12"]; ?></span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

            if(!$intl){
                ?>
                <div class="formcon">
                    <div class="yuzde30">Intl</div>
                    <div class="yuzde70">
                        <?php
                            if($intl){
                                ?>
                                <i style="color:#81c04e;font-size:20px;" class="fa fa-check" aria-hidden="true"></i>
                                <?php
                            }else{
                                ?>
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;"><?php echo $lang["stage1-text13"]; ?></span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

            if(!$file_get_put){
                ?>
                <div class="formcon">
                    <div class="yuzde30"><?php echo $lang["stage1-text14"]; ?></div>
                    <div class="yuzde70">
                        <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                        <span style="font-size:14px;"><?php echo $lang["stage1-text15"]; ?></span>
                    </div>
                </div>
                <?php
            }

            if(!$glob){
                ?>
                <div class="formcon">
                    <div class="yuzde30"><?php echo $lang["stage1-text20"]; ?></div>
                    <div class="yuzde70">
                        <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                        <span style="font-size:14px;"><?php echo $lang["stage1-text21"]; ?></span>

                    </div>
                </div>
                <?php
            }

        ?>

        <div class="requirementnotice">
            <?php
                if(isset($conformity) && $conformity){
                    ?>
                    <h3 style="color:#4caf50"><strong><?php echo $lang["stage1-text24"]; ?></strong></h3>
                    <?php
                }else{
                    ?>
                    <h3 style="color:#f44336"><strong><?php echo $lang["stage1-text23"]; ?></strong></h3>
                    <?php
                }
            ?>
        </div>

        <div class="clear"></div>
        
        <div align="center">
            <?php
                if(isset($conformity) && $conformity){
                    ?>
                    <a class="button" href="?act=stage2"><?php echo $lang["next-stage"]; ?></a>
                    <?php
                }else{
                    ?>
                    <a class="button" href=""><?php echo $lang["stage1-text18"]; ?></a>
                    <?php
                }
            ?>
        </div>
        
    </div>

</div>