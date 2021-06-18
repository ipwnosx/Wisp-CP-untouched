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
    class Pagination {
        private $page = false;
        private $count = false;
        private $limit = false;
        private $start = false;
        private $end = false;
        private $pages = false;
        private $ranks  = 10;
        public $ahidden = false;

        public function __construct($arg=[]){
            if(isset($arg["page"]))
                $this->setPage($arg["page"]);
            if(isset($arg["total"]))
                $this->setTotal($arg["total"]);
            if(isset($arg["limit"]))
                $this->setLimit($arg["limit"]);
            if(isset($arg["ranks"]))
                $this->setRanks($arg["ranks"]);
            else
                $this->ranks = Config::get("options/pagination-ranks");
        }

        public function setPage($number){
            $this->page = $number;
        }

        public function setRanks($number){
            $this->ranks = $number;
        }

        public function setTotal($number){
            $this->count = $number;
        }

        public function setLimit($number){
            $this->limit = $number;
        }

        private function BadPage(){
            return (strlen($this->page)>4 || $this->page<1);
        }

        public function specification(){
            if($this->BadPage()) return ['start' => 0,'end' => $this->limit];
            $this->pages = ceil($this->count / $this->limit);
            if($this->page > $this->pages)
                $this->setPage($this->pages);
            $this->start = ($this->page - 1) * $this->limit;
            $this->end = $this->limit;
            return [
                'start' => $this->start,
                'end' => $this->end,
            ];
        }

        public function getHTML($template='website',$link=''){
            $data = View::$init->chose($template)->render("pagination",false,true);
            $nreplacer = ["(0)","(1)","(2)"];
            if($this->pages<2) return '';

            $first  = 1;
            $before = (($this->page-1)<1) ? 1 : $this->page-1;
            $next   = (($this->page+1)>$this->pages) ? $this->pages : $this->page+1;
            $last   = $this->pages;
            preg_match("/\{loop\}(.*?)\{\/loop\}/i",$data,$loop);
            if(!isset($loop) || !isset($loop[0]) || !isset($loop[1])) return '';

            $looptext = NULL;
            $loopk   = $loop[0];
            $loopv   = $loop[1];
            preg_match("/\{active\}(.*?)\{\/active\}/i",$loopv,$active);
            $activek = $active[0];
            $activev = $active[1];
            $default = $this->ranks;
            $mines   = ceil($default / 1.8);
            $ic      = ($this->pages>$default) ? $default : $this->pages;
            $num     = ($this->page>=($default-1)) ? $this->page-$mines : 0;
            $nump    = ($num+$default);
            if($this->pages > $ic && $nump>$this->pages) $num -= ($nump - $this->pages);
            for($i=1;$i<=$ic;$i++){
                $num+=1;
                $actived = ($this->page == $num) ? $activev : '';
                $text = str_replace(
                    ["{page}","{page-link}",$activek],
                    [$num,str_replace($nreplacer,$num,$link),$actived],$loopv).EOL;
                if($this->page == $num && $this->ahidden){
                    preg_match("/<a(.*?)>(.*?)<\/a>/i",$text,$a);
                    if(isset($a[0]) && isset($a[1]) && isset($a[2]))
                        $text = str_replace($a[0],$a[2],$text);
                }
                $looptext .= $text;
            }
            $looptext = rtrim($looptext,EOL);

            preg_match("/\{if\-first\}(.*?)\{\/if\-first\}/i",$data,$if_first);
            $if_firstk = (isset($if_first[0])) ? $if_first[0] : false;
            $if_firstx = (isset($if_first[1])) ? $if_first[1] : false;
            $if_firstv = ($this->page == 1) ? '' : $if_firstx;
            preg_match("/\{if\-before\}(.*?)\{\/if\-before\}/i",$data,$if_before);
            $if_beforek = (isset($if_before[0])) ? $if_before[0] : false;
            $if_beforex = (isset($if_before[1])) ? $if_before[1] : false;
            $if_beforev = ($this->page == 1) ? '' : $if_beforex;

            preg_match("/\{if\-next\}(.*?)\{\/if\-next\}/i",$data,$if_next);
            $if_nextk = (isset($if_next[0])) ? $if_next[0] : false;
            $if_nextx = isset($if_next[1]) ? $if_next[1] : false;
            $if_nextv = ($this->page == $this->pages) ? '' : $if_nextx;

            preg_match("/\{if\-last\}(.*?)\{\/if\-last\}/i",$data,$if_last);
            $if_lastk = (isset($if_last[0])) ? $if_last[0] : false;
            $if_lastx = (isset($if_last[1])) ? $if_last[1] : false;
            $if_lastv = ($this->page == $this->pages) ? '' : $if_lastx;
            
            $data = str_replace(
                [$if_firstk,$if_beforek,$if_nextk,$if_lastk],
                [$if_firstv,$if_beforev,$if_nextv,$if_lastv],
                $data);

            $data = str_replace([
                "{first}",
                "{before}",
                "{next}",
                "{last}",
                "{first-link}",
                "{before-link}",
                "{next-link}",
                "{last-link}",
                $loopk,
            ], [
                __("website/others/pagination-first"),
                __("website/others/pagination-before"),
                __("website/others/pagination-next"),
                __("website/others/pagination-last"),
                str_replace($nreplacer,$first,$link),
                str_replace($nreplacer,$before,$link),
                str_replace($nreplacer,$next,$link),
                str_replace($nreplacer,$last,$link),
                $looptext
            ],$data);
            return $data;
        }

    }