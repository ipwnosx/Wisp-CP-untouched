<?php 
return [
    'logged-on'                                           => 'User has logged in',
    'changed-language-status'                             => [
        'content'   => 'The settings of the {name} ({key}) language have been updated',
        'variables' => '{key},{name}',
    ],
    'changed-language-values'                             => [
        'content'   => 'The variables of the {name} ({key}) language have been updated',
        'variables' => '{key},{name}',
    ],
    'changed-localization-settings'                       => 'Location updated',
    'updated-privileges'                                  => [
        'content'   => '{name} permission has been updated',
        'variables' => '{name}',
    ],
    'changed-user-address'                                => [
        'content'   => '{user_name} (#{user_id}) address information has been updated',
        'variables' => '{id},{user_id},{user_name}',
    ],
    'changed-product-addon'                               => [
        'content'   => 'The product / service addon named #{id} {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'changed-product'                                     => [
        'content'   => 'Changed the information for the product named #{id} {name} in the {type} product group',
        'variables' => '{type},{id},{name}',
    ],
    'changed-order-status'                                => [
        'content'   => 'The status of the {name} Order No. #{id} was changed to {status}',
        'variables' => '{id},{name},{status}',
    ],
    'changed-user-informations'                           => [
        'content'   => 'The information for the client with ID number #{id} has been changed',
        'variables' => '{id}',
    ],
    'hosting-shared-server-accounts-were-imported'        => [
        'content'   => 'The {module} module and the {imported} data were transferred through the shared server named  "{hostname} - {server_ip} #{id}"',
        'variables' => '{module},{hostname},{server_ip},{id},{imported}',
    ],
    'changed-payment-module-settings'                     => [
        'content'   => 'Changed the settings for the payment method {module}',
        'variables' => '{module},{name}',
    ],
    'changed-informations-settings'                       => 'Settings / Site Information updated',
    'changed-other-settings'                              => 'Settings / Other Information updated',
    'changed-blocks-ranking'                              => [
        'content'   => 'For the {lang} language, the settings / homepage block order has been updated',
        'variables' => '{lang}',
    ],
    'visitor-statistics-cleaned'                          => 'Today and yesterday\'s site statistical information was reset',
    'changed-currency-status'                             => [
        'content'   => 'The status of the {code}  currency has been changed',
        'variables' => '{id},{code}',
    ],
    'changed-product-group'                               => [
        'content'   => '#{id} ID numbered product group updated',
        'variables' => '{id}',
    ],
    'deleted-user-address'                                => [
        'content'   => '#{id} numbered address information of client number #{user_id}  has been updated',
        'variables' => '{id},{user_id}',
    ],
    'changed-backgrounds-settings'                        => "Changes have been made to Settings / Header background Images\n",
    'changed-status-ticket-request'                       => [
        'content'   => "The status of support request #{id} was changed to {status}\n",
        'variables' => '{id},{status}',
    ],
    'assign-ticket-request'                               => [
        'content'   => 'The support request #{id}  was assigned to the Staff  {assigned} by {assignedBy}',
        'variables' => '{id},{assigned},{assignedBy}',
    ],
    'changed-ticket-request'                              => [
        'content'   => '#{id} Support request has been modified',
        'variables' => '{id}',
    ],
    'deleted-ticket-request'                              => [
        'content'   => '#{id} Support request has been deleted',
        'variables' => '{id}',
    ],
    'changed-security-transaction-blocking'               => 'Changes to your security settings have been made',
    'deleted-ticket-request-reply'                        => [
        'content'   => '#{reply_id} response to #{ticket_id} support request has been deleted',
        'variables' => '{ticket_id},{reply_id}',
    ],
    'changed-knowledgebase'                               => [
        'content'   => 'A knowledge base article named #{id} {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'changed-menu'                                        => [
        'content'   => 'The menu named #{id} {name} has been modified',
        'variables' => '{id},{name}',
    ],
    'changed-contract1'                                   => [
        'content'   => 'The  "Service and Usage Agreement " has been updated for the {lang} language',
        'variables' => '{lang}',
    ],
    'changed-contract2'                                   => [
        'content'   => 'The  "Personal Data and General Privacy Agreement " has been updated for the {lang} language',
        'variables' => '{lang}',
    ],
    'changed-domain-whois-privacy'                        => [
        'content'   => 'The whois privacy status for the #{id} domain name has been updated to {status}',
        'variables' => '{id},{status}',
    ],
    'changed-currency-settings'                           => [
        'content'   => 'The settings for the currency {code} have been updated',
        'variables' => '{id},{code}',
    ],
    'user-password-is-reset-and-sent'                     => [
        'content'   => 'A password reset message was sent to the client named #{user_id} {user_name}',
        'variables' => '{user_id},{user_name}',
    ],
    'changed-notification-template'                       => [
        'content'   => 'The notification template named {name} has been updated',
        'variables' => '{key},{name}',
    ],
    'changed-notification-templates-settings'             => 'Updated notification for template settings',
    'sent-mail-to-user'                                   => [
        'content'   => 'Mail sent to client #{user_id} {user_name}',
        'variables' => '{user_id},{user_name}',
    ],
    'bulk-mail-sent'                                      => 'Bulk email was sent',
    'changed-user-group'                                  => 'Client groups updated',
    'reply-ticket-request'                                => [
        'content'   => 'Support request #{id} answered',
        'variables' => '{id}',
    ],
    'changed-invoice-status'                              => [
        'content'   => 'The status of invoice #{id} has been changed to {status}',
        'variables' => '{id},{status}',
    ],
    'changed-product-category'                            => [
        'content'   => 'The product group category named #{id} {name} has been updated',
        'variables' => '{name},{id}',
    ],
    'updated-order-detail'                                => [
        'content'   => 'Detail information of order number {name} (#{id}) has been updated',
        'variables' => '{id},{name}',
    ],
    'deleted-order'                                       => [
        'content'   => '{name} (#{id}) numbered order has been deleted',
        'variables' => '{id},{name}',
    ],
    'changed-user-addon'                                  => [
        'content'   => 'The information for the #{order_id} order\'s {addon_name} #{addon_id} has been updated',
        'variables' => '{order_id},{addon_id},{addon_name}',
    ],
    'suspended-order'                                     => [
        'content'   => 'The order named #{id} {name} is suspended',
        'variables' => '{id},{name}',
    ],
    'activated-order'                                     => [
        'content'   => 'The order named #{id} {name} has been activated',
        'variables' => '{id},{name}',
    ],
    'approved-order'                                      => [
        'content'   => 'The order named #{id} {name} has been approved',
        'variables' => '{id},{name}',
    ],
    'changed-origin-detail'                               => [
        'content'   => '#{order_id} numbered #{origin_id} Sender ID has been updated',
        'variables' => '{order_id},{origin_id}',
    ],
    'changed-news-page'                                   => [
        'content'   => "The News and Announcements page #{id} {name} has been updated\n",
        'variables' => '{id},{name}',
    ],
    'deleted-news-page-header-background'                 => [
        'content'   => 'The background image of the News and Announcements page named #{id} {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'deleted-news-page'                                   => [
        'content'   => 'The News and Announcements page named #{id} {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'added-new-news-page'                                 => [
        'content'   => "Added a News and Announcements page named {name}\n",
        'variables' => '{id},{name}',
    ],
    'deleted-articles-page'                               => [
        'content'   => 'The blog page named #{id} {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'added-new-articles-page'                             => [
        'content'   => 'A blog page named {name} has been added',
        'variables' => '{id},{name}',
    ],
    'changed-articles-page'                               => [
        'content'   => 'The blog page named #{id} {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'changed-article-category'                            => [
        'content'   => 'The blog category #{id} {name} has been updated',
        'variables' => '{name},{id}',
    ],
    'changed-block-options'                               => [
        'content'   => 'The home block settings for the {lang} language have been updated',
        'variables' => '{lang},{key}',
    ],
    'changed-bill-detail'                                 => [
        'content'   => '#{id} Invoice details have been updated',
        'variables' => '{id}',
    ],
    'deleted-bill-taxed-file'                             => [
        'content'   => 'The invoice file for invoice #{id} has been deleted',
        'variables' => '{id}',
    ],
    'cancelled-order'                                     => [
        'content'   => 'The order named #{id} {name} has been cancelled',
        'variables' => '{id},{name}',
    ],
    'deleted-order-cancellation-request'                  => [
        'content'   => 'The request to cancel order number #{id} has been deleted',
        'variables' => '{id}',
    ],
    'approved-order-cancellation-request'                 => [
        'content'   => 'Request to cancel order named #{order_id} {order_name} has been confirmed',
        'variables' => '{order_id},{order_name},{id}',
    ],
    'deleted-contact-message'                             => [
        'content'   => 'The contact form message #{id} ID was deleted',
        'variables' => '{id}',
    ],
    'readed-contact-message'                              => [
        'content'   => 'The contact form message #{id} ID is marked as read',
        'variables' => '{id}',
    ],
    'added-new-knowledgebase-category'                    => [
        'content'   => 'Added a knowledge base category named {name}',
        'variables' => '{name},{id}',
    ],
    'replied-contact-message'                             => [
        'content'   => 'The reply to contact form #{id} has been sent',
        'variables' => '{id},{visitor_name},{visitor_email}',
    ],
    'deleted-software-license-error'                      => [
        'content'   => 'The software license warning #{id} has been deleted',
        'variables' => '{id}',
    ],
    'added-new-menu'                                      => [
        'content'   => 'A new menu named {name} has been added',
        'variables' => '{id},{name}',
    ],
    'changed-menu-ranking'                                => 'The menu order has been updated',
    'changed-security-bot-shield'                         => 'Botshield settings updated',
    'changed-security-captcha'                            => 'Captcha settings updated',
    'created-new-bill'                                    => [
        'content'   => 'A new invoice numbered #{id} has been created',
        'variables' => '{id}',
    ],
    'changed-modules-settings'                            => [
        'content'   => '{type} module settings have been updated',
        'variables' => '{type}',
    ],
    'deleted-invoice'                                     => [
        'content'   => 'Invoice #{id} has been deleted',
        'variables' => '{id}',
    ],
    'changed-seo-routes-settings'                         => 'SEO URL Structure updated',
    'logged-out'                                          => 'The session is closed',
    'changed-membership-settings'                         => 'Membership settings updated',
    'deleted-updown-request'                              => [
        'content'   => 'The request for upgrade #{id} has been deleted',
        'variables' => '{id}',
    ],
    'added-new-user-address'                              => [
        'content'   => 'An address numbered #{id} has been defined for the client named #{user_id} {user_name}',
        'variables' => '{id},{user_id},{user_name}',
    ],
    'deleted-coupon'                                      => [
        'content'   => 'The coupon {code} has been deleted',
        'variables' => '{id},{code}',
    ],
    'added-new-coupon'                                    => [
        'content'   => 'Added coupon with {code}',
        'variables' => '{code}',
    ],
    'changed-coupon'                                      => [
        'content'   => '{code} coded coupon updated',
        'variables' => '{code},{id}',
    ],
    'changed-invoice-informations'                        => [
        'content'   => 'The information for invoice #{id} has been updated',
        'variables' => '{id}',
    ],
    'invoice-has-been-approved'                           => [
        'content'   => 'Payment of invoice #{id} is confirmed',
        'variables' => '{id},{status}',
    ],
    'added-upgrade-invoice'                               => [
        'content'   => "An upgrade invoice has been created for the #{order_id} ({old-product}) /  ({new-product})\n",
        'variables' => '{order_id},{old-product},{new-product}',
    ],
    'updated-order-server'                                => [
        'content'   => "The server information for the order named #{id} {name} has been updated\n",
        'variables' => '{id},{name}',
    ],
    'added-user-up-credit'                                => [
        'content'   => '#{user_id} ID to client, {amount} amount of credit was loaded. There was a balance of {before_balance} before loading. Updated to {new_balance} after loaded',
        'variables' => '{id},{user_id},{before_balance},{new_balance},{amount}',
    ],
    'added-user-down-credit'                              => [
        'content'   => 'The credit for {amount} has been removed from client ID number {user_id}. It had a balance of {before_balance} before this was removed. It was updated to {new_balance} after this was removed.',
        'variables' => '{id},{user_id},{before_balance},{new_balance},{amount}',
    ],
    'changed-hosting-shared-server'                       => [
        'content'   => "#{id} {name} hosting shared server information has been updated\n",
        'variables' => '{name},{id}',
    ],
    'added-new-ticket-request'                            => [
        'content'   => 'Support request #{id} was created',
        'variables' => '{id},{status}',
    ],
    'deleted-user'                                        => [
        'content'   => 'The client named #{user_id} {user_name} has been deleted',
        'variables' => '{user_id},{user_name}',
    ],
    'forgotten-password'                                  => 'Password reminder notification sent',
    'changed-general-information'                         => 'Account information updated',
    'upgraded-order'                                      => [
        'content'   => 'Order #{order_id} ID numbered {old-product}/{new-product} has been upgraded',
        'variables' => '{order_id},{old-product},{new-product}',
    ],
    'downgraded-order'                                    => [
        'content'   => 'Order #{order_id} ID numbered {old-product}/{new-product} has been downgraded',
        'variables' => '{id},{old-product},{new-product}',
    ],
    'deleted-cash-item'                                   => 'The cash record has been deleted',
    'approved-updown-request'                             => [
        'content'   => 'Order upgrade request #{id} is approved',
        'variables' => '{id},{status}',
    ],
    'changed-currency-rates'                              => 'Currency rates updated',
    'changed-intl-sms-country-prices'                     => 'International SMS delivery fees have been updated',
    'changed-automation-settings'                         => 'The automation settings have been updated',
    'deleted-order-addon'                                 => [
        'content'   => 'The #{id} order addon has been deleted',
        'variables' => '{id}',
    ],
    'added-user-addon'                                    => 'Added order addon',
    'changed-order-addon-status'                          => [
        'content'   => 'The status of order addon numbered #{id} has been updated to {status}',
        'variables' => '{id},{status}',
    ],
    'order-addon-has-been-activated'                      => [
        'content'   => 'The numbered #265 order addon has been activated',
        'variables' => '{order_id},{id}',
    ],
    'created-invoice'                                     => [
        'content'   => '{count} renewal invoice has been created',
        'variables' => '{count}',
    ],
    'reminded-invoice'                                    => [
        'content'   => '{count} invoices reminded',
        'variables' => '{count}',
    ],
    'cancelled-invoices-has-been-deleted'                 => [
        'content'   => '{count} cancelled invoices has been deleted',
        'variables' => '{count}',
    ],
    'delayed-invoices-has-been-cancelled'                 => [
        'content'   => '{count} last payment date overdue invoice were cancelled',
        'variables' => '{count}',
    ],
    'overdue-invoice-has-been-reported'                   => [
        'content'   => '{count} overdue invoices were reminded',
        'variables' => '{count}',
    ],
    'unverified-accounts-has-been-deleted'                => [
        'content'   => '{count} unverified accounts deleted',
        'variables' => '{count}',
    ],
    'orders-has-been-cancelled'                           => [
        'content'   => '{count} order cancelled',
        'variables' => '{count}',
    ],
    'pending-orders-has-been-deleted'                     => [
        'content'   => '{count} order deleted',
        'variables' => '{count}',
    ],
    'replied-tickets-has-been-resolved'                   => [
        'content'   => '{count} answered support tickets has been marked as resolved',
        'variables' => '{count}',
    ],
    'replied-tickets-has-been-locked'                     => [
        'content'   => '{count} support request has been locked',
        'variables' => '{count}',
    ],
    'actions-has-been-deleted'                            => 'Activity log cleared',
    'non-order-accounts-has-been-deleted'                 => [
        'content'   => '{count} non-order accounts were deleted',
        'variables' => '{count}',
    ],
    'low-balance-accounts-has-been-reminded'              => 'Notification has been sent to clients whose balance is low',
    'changed-domain-list'                                 => 'Domain name extensions updated',
    'pending-domain-transfer-orders-has-been-activated'   => [
        'content'   => '{count} pending transfer orders were activated',
        'variables' => '{count}',
    ],
    'added-predefined-reply'                              => [
        'content'   => 'Added a ready reply named {name}',
        'variables' => '{id},{name}',
    ],
    'changed-predefined-reply'                            => [
        'content'   => 'The ready reply named {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'added-new-predefined-category'                       => [
        'content'   => 'Added a ready reply category named {name}',
        'variables' => '{id},{name}',
    ],
    'changed-predefined-category'                         => [
        'content'   => 'The ready reply category named {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'deleted-ticket-predefined-reply'                     => [
        'content'   => '#{id} numbered  "Ready reply " deleted',
        'variables' => '{id}',
    ],
    'deleted-ticket-predefined-replies-category'          => [
        'content'   => '#{id} numbered "Ready reply category " deleted',
        'variables' => '{id}',
    ],
    'changed-taxation-settings'                           => 'Taxation settings updated',
    'deleted-news-page-cover'                             => [
        'content'   => 'The list image of the news titled {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'deleted-user-group'                                  => [
        'content'   => 'A client group named {id} {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'changed-security-backup-settings'                    => 'The backup settings have been updated',
    'changed-sms-module-settings'                         => [
        'content'   => 'Updated the settings for the SMS module named {module}',
        'variables' => '{module},{name}',
    ],
    'sent-sms-to-user'                                    => [
        'content'   => "An SMS was sent to a client named #{user_id} {user_name}\n",
        'variables' => '{user_id},{user_name}',
    ],
    'changed-your-admin-information'                      => [
        'content'   => 'The information of the staff member named #{id} {name} has been updated',
        'variables' => '{name},{id}',
    ],
    'updated-order-hosting'                               => [
        'content'   => 'The hosting information for the order #{id} {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'bulk-sms-sent'                                       => 'Bulk SMS was sent',
    'deleted-product-category'                            => [
        'content'   => 'The category #{id} of the product group {type} has been deleted',
        'variables' => '{type},{id}',
    ],
    'deleted-product'                                     => [
        'content'   => 'Product id #{id} of the {type} product group has been deleted',
        'variables' => '{type},{id}',
    ],
    'deleted-shared-server'                               => [
        'content'   => 'The shared server named #{id} {name}-{ip} has been deleted',
        'variables' => '{id},{name},{ip}',
    ],
    'created-backup-db'                                   => 'The database backup was created',
    'changed-user-notes'                                  => [
        'content'   => 'The note of client ID {user_id} has been updated',
        'variables' => '{user_id}',
    ],
    'active-orders-has-been-suspended'                    => [
        'content'   => '{count} active orders suspended',
        'variables' => '{count}',
    ],
    'notifications-has-been-deleted'                      => 'Critical process notifications are cleared',
    'changed-department'                                  => [
        'content'   => 'The department named {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'has-been-blocked-user'                               => [
        'content'   => 'The account for the client named #{user_id} {user_name} has been blocked',
        'variables' => '{user_id},{user_name}',
    ],
    'has-been-activated-user'                             => [
        'content'   => 'The account for the client named #{user_id} {user_name} has been activated',
        'variables' => '{user_id},{user_name}',
    ],
    'added-in-cash'                                       => 'Added entry to the cash till',
    'added-new-language'                                  => [
        'content'   => 'New language named {name} ({key}) was created',
        'variables' => '{key},{name},{country-code}',
    ],
    'reminder-of-login-information'                       => [
        'content'   => 'A password reset message was sent to the client named #{user_id} {user_name}',
        'variables' => '{user_id},{user_name}',
    ],
    'changed-inex'                                        => 'The cash record is updated',
    'deleted-language'                                    => [
        'content'   => 'Language named {name} ({key}) has been deleted',
        'variables' => '{key},{name}',
    ],
    'changed-language'                                    => [
        'content'   => 'Language named {name} ({key}) has been updated',
        'variables' => '{key},{name},{country-code}',
    ],
    'changed-seo-settings'                                => 'Seo setting updated',
    'changed-security-settings'                           => 'Security settings updated',
    'deleted-domain'                                      => [
        'content'   => 'The domain name extension numbered #{id} was deleted',
        'variables' => '{id}',
    ],
    'verified-user-email'                                 => [
        'content'   => 'The client email address #{user_id} {user_name} has been approved',
        'variables' => '{user_id},{user_name}',
    ],
    'verified-user-gsm'                                   => [
        'content'   => 'The client Netgsm number  #{user_id} {user_name} has been approved',
        'variables' => '{user_id},{user_name}',
    ],
    'changed-intl-sms-automation-settings'                => 'International SMS automation settings updated',
    'hosting-password-has-been-reset'                     => [
        'content'   => 'The hosting password for order numbered #{id} has been updated',
        'variables' => '{id}',
    ],
    'deleted-product-requirement-category'                => [
        'content'   => 'The product requirement category numbered #{id} has been deleted',
        'variables' => '{id}',
    ],
    'changed-product-requirement'                         => [
        'content'   => 'The product requirement information named #{id} {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'changed-slide'                                       => [
        'content'   => 'The slider named #{id}-{name} has been updated',
        'variables' => '{id},{name}',
    ],
    'added-new-slide'                                     => [
        'content'   => 'The slider named #{id}-{name} has been added',
        'variables' => '{id},{name}',
    ],
    'deleted-header-menu'                                 => [
        'content'   => 'The header menu named #{id}-{name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'deleted-footer-menu'                                 => [
        'content'   => 'The footer menu named #{id}-{name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'deleted-product-addon-category'                      => [
        'content'   => 'The product add-on category numbered #{id} has been deleted',
        'variables' => '{id}',
    ],
    'changed-normal-page'                                 => [
        'content'   => 'The page titled #{id} - {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'deleted-pages-sidebar-menu'                          => [
        'content'   => 'The sidebar menu named #{id} - {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'deleted-references-page'                             => [
        'content'   => 'The reference page named #{id} - {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'deleted-article-category-header-background'          => [
        'content'   => 'The header background image of the post titled #{id} - {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'changed-reference-category'                          => [
        'content'   => 'The reference category named #{id} - {name} has been updated',
        'variables' => '{name},{id}',
    ],
    'added-new-reference-category'                        => [
        'content'   => 'Added a reference category named #{id} - {name}',
        'variables' => '{name},{id}',
    ],
    'added-new-references-page'                           => [
        'content'   => 'Added a reference named #{id} - {name}',
        'variables' => '{id},{name}',
    ],
    'deleted-cfeedback'                                   => [
        'content'   => 'The client comment named #{id} - {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'changed-cfeedback'                                   => [
        'content'   => 'Updated client comment named #{id} - {name}',
        'variables' => '{id},{name}',
    ],
    'added-new-cfeedback'                                 => [
        'content'   => 'Added a client comment named #{id} - {name}',
        'variables' => '{id},{name}',
    ],
    'deleted-product-group'                               => [
        'content'   => 'The product group named #{id} - {name} has been deleted',
        'variables' => '{name},{id}',
    ],
    'added-new-product-category'                          => [
        'content'   => 'The product group category named #{id} - {name} has been added',
        'variables' => '{name},{id}',
    ],
    'added-product'                                       => [
        'content'   => 'A product named {name} of type {type} has been added',
        'variables' => '{type},{id},{name}',
    ],
    'changed-references-page'                             => [
        'content'   => 'The reference page named #{id} - {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'deleted-references-page-cover'                       => [
        'content'   => 'The list image of the reference page named #{id} - {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'deleted-knowledgebase-category'                      => [
        'content'   => 'The knowledge base category #{id} - {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'changed-knowledgebase-category'                      => [
        'content'   => 'The knowledge base category #{id} - {name} has been updated',
        'variables' => '{name},{id}',
    ],
    'hosting-has-been-re-established'                     => [
        'content'   => 'The hosting account of order #{id} has been re-built',
        'variables' => '{id}',
    ],
    'hosting-has-been-removed'                            => [
        'content'   => 'The hosting account of order numbered #{id} has been deleted',
        'variables' => '{id}',
    ],
    'changed-module-settings'                             => [
        'content'   => 'Updated the settings for module {module} of type {type}',
        'variables' => '{type},{module}',
    ],
    'added-new-user-custom-field'                         => [
        'content'   => 'A new client custom field has been created for the {lang} language',
        'variables' => '{lang}',
    ],
    'deleted-user-custom-field'                           => [
        'content'   => 'The custom client field numbered #{id} has been deleted',
        'variables' => '{id}',
    ],
    'changed-user-custom-fields'                          => 'Custom client fields have been updated',
    'changed-registrars-module-settings'                  => [
        'content'   => '{module} domain name registration module settings have been updated',
        'variables' => '{module},{name}',
    ],
    'deleted-product-cover'                               => [
        'content'   => 'The listing image for the product named {id} {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'deleted-product-order-image'                         => [
        'content'   => 'The product image of the order named #{id} {name} has been deleted',
        'variables' => '{id},{name}',
    ],
    'sign-up'                                             => 'A client account has been registered',
    'added-new-address'                                   => [
        'content'   => 'New address added',
        'variables' => '{id}',
    ],
    'changed-address'                                     => [
        'content'   => 'Address information updated',
        'variables' => '{id}',
    ],
    'balance-credit-has-been-purchased'                   => [
        'content'   => 'A credit of {amount} has been loaded.',
        'variables' => '{amount}',
    ],
    'changed-preferences'                                 => 'The account preferences have been updated',
    'i-paid-by-credit'                                    => [
        'content'   => 'Payment from fund balance {amount} has been charged',
        'variables' => '{checkout_id},{amount},{before_credit},{last_credit},{currency}',
    ],
    'paid-bill-by-credit'                                 => [
        'content'   => 'Payment for invoice numbered #{invoice_id} from fund balance {amount_paid} was charged',
        'variables' => '{invoice_id},{old_credit},{new_credit},{amount_paid}',
    ],
    'downloaded-order-file'                               => [
        'content'   => 'The file for order numbered #{id} was downloaded on {time}',
        'variables' => '{id},{time}',
    ],
    'changed-domain-dns'                                  => [
        'content'   => 'The DNS information for the domain {domain} has been updated',
        'variables' => '{domain}',
    ],
    'changed-domain-transferlock'                         => [
        'content'   => 'The transfer lock status for the {domain} domain name has been changed',
        'variables' => '{status},{domain}',
    ],
    'deleted-user-credit'                                 => [
        'content'   => 'Fund record for {amount} of client numbered #{user_id} has been deleted There was a fund amount of {before_amount} before it was deleted after deletion, it has been updated to {new_balance}',
        'variables' => '{id},{user_id},{before_amount},{new_balance},{amount}',
    ],
    'added-new-sms-origin'                                => 'The new SMS sender ID has been created',
    'send-sms'                                            => 'Bulk SMS delivery was performed',
    'upgrade-request-was-made'                            => [
        'content'   => 'A request to upgrade to {new-product} from the {old-product} package for order numbered #{order_id} was created',
        'variables' => '{order_id},{old-product},{new-product}',
    ],
    'added-hosting-new-email'                             => [
        'content'   => 'The {email} email address was created on the hosting order named #{order_id} {order_name}',
        'variables' => '{order_id},{order_name},{email}',
    ],
    'changed-hosting-email-password'                      => [
        'content'   => 'The {email} email address password on the hosting order named #{order_id} {order_name} has been changed',
        'variables' => '{order_id},{order_name},{email}',
    ],
    'added-hosting-email-forward'                         => [
        'content'   => '{email} mail address redirected to {forward} mail',
        'variables' => '{order_id},{order_name},{email},{forward}',
    ],
    'changed-hosting-password'                            => [
        'content'   => 'The hosting account password named #{order_id} {order_name} has been changed',
        'variables' => '{order_id},{order_name}',
    ],
    'canceled-product-request'                            => [
        'content'   => 'A cancellation request was created for order numbered #{id}',
        'variables' => '{id}',
    ],
    'added-new-sms-origin-pre-register-country'           => 'The pre-registered country for the SMS sender ID has been defined',
    'changed-intl-sms-origin'                             => [
        'content'   => 'The SMS sender ID named {name} has been updated',
        'variables' => '{id},{name}',
    ],
    'deleted-intl-sms-origin'                             => [
        'content'   => 'The SMS sender ID numbered {id} has been deleted',
        'variables' => '{id}',
    ],
    'has-been-created-ticket'                             => 'A new support ticket has been created',
    'replied-to-ticket'                                   => [
        'content'   => 'Support ticket numbered #{ticket_id} was answered',
        'variables' => '{ticket_id}',
    ],
    'update-balance-settings'                             => 'Fund balance settings updated',
    'address-has-been-deleted'                            => 'Address information updated',
    'changed-email-newsletter'                            => 'email newsletter updated',
    'changed-sms-newsletter'                              => 'SMS newsletter updated',
    'order-cancellation-request-processing-received'      => [
        'content'   => '{count} order cancellation request was processed',
        'variables' => '{count}',
    ],
    'activation-message-sent'                             => [
        'content'   => 'An activation message has been sent for order number {name} (#{id})',
        'variables' => '{id},{name}',
    ],
    'added-domain-cns'                                    => [
        'content'   => 'Added a new nameserver for the domain name for {domain}. Name: {ns}, IP: {ip}',
        'variables' => '{domain},{ns},{ip}',
    ],
    'changed-domain-cns'                                  => [
        'content'   => 'The child nameserver information for the domain named {domain} has been changed. Old Name: {old_ns}, Old IP: {old_ip}, New Name: {new_ns}, New IP: {new_ip}',
        'variables' => '{id},{name}',
    ],
    'deleted-domain-cns'                                  => [
        'content'   => 'The {cns-name} : {cns-ip} child nameserver information for the domain name {name} (#{id}) was deleted',
        'variables' => '{id},{name},{cns-name},{cns-ip}',
    ],
    'changed-domain-whois'                                => [
        'content'   => 'The whois information for the domain named {name} (#{id}) has been updated',
        'variables' => '{id},{name}',
    ],
    'changed-domain-whois-infos'                          => [
        'content'   => 'Updated whois information of the {domain} domain name.',
        'variables' => '{domain}',
    ],
    'added-new-admin'                                     => [
        'content'   => 'Added a new staff member. Name: {name}, E-Posta: {email}, ID: {id}',
        'variables' => '{id},{name},{email}',
    ],
    'added-new-hosting-shared-server'                     => [
        'content'   => 'A new shared server named {name} has been added',
        'variables' => '{id},{name}',
    ],
    'added-new-product-group'                             => [
        'content'   => 'A new product group named {name} (#{id}) has been added',
        'variables' => '{id},{name}',
    ],
    'added-new-user'                                      => [
        'content'   => 'A new client named {name} (#{id}) has been added',
        'variables' => '{id},{name}',
    ],
    'changed-hosting-email-quota'                         => [
        'content'   => 'Updated the quota for the email {email} in the (#{id} {name}) Hosting account.',
        'variables' => '{id},{name},{email}',
    ],
    'deleted-hosting-email'                               => [
        'content'   => 'The {email} email address of the hosting order numbered {name} (#{id}) has been deleted',
        'variables' => '{id},{name},{email}',
    ],
    'deleted-hosting-email-forward'                       => [
        'content'   => 'The {forward} redirect for the {email} email address was deleted on the hosting order numbered {name} (#{id}) ',
        'variables' => '{id},{name},{email},{forward}',
    ],
    'changed-mail-module-settings'                        => [
        'content'   => 'An update was made in the mail module named {name}',
        'variables' => '{module},{name}',
    ],
    'contract1-is-approved'                               => 'Service and use agreement accepted.',
    'contract2-is-approved'                               => 'Personal data and general privacy agreement accepted.',
    'deleted-notification-header-logo'                    => 'Header logo for notification templates has been deleted',
    'deleted-notification-footer-logo'                    => 'Footer logo for notification templates has been deleted',
    'domain-imported'                                     => [
        'content'   => 'The data {imported} was transferred through the module named {module}',
        'variables' => '{module},{imported}',
    ],
    'domain-whois-privacy-disabled'                       => [
        'content'   => 'The Whois protection of the {domain} domain name has been deactivated.',
        'variables' => '{domain}',
    ],
    'domain-whois-privacy-enabled'                        => [
        'content'   => 'The Whois protection of the {domain} domain name has been activated.',
        'variables' => '{domain}',
    ],
    'hosting-shared-server-data-were-imported'            => [
        'content'   => 'With the {module} module, the data {imported} was transferred through the shared server named  "{hostname} - {server_ip} #{id} "',
        'variables' => '{module},{hostname},{server_ip},{id},{imported}',
    ],
    'oder-blocks-has-been-modified'                       => [
        'content'   => 'Changes were made to the blocks of order number {name} (#{id}) ',
        'variables' => '{id},{name}',
    ],
    'server-has-been-deleted'                             => [
        'content'   => 'The server named {name} (#{id}) was automatically deleted',
        'variables' => '{id},{name}',
    ],
    'server-has-been-power-off'                           => [
        'content'   => 'The server named {name} (#{id}) was automatically shutdown',
        'variables' => '{id},{name}',
    ],
    'server-has-been-shutdown'                            => [
        'content'   => 'The server named {name} (#{id}) was automatically shutdown',
        'variables' => '{id},{name}',
    ],
    'server-has-been-power-on'                            => [
        'content'   => 'The server named {name} (#{id}) was automatically activated',
        'variables' => '{id},{name}',
    ],
    'server-has-been-reboot'                              => [
        'content'   => 'The server named {name} (#{id}) was automatically restarted',
        'variables' => '{id},{name}',
    ],
    'server-has-been-rebuilt'                             => [
        'content'   => 'The server named {name} (#{id}) was automatically rebuilt',
        'variables' => '{id},{name}',
    ],
    'server-has-been-reset'                               => [
        'content'   => 'The server named {name} (#{id}) was automatically reset',
        'variables' => '{id},{name}',
    ],
    'server-order-installed'                              => [
        'content'   => 'The server named {name} (#{id}) was automatically setup',
        'variables' => '{id},{name}',
    ],
    'a-new-reminder-added'                                => [
        'content'   => 'A new reminder has been created. ID: #{id}',
        'variables' => '{id}',
    ],
    'a-new-task-plan-added'                               => [
        'content'   => 'A new task plan has been created. Title: {title}, ID: {id}',
        'variables' => '{id},{title}',
    ],
    'added-new-knowledgebase'                             => [
        'content'   => 'A new knowledge Base article was created with the titled (#{id} {name})',
        'variables' => '{id},{name}',
    ],
    'added-new-privileges'                                => 'A new administrator authorization rule was created.',
    'added-new-product-requirement'                       => [
        'content'   => 'A new product requirement named (#{id} {name}) has been created.',
        'variables' => '{id},{name}',
    ],
    'added-new-sms-group'                                 => 'A new SMS number group has been created.',
    'changed-group-numbers'                               => 'The numbers of the SMS group have been changed.',
    'auto-periodic-outgoing-in-cash-added'                => [
        'content'   => '{count} qty were registered in the case. (Automatic)',
        'variables' => '{count}',
    ],
    'change-addon-status-enable'                          => [
        'content'   => 'The status of the add-on named {module} has been activated.',
        'variables' => '{module}',
    ],
    'change-addon-status-disable'                         => [
        'content'   => 'The status of the add-on named {module} has been de-activated.',
        'variables' => '{module}',
    ],
    'change-software-domain'                              => [
        'content'   => 'Updated the license information for the software (# {order_id} {order_name}). Old domain name: {old_domain} New domain name: {new_domain}',
        'variables' => '{order_id},{old_domain},{new_domain},{order_name}',
    ],
    'changed-email-address'                               => [
        'content'   => 'Email address changed. Old: {before_email}, New: {new_email}',
        'variables' => '{before_email},{new_email}',
    ],
    'changed-gsm-number'                                  => [
        'content'   => 'Gsm number changed. Old: {before_gsm}, New: {new_gsm}',
        'variables' => '{before_gsm},{new_gsm}',
    ],
    'changed-password'                                    => 'Account password changed.',
    'changed-theme-settings'                              => [
        'content'   => 'Changed the settings of the theme named {name}.',
        'variables' => '{name',
    ],
    'changed-ticket-custom-field'                         => [
        'content'   => 'Updated the settings for the custom field named (#{id} {name}) on the support system.',
        'variables' => '{id},{name}',
    ],
    'changed-ticket-request-reply'                        => [
        'content'   => '#Response to support request number {ticket_id} was revised.',
        'variables' => '{ticket_id},{reply_id}',
    ],
    'changed-your-admin-password'                         => 'The staff member password has been changed.',
    'connected-to-provider'                               => [
        'content'   => '{name} has been contacted.',
        'variables' => '{name}',
    ],
    'contact-form'                                        => 'Message sent from the contact form.',
    'contract1-is-unapproved'                             => 'The service and use agreement has been rejected.',
    'contract2-is-unapproved'                             => 'The personal data and the general privacy agreement have been rejected.',
    'deleted-knowledgebase'                               => [
        'content'   => 'The Knowledge Base article named (#{id}) {name} has been deleted.',
        'variables' => '{id},{name}',
    ],
    'deleted-sms-group'                                   => 'The SMS group has been deleted.',
    'hosting-orders-has-been-terminated'                  => [
        'content'   => '{count} qty hosting account, deleted via API.',
        'variables' => '{count}',
    ],
    'server-orders-has-been-terminated'                   => [
        'content'   => '{count} qty virtual server, deleted via API.',
        'variables' => '{count}',
    ],
    'knowledgebase-vote'                                  => [
        'content'   => 'The knowledge base has been voted.',
        'variables' => '{id},{vote}',
    ],
    'reminder-successfully-updated'                       => [
        'content'   => 'Reminder updated. ID: {id}',
        'variables' => '{id}',
    ],
    'send-international-sms'                              => 'International SMS sent.',
    'task-plan-changed'                                   => [
        'content'   => 'Task plan updated. ID: {id}',
        'variables' => '{id}',
    ],
    'the-number-owner-added-himself-to-the-black-list'    => [
        'content'   => 'Added number to blacklist. ID: {id}',
        'variables' => '{id}',
    ],
    'ticket-has-been-resolved'                            => [
        'content'   => '{id} numbered support Ticket is resolved.',
        'variables' => '{id}',
    ],
    'updated-sms-cancel-link'                             => 'SMS cancellation link has been changed.',
    'added-new-product-addon'                             => [
        'content'   => 'A new product add-on has been created. ID: {id}',
        'variables' => '{id},{name}',
    ],
    'added-new-promotion'                                 => [
        'content'   => "A new promotion has been created. ID: {id}, Ad\xc4\xb1: {name}",
        'variables' => '{id},{name}',
    ],
    'added-new-ticket-custom-field'                       => [
        'content'   => "A new support ticket custom field, has been created. ID: {id}, Ad\xc4\xb1: {name}",
        'variables' => '{id},{name}',
    ],
    'auto-domain-pricing-has-been-run'                    => 'Automatically updated domain name prices.',
    'changed-blocks-status'                               => [
        'content'   => 'Changed the status of the home blocks in the Web interface home page.',
        'variables' => '{lang}',
    ],
    'changed-promotion'                                   => [
        'content'   => "Promotion settings changed. ID: {id}, Ad\xc4\xb1: {name}",
        'variables' => '{id},{name}',
    ],
    'changed-tax-rates'                                   => 'Tax rate changed.',
    'changed-user-custom-field'                           => 'Editing made on client custom fields.',
    'copy-product'                                        => "\xc3\x9cr\xc3\xbcn Kopyaland\xc4\xb1.",
    'deleted-department'                                  => [
        'content'   => "Support Department is deleted. ID: {id}, Ad\xc4\xb1: {name}",
        'variables' => '{id},{name}',
    ],
    'deleted-product-addon'                               => [
        'content'   => 'Product Add-on is deleted. ID: {id}',
        'variables' => '{id}',
    ],
    'deleted-ticket-custom-field'                         => [
        'content'   => 'Support Ticket custom field is deleted. ID: {id}',
        'variables' => '{id}',
    ],
    'imported-from-another-software'                      => [
        'content'   => 'Imported through the {name} transfer tool.',
        'variables' => '{name}',
    ],
    'order-cancelled'                                     => [
        'content'   => 'The order (#{id} {name}) has been canceled.',
        'variables' => '{id},{name}',
    ],
    'orders-has-been-terminated'                          => [
        'content'   => '{count} orders deleted from the system.',
        'variables' => '{count}',
    ],
    'reminder-deleted'                                    => [
        'content'   => 'Numbered {id} reminder deleted.',
        'variables' => '{id}',
    ],
    'removed-theme'                                       => [
        'content'   => '{name} theme has been deleted from the system.',
        'variables' => '{name}',
    ],
    'restore-seo-routes-settings'                         => 'URL structure returned to default settings.',
    'theme-applied'                                       => [
        'content'   => 'The theme named {name} is set to default.',
        'variables' => '{name}',
    ],
    'theme-has-been-upgraded-version'                     => [
        'content'   => '{name} theme has been upgraded to version {version}.',
        'variables' => '{name},{version}',
    ],
    'updated-order-requirements'                          => [
        'content'   => 'Updated requirement information for order number (#{id} {name}).',
        'variables' => '{id},{name}',
    ],
    'uploaded-theme'                                      => [
        'content'   => 'A theme named {name} has been installed on the system.',
        'variables' => '{name}',
    ],
    'was-reminded-invoice'                                => [
        'content'   => 'Invoice number #{id} is Reminded.',
        'variables' => '{d}',
    ],
    'root-panel-accessed'                                 => 'Provided panel root access to the server {ip} ({name})',
    'paid-with-stored-card-1'                             => [
        'content'   => 'Invoice {id} numbered was paid by credit card {ln4} numbered.',
        'variables' => '{id},{ln4}',
    ],
    'paid-with-stored-card-2'                             => [
        'content'   => 'Invoice {id} numbered was auto-paid by credit card {ln4} numbered.',
        'variables' => '{id},{ln4}',
    ],
    'changed-order-auto-pay-status-on'                    => [
        'content'   => 'Automatic renewal activated for service {order_id} numbered.',
        'variables' => '{order_id},{order_name}',
    ],
    'changed-order-auto-pay-status-off'                   => [
        'content'   => 'Automatic renewal deactivated for service {order_id} numbered.',
        'variables' => '{order_id},{order_name}',
    ],
    'credit-card-is-set-as-default'                       => [
        'content'   => 'The credit card {ln4} numbered is set as default.',
        'variables' => '{ln4}',
    ],
    'credit-card-was-deleted'                             => [
        'content'   => 'The credit card {ln4} numbered has been deleted.',
        'variables' => '{ln4}',
    ],
    'changed-auto-payment-with-credit-card-on'            => 'Automatic payment has been enabled.',
    'changed-auto-payment-with-credit-card-off'           => 'Automatic payment has been disabled.',
    'automatic-payments-were-collected-from-credit-cards' => [
        'content'   => '{count} invoices were paid automatically by credit card.',
        'variables' => '{count}',
    ],
    'recurrence-subscription-cancelled'                   => [
        'content'   => 'Subscription for "{identifier}" identity has been canceled',
        'variables' => '{identifier}',
    ],
];
