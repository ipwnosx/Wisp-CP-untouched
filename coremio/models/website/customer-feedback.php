<?php
    /**
     * @author Sitemio Bilişim Teknolojileri Tic. Ltd. Şti.
     * @project Sitemio Temel Kaynak Kod Çekirdek Yapısı
     * @date 2017-07-01 09:00 AM
     * @contract http://www.sitemio.com/hizmet-sozlesmesi.html
     * @copyright Tüm Hakları Sitemio Bilişim Teknolojileri Tic. Ltd. Şti. adına saklıdır
     * @warning Lisanssız kopyalanamaz, dağıtılamaz ve kullanılamaz.
     **/

    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }


        public function addPicture($name = '',$owner_id=0){
            if($name == '' || $owner_id == 0)
                return false;
            $this->db_start();
            $sth = $this->db->insert("pictures",[
                'owner_id' => $owner_id,
                'owner' => "customer_feedback",
                'reason' => "image",
                'name' => $name,
            ]);
            return $sth;
        }

        public function addFeedback($data=[]){
            $sth = $this->db->insert("customer_feedbacks",$data);
            return ($sth) ? $this->db->lastID() : false;
        }

        public function addFeedback_lang($data=[]){
            $sth = $this->db->insert("customer_feedbacks_lang",$data);
            return ($sth) ? $this->db->lastID() : false;
        }

    }