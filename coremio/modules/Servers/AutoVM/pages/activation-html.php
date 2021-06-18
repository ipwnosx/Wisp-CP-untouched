<table width="100%" border="0" cellpadding="3">

    <?php
        if(isset($options["ip"]) && $options["ip"]){
            ?>
            <tr>
                <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;"><?php echo $module->lang["activation-text5"]; ?></td>
                <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
                    <?php
                        echo $options["ip"];
                    ?>
                </td>
            </tr>
            <?php
        }

        if(isset($options["hostname"]) && $options["hostname"]){
            ?>
            <tr>
                <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">Hostname</td>
                <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
                    <?php
                        echo $options["hostname"];
                    ?>
                </td>
            </tr>
            <?php
        }

        if(isset($options["ns1"]) && $options["ns1"]){
            ?>
            <tr>
                <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">NS1</td>
                <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
                    <?php
                        echo $options["ns1"];
                    ?>
                </td>
            </tr>
            <?php
        }

        if(isset($options["ns2"]) && $options["ns2"]){
            ?>
            <tr>
                <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">NS2</td>
                <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
                    <?php
                        echo $options["ns2"];
                    ?>
                </td>
            </tr>
            <?php
        }
    ?>

    <?php
        if(isset($options["panel_type"]) && $options["panel_type"] && isset($options["panel_link"]) && $options["panel_link"]){
            ?>
            <tr>
                <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;"><?php echo $module->lang["activation-text1"]; ?></td>
                <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
                    <a href="<?php echo $options["panel_link"]; ?>"><?php echo $options["panel_link"]; ?></a>
                </td>
            </tr>
            <?php
        }
    ?>

    <?php
        if(isset($options["login"]["username"]) && $options["login"]["username"]){
            ?>
            <tr>
                <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;"><?php echo $module->lang["activation-text2"]; ?></td>
                <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
                    <?php echo $options["login"]["username"]; ?>
                </td>
            </tr>
            <?php
        }

        if(isset($options["login"]["password"]) && $options["login"]["password"]){
            ?>
            <tr>
                <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;"><?php echo $module->lang["activation-text3"]; ?></td>
                <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
                    <?php echo $options["login"]["password"]; ?>
                </td>
            </tr>
            <?php
        }

        if(isset($options["descriptions"]) && $options["descriptions"]){
            ?>
            <tr>
                <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;"><?php echo $module->lang["activation-text4"]; ?></td>
                <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
                    <?php echo nl2br($options["descriptions"]); ?>
                </td>
            </tr>
            <?php
        }
    ?>

</table>