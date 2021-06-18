<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Controller extends Controllers
    {
        protected $params,$data=[];

        public function __construct($arg=[])
        {
            parent::__construct();
            $this->params       = $arg['params'];
            if(!UserManager::LoginCheck("admin")){
                Utility::redirect($this->AdminCRLink("sign-in"));
                die();
            }
            Helper::Load("Admin");
            if(!Admin::isPrivilege("AUTOMATION_SETTINGS")) die();
        }

        private function update_settings(){
            $this->takeDatas("language");

            if(DEMO_MODE)
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/others/demo-mode-error")
                ]));

            $invoice_create         = Filter::POST("invoice-create");
            $invoice_reminder       = Filter::POST("invoice-reminder");
            $invoice_overdue        = Filter::POST("invoice-overdue");
            $invoice_cancellation   = Filter::POST("invoice-cancellation");
            $invoice_deletion       = Filter::POST("invoice-deletion");
            $order_suspend          = Filter::POST("order-suspend");
            $order_terminate        = Filter::POST("order-terminate");
            $order_cancel           = Filter::POST("order-cancel");
            $p_order_d              = Filter::POST("pending-order-cancellation");
            $pg_order_deletion      = Filter::POST("pending-order-deletion");
            $ticket_close           = Filter::POST("ticket-close");
            $ticket_lock            = Filter::POST("ticket-lock");
            $clear_logs             = Filter::POST("clear-logs");
            $unvfd_accts_deletion   = Filter::POST("unverified-accounts-deletion");
            $nnords_accts_deletion  = Filter::POST("non-order-accounts-deletion");
            $time_to_process        = Filter::POST("time-to-process");


            if(!isset($order_suspend["status"])) $order_suspend["status"] = 0;
            if(!isset($order_cancel["status"])) $order_cancel["status"] = 0;
            if(!isset($order_terminate["status"])) $order_terminate["status"] = 0;
            if(!isset($ticket_close["status"])) $ticket_close["status"] = 0;
            if(!isset($ticket_lock["status"])) $ticket_lock["status"] = 0;
            if(!isset($clear_logs["status"])) $clear_logs["status"] = 0;

            $config_sets        = [];

            if($invoice_create["than-one-month"] != Config::get("cronjobs/tasks/invoice-create/settings/than-one-month"))
                $config_sets["cronjobs"]["tasks"]["invoice-create"]["settings"]["than-one-month"] = $invoice_create["than-one-month"];

            if($invoice_create["month"] != Config::get("cronjobs/tasks/invoice-create/settings/month"))
                $config_sets["cronjobs"]["tasks"]["invoice-create"]["settings"]["month"] = $invoice_create["month"];

            if($invoice_reminder["first"] != Config::get("cronjobs/tasks/invoice-reminder/settings/first"))
                $config_sets["cronjobs"]["tasks"]["invoice-reminder"]["settings"]["first"] = $invoice_reminder["first"];

            if($invoice_reminder["second"] != Config::get("cronjobs/tasks/invoice-reminder/settings/second"))
                $config_sets["cronjobs"]["tasks"]["invoice-reminder"]["settings"]["second"] = $invoice_reminder["second"];

            if($invoice_reminder["third"] != Config::get("cronjobs/tasks/invoice-reminder/settings/third"))
                $config_sets["cronjobs"]["tasks"]["invoice-reminder"]["settings"]["third"] = $invoice_reminder["third"];

            if($invoice_overdue["first"] != Config::get("cronjobs/tasks/invoice-overdue/settings/first"))
                $config_sets["cronjobs"]["tasks"]["invoice-overdue"]["settings"]["first"] = $invoice_overdue["first"];

            if($invoice_overdue["second"] != Config::get("cronjobs/tasks/invoice-overdue/settings/second"))
                $config_sets["cronjobs"]["tasks"]["invoice-overdue"]["settings"]["second"] = $invoice_overdue["second"];

            if($invoice_overdue["third"] != Config::get("cronjobs/tasks/invoice-overdue/settings/third"))
                $config_sets["cronjobs"]["tasks"]["invoice-overdue"]["settings"]["third"] = $invoice_overdue["third"];

            if($invoice_cancellation["day"] != Config::get("cronjobs/tasks/invoice-cancellation/settings/day"))
                $config_sets["cronjobs"]["tasks"]["invoice-cancellation"]["settings"]["day"] = $invoice_cancellation["day"];

            if($invoice_deletion["day"] != Config::get("cronjobs/tasks/invoice-deletion/settings/day"))
                $config_sets["cronjobs"]["tasks"]["invoice-deletion"]["settings"]["day"] = $invoice_deletion["day"];

            if($order_suspend["status"] != Config::get("cronjobs/tasks/order-suspend/status"))
                $config_sets["cronjobs"]["tasks"]["order-suspend"]["status"] = $order_suspend["status"]==1;

            if($order_cancel["status"] != Config::get("cronjobs/tasks/order-cancel/status"))
                $config_sets["cronjobs"]["tasks"]["order-cancel"]["status"] = $order_cancel["status"]==1;

            if($order_terminate["status"] != Config::get("cronjobs/tasks/order-terminate/status"))
                $config_sets["cronjobs"]["tasks"]["order-terminate"]["status"] = $order_terminate["status"]==1;

            if($ticket_close["status"] != Config::get("cronjobs/tasks/ticket-close/status"))
                $config_sets["cronjobs"]["tasks"]["ticket-close"]["status"] = $ticket_close["status"]==1;

            if($clear_logs["status"] != Config::get("cronjobs/tasks/clear-logs/status"))
                $config_sets["cronjobs"]["tasks"]["clear-logs"]["status"] = $clear_logs["status"]==1;

            if($order_suspend["day"] != Config::get("cronjobs/tasks/order-suspend/settings/day"))
                $config_sets["cronjobs"]["tasks"]["order-suspend"]["settings"]["day"] = $order_suspend["day"];

            if($order_cancel["day"] != Config::get("cronjobs/tasks/order-cancel/settings/day"))
                $config_sets["cronjobs"]["tasks"]["order-cancel"]["settings"]["day"] = $order_cancel["day"];

            if($order_terminate["day"] != Config::get("cronjobs/tasks/order-terminate/settings/day"))
                $config_sets["cronjobs"]["tasks"]["order-terminate"]["settings"]["day"] = $order_terminate["day"];

            if($pg_order_deletion["day"] != Config::get("cronjobs/tasks/pending-order-deletion/settings/day"))
                $config_sets["cronjobs"]["tasks"]["pending-order-deletion"]["settings"]["day"] = $pg_order_deletion["day"];

            if($ticket_close["day"] != Config::get("cronjobs/tasks/ticket-close/settings/day"))
                $config_sets["cronjobs"]["tasks"]["ticket-close"]["settings"]["day"] = $ticket_close["day"];

            if($ticket_lock["day"] != Config::get("cronjobs/tasks/ticket-lock/settings/day"))
                $config_sets["cronjobs"]["tasks"]["ticket-lock"]["settings"]["day"] = $ticket_lock["day"];

            if($clear_logs["day"] != Config::get("cronjobs/tasks/clear-logs/settings/day"))
                $config_sets["cronjobs"]["tasks"]["clear-logs"]["settings"]["day"] = $clear_logs["day"];

            if($unvfd_accts_deletion["day"] != Config::get("cronjobs/tasks/unverified-accounts-deletion/settings/day"))
                $config_sets["cronjobs"]["tasks"]["unverified-accounts-deletion"]["settings"]["day"] = $unvfd_accts_deletion["day"];

            if($nnords_accts_deletion["day"] != Config::get("cronjobs/tasks/non-order-accounts-deletion/settings/day"))
                $config_sets["cronjobs"]["tasks"]["non-order-accounts-deletion"]["settings"]["day"] = $nnords_accts_deletion["day"];

            if($p_order_d["day"] != Config::get("cronjobs/tasks/pending-order-cancellation/settings/day"))
                $config_sets["cronjobs"]["tasks"]["pending-order-cancellation"]["settings"]["day"] = $p_order_d["day"];

            if($time_to_process["start"] != Config::get("cronjobs/time-to-process/start"))
                $config_sets["cronjobs"]["time-to-process"]["start"] = $time_to_process["start"];

            if($time_to_process["end"] != Config::get("cronjobs/time-to-process/end"))
                $config_sets["cronjobs"]["time-to-process"]["end"] = $time_to_process["end"];

            if(isset($config_sets["cronjobs"])){
                $set_cron    = Config::set("cronjobs",$config_sets["cronjobs"]);
                $export_cron = Utility::array_export($set_cron,['pwith' => true]);

                if(!$export_cron || stristr($export_cron,'return false'))
                    die(Utility::jencode([
                        'status' => "error",
                        'message' => __("admin/events/cronjob-time-file-cannot-be-saved"),
                    ]));

                FileManager::file_write(CONFIG_DIR."cronjobs.php",$export_cron);

                $adata      = UserManager::LoginData("admin");
                User::addAction($adata["id"],"alteration","changed-automation-settings");
            }
            
            echo Utility::jencode([
                'status' => "successful",
                'message' => __("admin/automation/success1"),
            ]);

        }

        private function operationMain($operation=''){
            if($operation == "update_settings" && Admin::isPrivilege("AUTOMATION_SETTINGS")) return $this->update_settings();
            echo "Not found operation: ".$operation;
        }

        public function main(){
            if(Filter::POST("operation")) return $this->operationMain(Filter::init("POST/operation","route"));
            if(Filter::GET("operation")) return $this->operationMain(Filter::init("GET/operation","route"));

            $this->takeDatas([
                "dashboard-link",
                "admin-sign-all",
                "language",
                "lang_list",
                "home_link",
                "canonical_link",
                "favicon_link",
                "header_type",
                "header_logo_link",
                "footer_logo_link",
                "meta_color",
                "admin_info",
            ]);

            $this->addData("links",[
                'controller'        => $this->AdminCRLink("automation"),
            ]);

            $this->addData("meta",__("admin/automation/meta-settings"));

            $breadcrumbs    = [
                [
                    'link' => $this->AdminCRLink("dashboard"),
                    'title' => __("admin/index/breadcrumb-name"),
                ],
                [
                    'link' => NULL,
                    'title' => __("admin/automation/breadcrumb-settings"),
                ]
            ];

            $this->addData("breadcrumb",$breadcrumbs);

            $this->addData("crons",Config::get("cronjobs"));

            $this->view->chose("admin")->render("automation-settings",$this->data);
        }
    }