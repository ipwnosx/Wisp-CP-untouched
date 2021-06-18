<?php
    if(!defined("CORE_FOLDER")) die();

    $apply = $module->update_installment_rates();
    if($apply)
        echo Utility::jencode(['status' => "successful"]);
    else
        echo Utility::jencode([
            'status' => "error",
            'message' => "Bir hata oluştu. ".$module->error,
        ]);