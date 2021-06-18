<?php
    /**
     * MaestroPanel Rest Api Client
     *
     * @version 1.0
     * @author Mustafa Kemal Birinci <kemal@bilgisayarmuhendisi.net>
     * @license GPL
     * @license http://opensource.org/licenses/gpl-license.php GNU Public License
     * @copyright Mustafa Kemal Birinci
     */

    class MaestroPanelApiClient
    {
        private $_key;
        private $_uri;
        private $_min_password_length = 8;
        private $_min_nonalphanumeric_chars = 2;
        private $_connettion_timeout = 15; //sec
        private $_output_timeout = 45; // this defines how long time we will wait to get result after connection
        private $_errors = array();

        public function __construct($key, $host, $port = 9715, $ssl = false){
            if($this->is_valid_ip($host) || $this->is_valid_domain($host)){
                $this->_key = $key;
                $this->_uri = ($ssl ? 'https://' : 'http://'). $host . ':' . $port . '/Api/v1';
            }else{
                $this->_errors[] = 'Sunucu api bağlantısı için geçersiz ip ya da alan adı girdiniz!';
            }
        }

        public function domain_create($args=[]){
            return $this->send_api('Domain/Create', 'POST', $args);

        }
        public function domain_GetLimits($name){
            $args = array(
                'name'				=> $name,
            );

            return $this->send_api('Domain/GetLimits', 'GET', $args);
        }
        public function domain_delete($name){
            $args = array(
                'name'				=> $name,
            );

            return $this->send_api('Domain/Delete', 'DELETE', $args);
        }
        public function domain_start($name){
            $args = array(
                'name'				=> $name,
            );

            return $this->send_api('Domain/Start', 'POST', $args);
        }
        public function domain_stop($name){
            $args = array(
                'name'				=> $name,
            );

            return $this->send_api('Domain/Stop', 'POST', $args);
        }
        public function domain_reset_password($name, &$password){
            /*if(trim($password) == ''){
                $password = $this->generate_password();
            }else{
                if(!$this->is_valid_password($password))
                    return false;
            }*/

            $args = array(
                'name'				=> $name,
                'newpassword'		=> $password
            );

            return $this->send_api('Domain/Password', 'POST', $args);
        }
        public function domain_GetList(){
            $args = array();

            return $this->send_api('Domain/GetList', 'GET', $args);
        }
        public function domain_change_ftp_password($name='',$account='',$password=''){
            $args = array(
                'name'		        => $name,
                'account'		    => $account,
                'newpassword'       => $password,

            );

            return $this->send_api('Domain/ChangeFtpPassword', 'POST', $args);
        }
        public function domain_SetDomainPlan($name='',$plan=''){
            $args = array(
                'name'		        => $name,
                'planAlias'		    => $plan,
                'action'            => 'protect',

            );

            return $this->send_api('Domain/SetDomainPlan', 'POST', $args);
        }
        public function domain_GetMailList($name=''){
            $args = array(
                'name'		        => $name,
            );

            return $this->send_api('Domain/GetMailList', 'GET', $args);
        }
        public function domain_AddMailBox($args=[]){
            return $this->send_api('Domain/AddMailBox', 'POST', $args);
        }
        public function domain_DeleteMailBox($name='',$account=''){
            $args       = [
                'name'      => $name,
                'account'   => $account,
            ];
            return $this->send_api('Domain/DeleteMailBox', 'POST', $args);
        }
        public function domain_ChangeMailBoxPassword($name='',$account='',$password=''){
            $args       = [
                'name'          => $name,
                'account'       => $account,
                'newpassword'   => $password,
            ];
            return $this->send_api('Domain/ChangeMailBoxPassword', 'POST', $args);
        }
        public function domain_ChangeMailBoxQuota($name='',$account='',$quota=''){
            $args       = [
                'name'          => $name,
                'account'       => $account,
                'quota'         => $quota,
            ];
            return $this->send_api('Domain/ChangeMailBoxQuota', 'POST', $args);
        }
        public function reseller_create($args=[]){
            return $this->send_api('Reseller/Create', 'POST', $args);
        }
        public function reseller_addDomain($args=[]){
            return $this->send_api('Reseller/AddDomain', 'POST', $args);
        }
        public function reseller_reset_password($name, &$password){
            /*if(trim($password) == ''){
                $password = $this->generate_password();
            }else{
                if(!$this->is_valid_password($password))
                    return false;
            }*/

            $args = array(
                'username'		    => $name,
                'newpassword'		=> $password
            );

            return $this->send_api('Reseller/ChangePassword', 'POST', $args);
        }
        public function reseller_GetDomains($user){
            $args = array(
                'username'		    => $user,
            );

            return $this->send_api('Reseller/GetDomains', 'GET', $args);
        }
        public function reseller_DeleteDomain($user,$domainName=''){
            $args = array(
                'username'		    => $user,
                'domainName'		=> $domainName,
            );

            return $this->send_api('Reseller/DeleteDomain', 'DELETE', $args);
        }
        public function reseller_Delete($user){
            $args = array(
                'username'		    => $user,
            );

            return $this->send_api('Reseller/Delete', 'DELETE', $args);
        }
        public function reseller_start($name){
            $args = array(
                'username'				=> $name,
            );

            return $this->send_api('Reseller/Start', 'POST', $args);
        }
        public function reseller_stop($name){
            $args = array(
                'username'				=> $name,
            );

            return $this->send_api('Reseller/Stop', 'POST', $args);
        }


        private function send_api($action, $method, $args){
            try{
                if(count($this->_errors)>0) return false;

                $args['key'] = $this->_key;

                $args   = http_build_query($args);

                $curl=curl_init();
                curl_setopt($curl, CURLOPT_URL,$this->_uri . '/' . $action);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($curl, CURLOPT_POSTFIELDS,$args);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->_connettion_timeout);
                curl_setopt($curl, CURLOPT_TIMEOUT, $this->_output_timeout);
                $source = curl_exec($curl);

                if(curl_errno($curl)){
                    $this->_errors[] = curl_error($curl);
                    curl_close($curl);
                    return false;
                }

                curl_close($curl);

                if(stristr($source,'<title>')){
                    preg_match('/\<title\>(.*?)\<\/title\>/',$source,$match);
                    $this->_errors[] = isset($match[1]) ? $match[1] : 'Connection Failed';
                    return false;
                }

                if(!Validation::isHTML($source)){
                    $this->_errors[] = $source;
                    return false;
                }

                $result = Utility::xdecode($source,true);

                if($result['ErrorCode'] == '0'){
                    return $result;
                }else{
                    $this->_errors[] = 'Error Code : ' . $result['ErrorCode'] .' , Message : ' . $result['Message'];

                    return false;
                }


            }
            catch(Exception $e){
                $this->_errors[] = $e->getMessage();
                return false;
            }
        }
        private function is_valid_password($password){
            if(strlen($password) < $this->_min_password_length)
                $this->_errors[] = '�ifre uzunlu�u en az ' . $this->_min_password_length. ' karakterden olu�mal�d�r!';

            if(ctype_space($password))
                $this->_errors[] = '�ifre bo�luk karakteri i�eremez!';

            $chars = str_split($password);

            $nonalphanumeric_count = 0;

            foreach($chars as $char){
                if(!ctype_alnum($char))
                    $nonalphanumeric_count++;
            }

            if($nonalphanumeric_count < $this->_min_nonalphanumeric_chars)
                $this->_errors[] = 'Şifre en az ' . $this->_min_nonalphanumeric_chars . ' alfa nümerik olmayan karakter içermelidir!';

            if(count($this->_errors)>0)
                return false;
            else
                return true;
        }
        private function generate_password(){
            $chars1 = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9);
            $chars2 = array('!','*','+','-','@','=','#','$','/','?','(',')');
            $password='';

            for($i = 0;$i < $this->_min_password_length - $this->_min_nonalphanumeric_chars;$i++){
                $password.=$chars1[rand(0,count($chars1)-1)];
            }

            for($i = 0;$i < $this->_min_nonalphanumeric_chars;$i++){
                $password.=$chars2[rand(0,count($chars2)-1)];
            }

            return str_shuffle($password);
        }
        private function is_valid_ip($ip){
            return preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $ip );
        }
        private function is_valid_domain($domain){
            return preg_match("/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i",$domain);
        }
        public function get_errors(){
            return is_array($this->_errors) ? implode(", ",$this->_errors) : '';
        }
    }