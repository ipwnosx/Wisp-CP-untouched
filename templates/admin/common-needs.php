<?php
    $products_situations = [
        'active' => '<div class="listingstatus"><span class="active">'.__("admin/products/status-active").'</span></div>',
        'inactive' => '<div class="listingstatus"><span>'.__("admin/products/status-inactive").'</span></div>',
    ];

    $user_document_record = [
        'verified' => '<div class="listingstatus"><span class="active">'.__("admin/users/document-record-status-verified").'</span></div>',
        'awaiting' => '<div class="listingstatus"><span class="wait">'.__("admin/users/document-record-status-awaiting").'</span></div>',
        'unverified' => '<div class="listingstatus"><span>'.__("admin/users/document-record-status-unverified").'</span></div>',
    ];

    $categories_situations = [
        'active' => '<div class="listingstatus"><span class="active">'.__("admin/products/status-active").'</span></div>',
        'inactive' => '<div class="listingstatus"><span>'.__("admin/products/status-inactive").'</span></div>',
    ];

    $paddons_situations = [
        'active' => '<div class="listingstatus"><span class="active">'.__("admin/products/status-active").'</span></div>',
        'inactive' => '<div class="listingstatus"><span>'.__("admin/products/status-inactive").'</span></div>',
    ];

    $prequirements_situations = [
        'active' => '<div class="listingstatus"><span class="active">'.__("admin/products/status-active").'</span></div>',
        'inactive' => '<div class="listingstatus"><span>'.__("admin/products/status-inactive").'</span></div>',
    ];

    $shared_server_situations = [
        'active' => '<div class="listingstatus"><span class="active">'.__("admin/products/status-active").'</span></div>',
        'inactive' => '<div class="listingstatus"><span>'.__("admin/products/status-inactive").'</span></div>',
    ];

    $orders_situations = [
        'waiting' => '<div class="listingstatus"><span class="wait">'.__("admin/orders/status-waiting").'</span></div>',
        'inprocess' => '<div class="listingstatus"><span class="process">'.__("admin/orders/status-inprocess").'</span></div>',
        'cancelled' => '<div class="listingstatus"><span>'.__("admin/orders/status-cancelled").'</span></div>',
        'suspended' => '<div class="listingstatus"><span>'.__("admin/orders/status-suspended").'</span></div>',
        'active' => '<div class="listingstatus"><span class="active">'.__("admin/orders/status-active").'</span></div>',
        'completed' => '<div class="listingstatus"><span>'.__("admin/orders/status-completed2").'</span></div>',
    ];

    $updowngrades_situations = [
        'waiting' => '<div class="listingstatus"><span class="wait">'.__("admin/orders/status-waiting").'</span></div>',
        'inprocess' => '<div class="listingstatus"><span class="process">'.__("admin/orders/status-inprocess").'</span></div>',
        'completed' => '<div class="listingstatus"><span class="active">'.__("admin/orders/status-completed").'</span></div>',
    ];

    $cancellation_situations = [
        'pending'  => '<div class="listingstatus"><span class="wait">'.__("admin/orders/status-waiting").'</span></div>',
        'approved' => '<div class="listingstatus"><span class="active">'.__("admin/orders/status-approved").'</span></div>',
    ];

    $origin_situations = [
        'waiting' => '<div class="listingstatus"><span class="wait">'.__("admin/orders/status-waiting").'</span></div>',
        'inactive' => '<div class="listingstatus"><span>'.__("admin/orders/status-inactive").'</span></div>',
        'active' => '<div class="listingstatus"><span class="active">'.__("admin/orders/status-active").'</span></div>',
    ];

    $invoices_situations = [
        'waiting'   => '<div class="listingstatus"><span class="process">'.__("admin/invoices/create-situations/waiting").'</span></div>',
        'paid'      => '<div class="listingstatus"><span class="active">'.__("admin/invoices/create-situations/paid").'</span></div>',
        'unpaid'    => '<div class="listingstatus"><span class="wait">'.__("admin/invoices/create-situations/unpaid").'</span></div>',
        'refund'    => '<div class="listingstatus"><span>'.__("admin/invoices/create-situations/refund").'</span></div>',
        'cancelled' => '<div class="listingstatus"><span>'.__("admin/invoices/create-situations/cancelled").'</span></div>',
    ];

    $ticket_request_situations = [
        'process' => '<div class="listingstatus"><span class="process">'.__("admin/tickets/situations/process").'</span></div>',
        'waiting' => '<div class="listingstatus"><span class="wait">'.__("admin/tickets/situations/waiting").'</span></div>',
        'replied' => '<div class="listingstatus"><span>'.__("admin/tickets/situations/replied").'</span></div>',
        'solved' => '<div class="listingstatus"><span>'.__("admin/tickets/situations/solved").'</span></div>',
    ];

    $users_situations = [
        'active' => '<div class="listingstatus"><span class="active">'.__("admin/users/situations/active").'</span></div>',
        'inactive' => '<div class="listingstatus"><span class="wait">'.__("admin/users/situations/inactive").'</span></div>',
        'blocked'  => '<div class="listingstatus"><span class="wait">'.__("admin/users/situations/blocked").'</span></div>',
    ];

    $cfeedback_situations = [
        'pending'  => '<div class="listingstatus"><span class="wait">'.__("admin/manage-website/situations/pending").'</span></div>',
        'approved' => '<div class="listingstatus"><span class="active">'.__("admin/manage-website/situations/approved").'</span></div>',
    ];

    $tasks_situations = [
        'waiting'   => '<div class="listingstatus"><span class="wait">'.__("admin/tools/status-waiting").'</span></div>',
        'inprocess' => '<div class="listingstatus"><span class="process">'.__("admin/tools/status-inprocess").'</span></div>',
        'postponed' => '<div class="listingstatus"><span class="process">'.__("admin/tools/status-postponed").'</span></div>',
        'completed' => '<div class="listingstatus"><span>'.__("admin/tools/status-completed").'</span></div>',
    ];

    $reminders_situations = [
        'active'        => '<div class="listingstatus"><span class="active">'.__("admin/tools/status-active").'</span></div>',
        'inactive'      => '<div class="listingstatus"><span class="process">'.__("admin/tools/status-inactive").'</span></div>',
    ];

    $admin_situations   = [
        'active'   => "<div class='listingstatus'><span class='active'>".__("admin/admins/status-active")."</span></div>",
        'inactive' => "<div class='listingstatus'><span class='wait'>".__("admin/admins/status-inactive")."</span></div>",
        'blocked' => "<div class='listingstatus'><span class='wait'>".__("admin/admins/status-blocked")."</span></div>",
    ];

    $custom_field_situations   = [
        'active'   => "<div class='listingstatus'><span class='active'>".__("admin/manage-website/situations/active")."</span></div>",
        'inactive' => "<div class='listingstatus'><span class='wait'>".__("admin/manage-website/situations/inactive")."</span></div>",
    ];

    $affiliate_withdrawal = [
        'awaiting'   => "<div class='listingstatus'><span class='wait'>".__("admin/users/affiliate-withdrawal-situations/awaiting")."</span></div>",
        'process'   => "<div class='listingstatus'><span class='process'>".__("admin/users/affiliate-withdrawal-situations/process")."</span></div>",
        'completed'   => "<div class='listingstatus'><span class='active'>".__("admin/users/affiliate-withdrawal-situations/completed")."</span></div>",
        'cancelled'   => "<div class='listingstatus'><span>".__("admin/users/affiliate-withdrawal-situations/cancelled")."</span></div>",
    ];

    $affiliate_transaction  = [
        'approved'          => '<span class="active">'.__("website/account/affiliate-tx49").'</span>',
        'completed'         => '<span class="active">'.__("website/account/affiliate-tx49").'</span>',
        'invalid'           => '<span class="wait">'.__("website/account/affiliate-tx50").'</span>',
        'invalid-another'   => '<span class="wait">'.__("website/account/affiliate-tx50").'</span>',
        'cancelled'         => '<span class="wait">'.__("website/account/affiliate-tx63").'</span>',
    ];

    $subscription_situations = [
        'pending'   => "<div class='listingstatus'><span class='wait'>".__("admin/orders/subscription-status-pending")."</span></div>",
        'approved'   => "<div class='listingstatus'><span class='process'>".__("admin/orders/subscription-status-approved")."</span></div>",
        'active'   => "<div class='listingstatus'><span class='active'>".__("admin/orders/subscription-status-active")."</span></div>",
        'suspended' => '<div class="listingstatus"><span>'.__("admin/orders/subscription-status-suspended").'</span></div>',
        'cancelled' => '<div class="listingstatus"><span>'.__("admin/orders/subscription-status-cancelled").'</span></div>',
        'expired' => '<div class="listingstatus"><span>'.__("admin/orders/subscription-status-expired").'</span></div>',
    ];


    return [
        'products' => $products_situations,
        'categories' => $categories_situations,
        'product-addons' => $paddons_situations,
        'product-requirements' => $prequirements_situations,
        'shared-servers' => $shared_server_situations,
        'orders' => $orders_situations,
        'updowngrades' => $updowngrades_situations,
        'cancellation' => $cancellation_situations,
        'origins' => $origin_situations,
        'invoices' => $invoices_situations,
        'ticket_requests' => $ticket_request_situations,
        'users' => $users_situations,
        'cfeedbacks' => $cfeedback_situations,
        'tasks'     => $tasks_situations,
        'reminders' => $reminders_situations,
        'admins'    => $admin_situations,
        'custom-fields' => $custom_field_situations,
        'user-document-record' => $user_document_record,
        'affiliate-withdrawal' => $affiliate_withdrawal,
        'affiliate-transaction' => $affiliate_transaction,
        'subscription' => $subscription_situations,
    ];