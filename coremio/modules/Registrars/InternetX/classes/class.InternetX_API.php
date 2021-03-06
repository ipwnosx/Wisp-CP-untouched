<?php

/* * ********************************************************************
 * InternetX registrar module. Product developed. (2014-02-21)
 * *
 *
 *  CREATED BY MODULESGARDEN       ->       http://modulesgarden.com
 *  CONTACT                        ->       contact@modulesgarden.com
 *
 *
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 *
 *
 * ******************************************************************** */

if (!class_exists("InternetX_API")) {

    /**
     * Support for InternetX API
     */
    class InternetX_API
    {

        private static $serverUrl;
        private $errors = array();
        private static $username;
        private static $password;
        private static $context;
        private static $testMode;
        private static $debug;
        static $reply_to;

        /**
         * FUNCTION __construct
         * Create object api
         * @param $server_url
         * @param string $username
         * @param string $password
         * @param string $debug
         * @param string $testMode
         */
        public function __construct($serverUrl = 'https://gateway.autodns.com', $username, $password, $context, $sanboxUsername, $sanboxPassword, $sanboxContext, $debug = false, $testMode = false)
        {

            if ($testMode) {
                self::$testMode  = true;
                self::$serverUrl = "https://demo.autodns.com/gateway/";
                self::$username  = $sanboxUsername;
                self::$password  = $sanboxPassword;
                self::$context   = $sanboxContext;
            } else {
                self::$testMode  = false;
                self::$serverUrl = $serverUrl;
                self::$username  = $username;
                self::$password  = $password;
                self::$context   = $context;
            }
            self::$debug = (boolean) $debug;
        }

        /**
         * FUNCTION addError
         * Add new error
         * @param string $error
         */
        protected function addError($error)
        {
            if (!in_array($error, $this->errors)) $this->errors[] = $error;
        }

        /**
         * FUNCTION hasError
         * Is error?
         * @return boolean
         */
        public function hasError()
        {
            return empty($this->errors) ? false : true;
        }

        /**
         * FUNCTION getLastError
         * Return Last Error And Unset It
         * @return boolean
         */
        public function getLastError()
        {
            if (!$this->errors) {
                return false;
            }
            $count = count($this->errors) - 1;
            $error = $this->errors[$count];
            unset($this->errors[$count]);
            return $error;
        }

        /**
         * FUNCTION getError
         * Return all errors
         * @return string $ret
         */
        public function getErrors()
        {

            $ret = null;
            foreach ($this->errors as $value) {
                $ret.=$value . " ";
            }
            if ($ret == null) return false;
            else {
                $this->errors = array();
                return $ret;
            }
        }
		
		/**
    * FUNCTION clearErrors
    * Clear All Errors
    */
   public function clearErrors()
   {
    $this->errors = array();

}

        /**
         * FUNCTION parseXML
         * @param string $xml
         * @return boolean|object
         */
        private function parseXML($xml)
        {
            if (!$xml) {
                $this->addError("Parsing XML failed");
                return false;
            }
            $a = simplexml_load_string($xml);
            if ($a === FALSE) {
                $this->addError("Parsing XML failed");
                return false;
            } else {
                return $a;
            }
        }

        /**
         * FUNCTION call
         * Call to  API
         * @param string $request
         * @return boolean|string
         */
        private function call($request)
        {

            $ch   = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::$serverUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $data = curl_exec($ch);

            if ($data === false) {
                $err = ucwords(curl_error($ch)) ? ucwords(curl_error($ch)) : "Unable connect to registrar";
                $this->addError("CURL: " . curl_error($ch));
                curl_close($ch);
                return false;
            }
            curl_close($ch);
            return $data;
        }

        /**
         * FUNCTION createRequest
         * Create  xml request
         * @param array $params
         * @return string
         */
        private function createRequest($params)
        {

            $xml               = new DomDocument('1.0', 'UTF-8');
            $xml->formatOutput = true;
            $request           = $xml->createElement('request');
            $xml->appendChild($request);
            $auth              = $xml->createElement('auth');
            $request->appendChild($auth);
            $user              = $xml->createElement('user', self::$username);
            $auth->appendChild($user);
            $password          = $xml->createElement('password', self::$password);
            $auth->appendChild($password);
            $context           = $xml->createElement('context', self::$context);
            $auth->appendChild($context);
            $language          = $xml->createElement('language', "en");
            $request->appendChild($language);
            $userAgent         = $xml->createElement('user_agent', "
			 Plugin");
            $request->appendChild($userAgent);
            $task              = $xml->createElement('task');
            $request->appendChild($task);

            if (is_object($params)) {
                $this->prepareObject($xml, $task, $params);
            }
            return $xml->saveXML();
        }

        /**
         * FUNCTION prepareObject
         * Helper function modify xml
         * @param object $xmldoc
         * @param object $node
         * @param object $object
         */
        private function prepareObject(&$xmldoc, &$node, $object)
        {

            foreach ($object as $k => $value) {

                if (is_object($value)) {
                    $nd = $xmldoc->createElement((string) $k);
                    $this->prepareObject($xmldoc, $nd, $value);
                    $node->appendChild($nd);
                } elseif (is_array($value)) {
                    foreach ($value as $v) {
                        $nd2 = $xmldoc->createElement((string) $k);
                        $node->appendChild($nd2);
                        foreach ($v as $childKey => $childVal) {
                            $child = $xmldoc->createElement((string) $childKey, (string) $childVal);
                            $nd2->appendChild($child);
                        }
                    }
                } else {
                    $nd = $xmldoc->createElement((string) $k, (string) $value);
                    $node->appendChild($nd);
                }
            }
        }

        /**
         * FUNCTION processRequest
         * Process request
         * @param string $request
         * @param string $action
         * @return boolean|object
         */
        private function processRequest($request, $action='')
        {

            $response = $this->call($request);

            if($response === false) return false;

            if($action == 'checkDomainStatus')
            {
                return $this->parseXML($response);
            }

            $result = $this->parseXML($response);

            if (isset($result->result->msg->type) && $result->result->msg->type == "error") {
                foreach ($result->result->msg as $msg) {
                    $err = (string) $msg->code . " " . $msg->text;
                    $this->addError($err);
                }
                $this->addError((string) $result->result->msg->code . " " . $result->result->msg->text);
            }

            if (isset($result->result->status->type) && $result->result->status->type == "error") {
                $this->addError((string) $result->result->status->code . " " . $result->result->status->text);
            }

            if ($this->hasError()) return false;

            return $result;
        }

        /**
         * FUNCTION contactCheck
         * Check contact
         * @param string $id
         * @return boolean|object
         */
        public function contactCheck($id)
        {
            $task                                  = new stdClass();
            $task->code                            = "0341";
            $task->handle_verification             = new stdClass();
            $task->handle_verification->handle     = new stdClass();
            $task->handle_verification->handle->id = $id;
            $xml                                   = $this->createRequest($task);
            return $this->processRequest($xml, "contact check");
        }

        /**
         * FUNCTION contactCreate
         * Create contact
         * @param array $contact
         * @return boolean|object
         */
        public function contactCreate($contact, $extensions = array())
        {

            $task                       = new stdClass();
            $task->code                 = "0301";
            $task->handle               = new stdClass();
            $task->handle->id           = "";
            $task->handle->alias        = "";
            $task->handle->type         = $contact['type']; // ROLE ORG PERSON
            $task->handle->fname        = $contact['firstName'];
            $task->handle->lname        = $contact['lastName'];
            $task->handle->title        = "";
            $task->handle->organization = $contact['organization'];
            $task->handle->address      = trim($contact['address']);
            $task->handle->pcode        = $contact['postCode'];
            $task->handle->city         = $contact['city'];
            $task->handle->state        = $contact['state'];
            $task->handle->country      = $contact['countryName'] ? $contact['countryName'] : $contact['country'];
            $task->handle->phone        = $contact['phone'];
            $task->handle->fax          = $contact['fax'];
            $task->handle->email        = $contact['email'];
            $task->handle->sip          = "";
            $task->handle->protection   = "";
            $task->handle->remarks      = "";

            if (isset($extensions['handle'])) {
                foreach ($extensions['handle'] as $key => $val)
                    $task->handle->extension->$key = (string) $val;
            }

            $task->reply_to = self::$reply_to ? self::$reply_to : $contact['email'];

            $xml = $this->createRequest($task);
            return $this->processRequest($xml, "contact create");
        }

        /**
         * FUNCTION contactDelete
         * Delete contact
         * @param string $id
         * @param string $replyTo
         * @return boolean|object
         */
        public function contactDelete($id, $replyTo)
        {
            $task             = new stdClass();
            $task->code       = "0303";
            $task->handle     = new stdClass();
            $task->handle->id = $id;
            $task->reply_to   = self::$reply_to ? self::$reply_to : $replyTo;
            $xml              = $this->createRequest($task);
            return $this->processRequest($xml, "contact delete");
        }

        /**
         * FUNCTION contactInfo
         * Contact information data
         * @param string $id
         * @return boolean|object
         */
        public function contactInfo($id)
        {
            $task             = new stdClass();
            $task->code       = "0304";
            $task->handle     = new stdClass();
            $task->handle->id = $id;
            $xml              = $this->createRequest($task);
            return $this->processRequest($xml, "contact info");
        }

        /**
         * FUNCTION contactInfo
         * Contact information data
         * @param string $id
         * @return boolean|object
         */
        public function contactSerach($email)
        {
            $task                = new stdClass();
            $task->code          = "0304";
            $task->handle     = new stdClass();
            $task->handle->email = $email;
            $xml                 = $this->createRequest($task);
            return $this->processRequest($xml, "contact search");
        }

        public function contactUpdate($contact, $extensions = array())
        {
            $task                       = new stdClass();
            $task->code                 = "0302";
            $task->handle               = new stdClass();
            $task->handle->id           = $contact['id'];
            $task->handle->fname        = $contact['firstName'];
            $task->handle->lname        = $contact['lastName'];
            $task->handle->organization = $contact['organization'];
            $task->handle->address      = $contact['address'];//strip_tags(trim($formData['Address']));
            $task->handle->pcode        = $contact['postCode'];
            $task->handle->city         = $contact['city'];//strip_tags(trim($formData['City']));
            $task->handle->state        = $contact['state'];
            $task->handle->country      = $contact['countryName'] ? $contact['countryName'] : $contact['country'];
            $task->handle->phone        = $contact['phone'];
            $task->handle->fax          = $contact['phone'];
            $task->handle->email        = $contact['email'];
            $task->handle->confirm_owner_consent = 1;

            if (isset($extensions['handle'])) {
                foreach ($extensions['handle'] as $key => $val)
                    $task->handle->extension->$key = (string) $val;
            }
            $task->reply_to = self::$reply_to ? self::$reply_to : $contact['email'];
            $xml            = $this->createRequest($task);
            return $this->processRequest($xml, "contact update");
        }

        public function domainCreate($domain, $period, $contacts, $nameServers, $usePrivacy, $ip, $mx)
        {
            $task                 = new stdClass();
            $task->code           = "0101";
            $task->domain         = new stdClass();
            $task->domain->name   = $domain;
            $task->domain->ctid   = "";
            $task->domain->period = $period;
            $task->domain->ownerc = $contacts['ownerc'];
            $task->domain->adminc = $contacts['adminc'];
            $task->domain->techc  = $contacts['techc'];
            $task->domain->zonec  = $contacts['zonec'];
            $task->domain->nserver= [];

            $isInternetxNS=false;
            foreach ($nameServers as $k => $ns) {
                if (strpos($ns['name'],"ns14.net") !==FALSE) $isInternetxNS = true;
                $task->domain->nserver[$k] = new stdClass();
                $task->domain->nserver[$k]->name = $ns['name'];
                if (isset($ns['ip']))
                    $task->domain->nserver[$k]->ip   = $ns['ip'];
                if (isset($ns['ip6']))
                    $task->domain->nserver[$k]->ip6  = $ns['ip6'];
            }

            $task->domain->confirm_order   = 1;
            $task->domain->zone            = new stdClass();
            $task->domain->zone->ip        = $ip;
            $task->domain->zone->mx        = $mx;

            if($isInternetxNS){
                $task->domain->zone->ns_action = "complete";
            }else{
                $task->domain->zone->ns_action = "none";
            }


            if ($usePrivacy == 1){
                $task->domain->use_privacy     = $usePrivacy; //0 - 1
            }
            $task->reply_to                = self::$reply_to;
            $xml                           = $this->createRequest($task);

            $result = $this->processRequest($xml, "domain create");
            return $result;
        }

        public function premiumDomainCreate($domain, $period, $contacts, $nameServers, $usePrivacy, $ip, $mx, $className)
        {
            $task                       = new stdClass();
            $task->code                 = "0101";
            $task->domain->name         = $domain;
            $task->domain->extension->price_class  = $className;
            $task->domain->ctid         = "";
            $task->domain->period       = $period;
            $task->domain->ownerc       = $contacts['ownerc'];
            $task->domain->adminc       = $contacts['adminc'];
            $task->domain->techc        = $contacts['techc'];
            $task->domain->zonec        = $contacts['zonec'];

            foreach ($nameServers as $k => $ns) {
                $task->domain->nserver[$k]->name = $ns['name'];
                if (isset($ns['ip']))
                    $task->domain->nserver[$k]->ip   = $ns['ip'];
                if (isset($ns['ip6']))
                    $task->domain->nserver[$k]->ip6  = $ns['ip6'];
            }

            $task->domain->confirm_order   = 1;
            $task->domain->zone->ip        = $ip;
            $task->domain->zone->mx        = $mx;
            $task->domain->zone->ns_action = "complete";
            if ($usePrivacy == 1){
                $task->domain->use_privacy     = $usePrivacy; //0 - 1
            }
            $task->reply_to                = self::$reply_to;
            $xml                           = $this->createRequest($task);

            $result = $this->processRequest($xml, "domain create");
            return $result;
        }

        public function domainInfo($domain)
        {

            $task               = new stdClass();
            $task->code         = "0105";
            $task->domain       = new stdClass();
            $task->domain->name = $domain;

            $xml                = $this->createRequest($task);
            return $this->processRequest($xml, "Domain Info");
        }

        public function domainInfoSubUser($domain)
        {
            $task                 = new stdClass();
            $task->code           = "0105";
            $task->domain->name   = $domain;
            $task->view->offset   = 0;
            $task->view->limit    = 30;
            $task->view->children = 1;
            $task->key            = "payable";
            $xml                  = $this->createRequest($task);
            return $this->processRequest($xml, "Domain Info");
        }

        public function domainUpdate($domain, $contacts = array(), $nameServers = array(), $replyTo)
        {

            $task               = new stdClass();
            $task->code         = "0102";
            $task->domain       = new stdClass();
            $task->domain->name = $domain;
            if (!empty($contacts)) {
                $task->domain->ownerc = $contacts['ownerc'];
                $task->domain->adminc = $contacts['adminc'];
                $task->domain->techc  = $contacts['techc'];
                $task->domain->zonec  = $contacts['zonec'];
            }

            $task->domain->nserver = [];

            foreach ($nameServers as $k => $ns) {
                $task->domain->nserver[$k] = new stdClass();
                $task->domain->nserver[$k]->name = $ns['name'];
                if (isset($ns['ip']))
                    $task->domain->nserver[$k]->ip   = $ns['ip'];
                if (isset($ns['ip6']))
                    $task->domain->nserver[$k]->ip6  = $ns['ip6'];
            }
            $task->domain->confirm_owner_consent = 1;
            $task->reply_to = self::$reply_to ? self::$reply_to : $replyTo;
            $xml            = $this->createRequest($task);
            $result         = $this->processRequest($xml, "domain update");
            return $result;
        }

        public function domainUpdateIDProtection($domain, $usePrivacy, $replyTo = null)
        {
            $task                      = new stdClass();
            $task->code                = "0102";
            $task->domain              = new stdClass();
            $task->domain->name        = $domain;
            $task->domain->use_privacy = $usePrivacy; //true - false
            $task->reply_to            = self::$reply_to ? self::$reply_to : $replyTo;
            $xml                       = $this->createRequest($task);
            return $this->processRequest($xml, "domain privacy update");
        }

        public function domainUpdateStatus($domain, $status = "ACTIVE", $replyTo = null)
        {
            $task                          = new stdClass();
            $task->code                    = "0102002";
            $task->domain                  = new stdClass();
            $task->domain->name            = $domain;
            $task->domain->registry_status = $status;
            $task->reply_to                = self::$reply_to ? self::$reply_to : $replyTo;
            $xml                           = $this->createRequest($task);
            return $this->processRequest($xml, "domain update status");
        }

        public function authinfo1Create($domain, $replyTo = null)
        {
            $task                          = new stdClass();
            $task->code                    = "0113001";
            $task->domain                  = new stdClass();
            $task->domain->name            = $domain;
            $task->reply_to                = self::$reply_to ? self::$reply_to : $replyTo;
            $xml                           = $this->createRequest($task);
            return $this->processRequest($xml, "auth info1 create");
        }

        public function domainUpdateAutorenew($domain, $autoRenew, $replyTo = null)
        {
            $task                    = new stdClass();
            $task->code              = "0102";
            $task->domain                  = new stdClass();
            $task->domain->name      = $domain;
            $task->domain->autorenew = $autoRenew; //0 - 1
            $task->reply_to          = self::$reply_to ? self::$reply_to : $replyTo;
            $xml                     = $this->createRequest($task);
            return $this->processRequest($xml, "domain privacy update");
        }

        public function domainRenew($domain, $payable, $period)
        {
            $task                              = new stdClass();
            $task->code                        = "0101003";
            $task->domain->name                = $domain;
            $task->domain->payable             = $payable;
            $task->domain->period              = $period;
            $task->domain->remove_cancellation = "yes";
            $xml                               = $this->createRequest($task);
            return $this->processRequest($xml, "domain renew");
        }

        public function domainDelete($domain, $execDate)
        {
            $task                     = new stdClass();
            $task->code               = "0103";
            $task->domain->name       = $domain;
            $task->domain->disconnect = "0";
            $task->domain->execdate   = $execDate;
            $xml                      = $this->createRequest($task);
            return $this->processRequest($xml, "domain delete");
        }

        public function domainOwnerChange($domain, $contacts = array(), $authinfo, $replyTo)
        {

            $task               = new stdClass();
            $task->code         = "0102";
            $task->domain->name = $domain;
            foreach ($contacts as $cName => $handle) {
                $task->domain->$cName = $handle;
            }
            $task->domain->authinfo = $authinfo;
            $task->domain->confirm_owner_consent = 1;
            $task->reply_to         = self::$reply_to ? self::$reply_to : $replyTo;
            $xml                    = $this->createRequest($task);
            return $this->processRequest($xml, "domain owner change");
        }

        public function domainCancelationCreate($domain, $replyTo, $execdate = "expire", $disconnect = 1)
        {
            $task                          = new stdClass();
            $task->code                    = "0103101";
            $task->cancelation->domain     = $domain;
            $task->cancelation->type       = "delete";
            $task->cancelation->execdate   = $execdate;
            $task->cancelation->disconnect = $disconnect;
            $task->reply_to                = self::$reply_to ? self::$reply_to : $replyTo;
            $xml                           = $this->createRequest($task);
            return $this->processRequest($xml, "domain cancelation create");
        }

        public function domainCancelationDelete($domain, $replyTo, $execdate = "now")
        {
            $task                        = new stdClass();
            $task->code                  = "0103103";
            $task->cancelation->domain   = $domain;
            $task->cancelation->type     = "delete";
            $task->cancelation->execdate = $execdate;
            $task->reply_to              = self::$reply_to ? self::$reply_to : $replyTo;
            $xml                         = $this->createRequest($task);
            return $this->processRequest($xml, "domain cancelation delete");
        }

        public function transferIn($domain, $contacts, $nameServers, $eppCode, $usePrivacy, $domainIP, $domainMX)
        {

            $task                   = new stdClass();
            $task->code             = "0104";
            $task->domain->name     = $domain;
            $task->domain->authinfo = $eppCode;
            $task->domain->ownerc   = $contacts['ownerc'];
            $task->domain->adminc   = $contacts['adminc'];
            $task->domain->techc    = $contacts['techc'];
            $task->domain->zonec    = $contacts['zonec'];

            $isInternetxNS=false;
            foreach ($nameServers as $k => $ns) {
                if (strpos($ns['name'],"ns14.net") !==FALSE) $isInternetxNS = true;

                $task->domain->nserver[$k]->name = $ns['name'];
                if (isset($ns['ip']))
                    $task->domain->nserver[$k]->ip   = $ns['ip'];
                if (isset($ns['ip6']))
                    $task->domain->nserver[$k]->ip6  = $ns['ip6'];
            }


            $task->domain->zone->ip        = $domainIP;
            $task->domain->zone->mx        = $domainMX;

            if($isInternetxNS){
                $task->domain->zone->ns_action = "complete";
            }else{
                $task->domain->zone->ns_action = "none";
            }

            if ($usePrivacy == 1)
                $task->domain->use_privacy     = $usePrivacy; //0 - 1
            $task->domain->confirm_owner_consent = 1;
            $task->reply_to                = self::$reply_to;
            $task->ctid                    = "";
            $xml                           = $this->createRequest($task);

            $result = $this->processRequest($xml, "domain transfer");
            return $result;
        }

        public function transferOut($domain, $type)
        {

            $task                        = new stdClass();
            $task->code                  = "0106002";
            $task->transfer->domain      = $domain;
            $task->transfer->type        = $type;
            if ($type == "nack") $task->transfer->nack_reason = 7;

            $xml = $this->createRequest($task);
            return $this->processRequest($xml, "domain transfer out");
        }

        public function transferOutInfo($domain)
        {
            $task                         = new stdClass();
            $task->code                   = "0106001";
            $task->transfer->domain->name = $domain;
            $xml                          = $this->createRequest($task);
            return $this->processRequest($xml, "domain transfer info");
        }

        public function redirectInfo($domain)
        {
            $task                  = new stdClass();
            $task->code            = "0504";
            $task->view->offset    = "0";
            $task->view->limit     = "30";
            $task->view->children  = "0";
            $task->where->key      = "source";
            $task->where->operator = "like";
            $task->where->value    = "*" . $domain;
            $task->key             = "title";
            $xml                   = $this->createRequest($task);
            return $this->processRequest($xml, "redirect info");
        }

        public function redirectCreateEmail($source, $target)
        {
            $task                   = new stdClass();
            $task->code             = "0501";
            $task->redirect->type   = "email";
            $task->redirect->mode   = "single";
            $task->redirect->source = $source;
            $task->redirect->target = $target;
            $xml                    = $this->createRequest($task);
            return $this->processRequest($xml, "redirect create email");
        }

        public function createDomainRedirect($source, $target, $mode, $title = null)
        {
            $task                   = new stdClass();
            $task->code             = "0501";
            $task->redirect->type   = "domain";
            $task->redirect->mode   = $mode;
            if ($mode == "frame") $task->redirect->title  = $title;
            $task->redirect->source = $source;
            $task->redirect->target = $target;
            $xml                    = $this->createRequest($task);
            return $this->processRequest($xml, "create domain redirect");
        }

        public function redirectUpdateEmail($source, $target)
        {
            $task                   = new stdClass();
            $task->code             = "0502";
            $task->redirect->type   = "email";
            $task->redirect->mode   = "single";
            $task->redirect->source = $source;
            $task->redirect->target = $target;
            $xml                    = $this->createRequest($task);
            return $this->processRequest($xml, "redirect update email");
        }

        public function updateDomainRedirect($source, $target, $mode, $title)
        {
            $task                   = new stdClass();
            $task->code             = "0502";
            $task->redirect->type   = "domain";
            $task->redirect->mode   = $mode;
            if ($mode == "frame") $task->redirect->title  = $title;
            $task->redirect->source = $source;
            $task->redirect->target = $target;
            $xml                    = $this->createRequest($task);
            return $this->processRequest($xml, "update domain redirect");
        }

        public function redirectDelete($source, $type)
        {
            $task                   = new stdClass();
            $task->code             = "0503";
            $task->redirect->type   = $type;
            $task->redirect->source = $source;
            $xml                    = $this->createRequest($task);
            return $this->processRequest($xml, "redirect delete");
        }

        public function zoneInfo($zone)
        {
            $task             = new stdClass();
            $task->code       = "0205";
            $task->zone->name = $zone;
            $task->key        = "";
            $xml              = $this->createRequest($task);
            return $this->processRequest($xml, "zone info");
        }

        public function zoneCreate($zoneName, $nameServers)
        {

            $task                     = new stdClass();
            $task->code               = "0201";
            $task->zone->name         = $zoneName;
            $task->zone->main->value  = "";
            $task->zone->main->ttl    = "";
            $task->zone->ns_action    = "complete";
            $task->zone->www_include  = "1";
            $task->zone->soa->level   = "1";
            $task->zone->soa->refresh = "43200";
            $task->zone->soa->retry   = "7200";
            $task->zone->soa->expire  = "1209600";
            $task->zone->soa->ttl     = "86400";
            $task->zone->soa->email   = "";

            foreach ($nameServers as $k => $ns) {
                $ns                            = trim($ns);
                if (empty($ns)) continue;
                $task->zone->nserver[$k]->name = trim($ns);
                $task->zone->nserver[$k]->ttl  = "86400";
            }
            $xml = $this->createRequest($task);
            return $this->processRequest($xml, "zone create");
        }

        public function zoneUpdate($zoneName, $nameServers, $records, $mainIP, $www_include)
        {

            $task                    = new stdClass();
            $task->code              = "0202";
            $task->zone->name        = $zoneName;
            $task->zone->main->value = $mainIP;
            $task->zone->main->ttl   = "86400";
            $task->zone->ns_action   = "complete";
            $task->zone->www_include = $www_include;

            $task->zone->soa->level   = "1";
            $task->zone->soa->refresh = "43200";
            $task->zone->soa->retry   = "7200";
            $task->zone->soa->expire  = "1209600";
            $task->zone->soa->ttl     = "86400";
            $task->zone->soa->email   = "";


            foreach ($nameServers as $k => $ns) {
                $ns                            = trim($ns);
                if (empty($ns)) continue;
                $task->zone->nserver[$k]->name = trim($ns);
                $task->zone->nserver[$k]->ttl  = "86400";
            }

            foreach ($records as $k => $record) {
                $task->zone->rr[$k]->name  = trim($record['name']);
                $task->zone->rr[$k]->type  = $record['type'];
                $task->zone->rr[$k]->pref  = $record['pref'];
                $task->zone->rr[$k]->value = $record['value'];
            }
            $xml = $this->createRequest($task);
            return $this->processRequest($xml, "zone update");
        }

        public function zoneDelete($zoneName, $nameServers = array())
        {

            $task             = new stdClass();
            $task->code       = "0203";
            $task->zone->name = $zoneName;

            foreach ($nameServers as $k => $ns) {
                $ns                        = trim($ns);
                if (empty($ns)) continue;
                $task->zone->system_ns[$k] = trim($ns);
            }
            $xml = $this->createRequest($task);
            return $this->processRequest($xml, "zone delete");
        }

        public function checkPremiumAvability($domain, $action)
        {

            $task                        = new stdClass();
            $task->code                  = "0164";
            $task->domain_premium->name  = $domain;

            $xml = $this->createRequest($task);
            $ret=  $this->processRequest($xml, $action);
			    $this->clearErrors();
    return $ret;
        }

        public function checkDomainStatus($domain, $action)
        {

            $task                        = new stdClass();
            $task->code                  = "0108";
            $task->domain                = new stdClass();
            $task->domain->name          = $domain;

            $xml = $this->createRequest($task);
            return $this->processRequest($xml, $action);
        }

        public function domainList()
        {

            $task                        = new stdClass();
            $task->code                  = "0105";
            $task->key                   = "payable";

            $xml = $this->createRequest($task);
            return $this->processRequest($xml);
        }

        public function setReplyTo($replyTo)
        {
            self::$reply_to = $replyTo;
        }

        public function autodns_whois($slds = [], $tlds = []){

            $request = "multi +v2 +priceclass ".implode(',',$slds)." ".implode(',',$tlds)."\r\n";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'whois.autodns3.de');
            curl_setopt($ch, CURLOPT_PORT, 43);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
            $data = curl_exec($ch);
            if(curl_errno($ch)) $this->errors[] = curl_error($ch);
            curl_close($ch);

            //parse response
            $domains = [];
            $preg = '~(?i)('.implode('|',$slds).')[.]('.implode('|',$tlds).'):~';
            foreach(explode("\r\n",$data) as $line){
                if(!preg_match($preg,$line)){
                    continue;
                }
                list ($domain,$status) = explode(':',$line,2);
                if(substr(trim($status),0,7) == 'premium'){
                    $premium = 1;
                    list($status,$premiumClass) = explode(',',$status,2);
                }
                else{
                    $premium = 0;
                    $premiumClass = false;
                }
                $domains[$domain] = [
                    'status' => trim($status),
                    'premium' => $premium,
                    'premiumClass' => $premiumClass,
                ];
            }

            return $domains;

        }

    }

}