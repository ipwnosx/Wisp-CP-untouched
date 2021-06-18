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

        public function SimilarityCheck($type='',$content=''){
            $this->db_start();
            $sth = $this->db->select("id")->from("newsletters")->where("type","=",$type,"&&")->where("content","=",$content);
            return $sth->build() ? $sth->getObject()->id : false;
        }

        public function addNewsletter($type = '',$content = '',$lang=''){
            $this->db_start();
            $sth = $this->db->insert("newsletters",[
                'lang' => $lang,
                'type' => $type,
                'content' => $content,
                'ip' => UserManager::GetIP(),
                'ctime' => DateManager::Now(),
            ]);
            return $sth;
        }
        public function removeNewsletter($id=0){
            $this->db_start();
            $sth = $this->db->delete("newsletters")->where("id","=",$id);
            return $sth->run();
        }

    }