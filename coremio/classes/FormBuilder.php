<?php

    class FormBuilder {
        private $output = false;
        public function __construct(){}

        public function wrap_start($content=''){
            $this->output .= $content;
            return $this;
        }

        public function wrap_end($content = ''){
            $this->output .= $content;
            return $this;
        }

        public function element($args=[]){
            if(isset($args["type"]))
                $type = $args["type"];
            else
                return $this;

            $output = '';
            if($type == "text" || $type == "email" || $type == "password" || $type == "number" || $type == "checkbox" || $type == "radio" || $type == "file"){
                $output .= '<input type="'.$type.'"';

                if(isset($args["name"]))
                    $output .= ' name="'.$args["name"].'"';

                if(isset($args["value"]))
                    $output .= ' value="'.$args["value"].'"';

                if(isset($args["placeholder"]) && $args["placeholder"] != '')
                    $output .= ' placeholder="'.$args["placeholder"].'"';

                if(isset($args["size"]))
                    $output .= ' maxlength="'.$args["size"].'"';

                if(isset($args["maxlength"]))
                    $output .= ' maxlength="'.$args["maxlength"].'"';

                if(isset($args["required"]))
                    $output .= ' required';

                if(isset($args["multiple"]))
                    $output .= ' multiple';

                if(isset($args["checked"]))
                    $output .= ' checked';

                if(isset($args["style"]))
                    $output .= ' style="'.$args["style"].'"';

                if(isset($args["id"]))
                    $output .= ' id="'.$args["id"].'"';

                if(isset($args["class"]))
                    $output .= ' class="'.$args["class"].'"';

                $output .= ">".EOL;


            }elseif($type == "textarea" || $type == "select"){
                $output .= '<'.$type;

                if(isset($args["name"]))
                    $output .= ' name="'.$args["name"].'"';

                if(isset($args["required"]))
                    $output .= ' required';

                if(isset($args["multiple"]))
                    $output .= ' multiple';

                if($type == "textarea" && isset($args["placeholder"]))
                    $output .= ' placeholder="'.$args["placeholder"].'"';

                if(isset($args["style"]))
                    $output .= ' style="'.$args["style"].'"';

                if(isset($args["id"]))
                    $output .= ' id="'.$args["id"].'"';

                if(isset($args["class"]))
                    $output .= ' class="'.$args["class"].'"';

                $output .= ">";

                if(isset($args["value"]))
                    $output .= $args["value"];

                if(isset($args["options"])){
                    foreach($args["options"] AS $opt){
                        $size = sizeof($opt);
                        $key   = $opt[0];
                        $value = ($size==2) ? $opt[1] : $opt[0];
                        $selected = (isset($args["selected"]) && $args["selected"] == $key) ? ' selected' : '';
                        $output .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
                    }
                }
                $output .= '</'.$type.'>'.EOL;
            }

            if(isset($args["jscode"]) && $args["jscode"] != '')
                $output .= '<script type="text/javascript">'.$args["jscode"].'</script>'.EOL;
            $this->output .= $output;
            return $this;
        }

        public function build($echo=false){
            $output = $this->output;
            $this->output = false;
            if($echo)
                echo $output;
            else
                return $output;
        }

    }