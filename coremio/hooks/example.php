<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');

    /*
     * Example hook function for client register
     * @param string $name Name of the hook to be called
     * @param integer $priority Priority for hook function
     * @param callable|array You can send a callable function or an array, example as follows:
     *  [
     *    'function' => 'function name',
     *    'class'    => 'class name',
     *    'method'   => 'public method name in class', // class -> function
     *    'method::static'   => 'static method name in class', // class :: function
     *  ]
     *
     * @return void
    */
    /*
    Hook::add("ClientCreated",1,function($params=[]){

        $name           = $params['name'];
        $surname        = $params['surname'];
        $email          = $params['email'];
        $phone          = $params['phone'];

        // users_informations  add/edit field
        // User::setInfo($params["id"],['gsm_cc' => '44','gsm' => '12345678' , 'custom_field1' => 'test']);
        // users_informations remove field
        // User::deleteInfo($params["id"],'custom_field1');
        // users data edit field
        // User::setData($params["id"],['name' => "John", 'surname' => "Sterling" , 'full_name' => "John Sterling"]);

        // Write the code here...
    });
    */