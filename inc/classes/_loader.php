<?php
//BASE
require get_template_directory() . '/inc/classes/pages/Base_Page.php';

//CONTROLLER
require get_template_directory() . '/inc/classes/controllers/Lead_Controller.php';
require get_template_directory() . '/inc/classes/controllers/Assinante_Controller.php';
require get_template_directory() . '/inc/classes/controllers/Checkout_Controller.php';

//SERVICES
require get_template_directory() . '/inc/classes/services/Base_Service.php';
require get_template_directory() . '/inc/classes/services/Lead_Service.php';
require get_template_directory() . '/inc/classes/services/Assinante_Service.php';
require get_template_directory() . '/inc/classes/services/Pricing_Assinatura_Service.php';
require get_template_directory() . '/inc/classes/services/Sales_Service.php';
require get_template_directory() . '/inc/classes/services/DNA_Assinatura_Service.php';

// PAGES
require get_template_directory() . '/inc/classes/pages/Free_text.php';
require get_template_directory() . '/inc/classes/pages/Landing_page.php';
require get_template_directory() . '/inc/classes/pages/Index.php';
require get_template_directory() . '/inc/classes/pages/User_Leads.php';
require get_template_directory() . '/inc/classes/pages/Edit_lead.php';
require get_template_directory() . '/inc/classes/pages/User_Profile_Edit.php';
require get_template_directory() . '/inc/classes/pages/ASAAS_Config.php';
require get_template_directory() . '/inc/classes/pages/ASAAS_Checkout_Page.php';
require get_template_directory() . '/inc/classes/pages/Zapster_Config.php';
require get_template_directory() . '/inc/classes/pages/Login_Page.php';
require get_template_directory() . '/inc/classes/pages/Pick_View.php';
require get_template_directory() . '/inc/classes/pages/Assinantes_Archive.php';
require get_template_directory() . '/inc/classes/pages/Leads_Chat.php';
require get_template_directory() . '/inc/classes/pages/Lead_Importer_Manager.php';
require get_template_directory() . '/inc/classes/pages/Edit_assinante.php';
require get_template_directory() . '/inc/classes/pages/Usuarios_Page.php';
require get_template_directory() . '/inc/classes/pages/User_Edit_Page.php';
require get_template_directory() . '/inc/classes/pages/Usuario_Create_Page.php';
require get_template_directory() . '/inc/classes/pages/Thankyou.php';

// API
require get_template_directory() . '/inc/classes/api/Asaas_API.php';

// ROLES
require get_template_directory() . '/inc/classes/users/User_info.php';
require get_template_directory() . '/inc/classes/users/User_Role_Manager.php';

// ENDPOINTS
require get_template_directory() . '/inc/classes/endpoints/Checkout_Endpoint.php';

// WEBHOOK
require get_template_directory() . '/inc/classes/webhook/asaas-webhook.php';
require get_template_directory() . '/inc/classes/webhook/leadstaker-webhook.php';
require get_template_directory() . '/inc/classes/webhook/n8n-webhook.php';
require get_template_directory() . '/inc/classes/webhook/Checkout-Endpoint-REST.php';
require get_template_directory() . '/inc/classes/webhook/Lead-Endpoint-REST.php';
require get_template_directory() . '/inc/classes/webhook/Frase-Endpoint-REST.php';

// COMPONENTS
require get_template_directory() . '/inc/classes/components/Notification_Renderer.php';
require get_template_directory() . '/inc/classes/components/User_Dropdown.php';

// HELPERS
require get_template_directory() . '/inc/classes/helpers/Base_Query.php';
require get_template_directory() . '/inc/classes/helpers/Lead_Meta_Helper.php';
require get_template_directory() . '/inc/classes/helpers/Menu_Helper.php';
require get_template_directory() . '/inc/classes/helpers/Alert_Helper.php';
require get_template_directory() . '/inc/classes/helpers/Webhook_Helper.php';
require get_template_directory() . '/inc/classes/helpers/Media_Helper.php';
require get_template_directory() . '/inc/classes/helpers/Checkout_Link_Manager.php';
require get_template_directory() . '/inc/classes/helpers/Encryption.php';
require get_template_directory() . '/inc/classes/helpers/Modal_Handler.php';
require get_template_directory() . '/inc/classes/helpers/Template_Helper.php';
require get_template_directory() . '/inc/classes/helpers/General_Helper.php';
require get_template_directory() . '/inc/classes/helpers/Pdf_Generator.php';

//DATA
require get_template_directory() . '/inc/classes/data/Performance_Data_Collector.php';
require get_template_directory() . '/inc/classes/data/Assinante_Data_Collector.php';
require get_template_directory() . '/inc/classes/data/Lead_data.php';
require get_template_directory() . '/inc/classes/data/Subscriber_Data.php';

//MANAGE NOTIFICATIONS
require get_template_directory() . '/inc/classes/notifications/Notification_Manager.php';
