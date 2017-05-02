﻿<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'hours_in_day'                          => '{0} horas|{1} hora|[2,4] horas|[5,20] horas|{21} hora|[22,24] hora',
    'minutes_short'                         => 'min',
    'btn_submit_label'                      => 'Guardar',
    'general_success'                       => 'Con éxito',
    'general_error'                         => 'Error',

    'service_category:list_page_header'     => 'Categorías de servicios',

    'service:list_page_header'              => 'Servicios',

    'service_category:create_form_header'   => 'Crear categoría de servicios',
    'service_category:edit_form_header'     => 'Editar categoría de servicios',
    'service_category:gender_all'           => 'Todos',
    'service_category:gender_men'           => 'Varones',
    'service_category:gender_woman'         => 'Mujeres',
    'service_category:name_label'           => 'Denominación',
    'service_category:online_reservation_name_label' => 'Denominación para registración en línea',
    'service_category:gender_label'         => 'Género',
    'service_category:create_new_btn_label' => 'Nueva categoría',
    'service_category:delete_success_message' => '¡Categoría ha sido eliminada!',
    'service_category:delete_error_message' => 'Categoría de servicios no se ha encontrado',
    'service_category:delete_failed_has_services_message' => 'No es posible eliminar la categoría, porque incluye :cnt servicios',

    'service:create_form_header'            => 'Crear servicio',
    'service:edit_form_header'              => 'Editar servicio',
    'service:add_from_page_header'          => 'Agregar servicio',
    'service:service_category_label'        => 'Categoría de servicios',
    'service:name_label'                    => 'Denominación',
    'service:price_min_label'               => 'Precio mínimo',
    'service:price_max_label'               => 'Precio máximo',
    'service:description_label'             => 'Descripción',
    'service:duration_label'                => 'Duración',
    'service:create_new_btn_label'          => 'Nuevo servicio',
    'service:delete_success_message'        => '¡Servicio ha sido eliminado!',
    'service:delete_error_message'          => 'Servicio no se ha encontrado.',

    'organization:default_name'             => 'BarcelonaCRM',
    'organization:form_page_header'         => 'Ajustes principales',
    'organization:edit_form_header'         => 'Editar ajustes',
    'organization:name_label'               => 'Denominación',
    'organization:category_label'           => 'Categoría',
    'organization:timezone_label'           => 'Hora actual',
    'organization:country_label'            => 'País',
    'organization:city_label'               => 'Ciudad',
    'organization:currency_label'           => 'Moneda',
    'organization:logo_label'               => 'Logo',
    'organization:logo_btn'                 => 'Subir una foto',
    'organization:logo_recommend'           => 'Recomendamos usar la imagen PNG transparente 200 * 50 px',
    'organization:info_label'               => 'Descripción',
    'organization:id_label'                 => 'ID organización',

    'appointment:client_wait_tab_label'     => 'Espera de cliente',
    'appointment:client_came_tab_label'     => 'Cliente ha venido',
    'appointment:client_didnt_came_tab_label' => 'Cliente no ha venido',
    'appointment:client_confirm_tab_label' => 'Cliente ha afirmado',
    'appointment:create_form_header'        => 'Crear inscripción',
    'appointment:edit_form_header'          => 'Editar inscripción a un servicio',
    'appointment:client_name_label'         => 'Nombre del Cliente',
    'appointment:client_phone_label'        => 'Teléfono',
    'appointment:client_email_label'        => 'Email',
    'appointment:service_id_label'          => 'Servicio',
    'appointment:employee_id_label'         => 'Empleado',
    'appointment:date_time_from'            => 'Fecha y hora',
    'appointment:duration'                  => 'Duración',
    'appointment:note_label'                => 'Nota',
    'appointment:client_num_visits'         => 'Cantidad de visitas',
    'appointment:client_last_visit_date'    => 'Última visita',
    'appointment:error_duration_not_selected' => 'Duración no puede ser 0',

    'user:list_page_header'                 => 'Lista de usuarios',

    'user:edit_form_header'                 => 'Editar usuario',
    'user:create_form_header'               => 'Crear usuario',
    'user:properties_tab_label'             => 'Ajustes',
    'user:permissions_tab_label'            => 'Derecho de acceso',
    'user:name_label'                       => 'Nombre de usuario',
    'user:info_label'                       => 'Información',
    'user:email_label'                      => 'Email',
    'user:phone_label'                      => 'Teléfono',
    'user:create_new_btn_label'             => 'Crear usuario',
    'user:creation_success_message'         => '¡Usuario ha sido creado con éxito!',
    'user:logo_btn'                         => 'Subir una foto',
    'user:grid_phone_hidden_message'        => 'está oculto',

    'user:title_personal_data_settings'     => 'Ajustes de datos personales',
    'user:title_section_personal_data'      => 'Datos personales',
    'user:page_title_cabinet'               => 'Área de usuario',
    'user:title_section_settings'           => 'Ajustes',
    'user:title_section_mailings'           => 'Envíos',
    'user:btn_my_records'                   => 'Mis inscripciones',
    'user:receive_news_emails'              => 'Recibir mensajes de noticias e informativos',
    'user:receive_marketing_offer_emails'   => 'Recibir mensajes comerciales con ofertas',
    'user:receive_system_inf_emails'        => 'Recibir mensajes sobre el funcionamiento del sistema',
    'user:mailings_settings_saved_message'  => 'Ajustes han sido guardados',
    'user:mailings_settings_save_error_message' => '¡Error! Ajustes no han sido guardados',
    'user:info_label_usercabinet'           => 'Información de usuario',
    'user:lang_label_usercabinet'           => 'Idioma',
    'user:name_city_usercabinet'            => 'Ciudad',
    'user:btn_update_main_info'             => 'Cambiar datos',
    'user:main_info_settings_saved_message' => 'Datos han sido guardados',
    'user:main_info_save_error_message'     => '¡Error! Datos no han sido guardados',
    'user:change_password_heading'          => 'Cambiar contraseña',
    'user:old_password_label_usercabinet'   => 'Contraseña antigua',
    'user:new_password_label_usercabinet'   => 'Nueva contraseña',
    'user:new_password_confirmation_label_usercabinet' => 'Confirme su contraseña',
    'user:btn_update_password'              => 'Cambiar contraseña',
    'user:password_settings_saved_message'  => 'Conraseña ha sido cambiada',
    'user:wrong_password_error'             => 'Conraseña incorrecta',
    'user:same_new_password_error'          => 'Nueva contraseña coincide con la antigua',
    'user:phone_saved_message'              => 'Número de teléfono ha sido cambiado',
    'user:change_phone_heading'             => 'Cambiar número de teléfono',
    'user:btn_update_phone'                 => 'Cambiar número',
    'user:current_phone_label_usercabinet'  => 'Número actual',
    'user:new_phone_label_usercabinet'      => 'Nuevo número',
    'user:help_text_phone_usercabinet'      => 'Al nuevo número será enviado un aviso SMS con el código de confirmación',
    'user:change_email_heading'             => 'Cambiar Email',
    'user:email_saved_message'              => 'El enlace ha sido enviado a su nuevo Email, por favor, haga clic en él para confirmar el cambio de Email',
    'user:current_email_label_usercabinet'  => 'Email actual',
    'user:new_email_label_usercabinet'      => 'Nuevo Email',
    'user:help_text_email_usercabinet'      => 'Al nuevo Email será enviado un aviso con el enlace de confirmación',
    'user:btn_update_email'                 => 'Cambiar Email',
    'user:email_change_confirmation_email_text' => 'En el sitio :url se hizo la petición para el cambio de email del usuario en :email. Para confirmar el cambio, por favor, haga clic en el enlace:',
    'user:email_change_confirmation_email_ignore' => 'Si no fue Ud. quien creó esta petición simplemente ignore este mensaje.',
    'user:change_email_result_page_header'  => 'Cambio de Email',
    'user:email_change_confirmation_error'  => 'No se ha podido cambiar Email. El enlace no debe ser modificado. Inténtelo de nuevo.',
    'user:email_change_confirmation_success' => '¡Email ha sido cambiado con éxito! Ahora puede Ud. ir a <a href=\':home\'>página principal</a> o a <a href=\':usercabinet\'>área de usuarios</a>',

    'user:permissions_appointment_form_label' => 'Ventana de inscripción',
    'user:permissions_appointment_create_label' => 'Crear inscripciones',
    'user:permissions_appointment_edit_label' => 'Editar inscripciones',
    'user:permissions_appointment_delete_label' => 'Eliminar inscripciones',
    'user:permissions_appointment_client_data_label' => 'Acceso a datos de clientes',
    'user:permissions_settings_label'       => 'Ajustes',
    'user:settings_manage_users_label'      => 'Gestionar a usuarios',
    'user:permissions_service_edit_label'   => 'Edición de servicios',
    'user:permissions_service_delete_label' => 'Eliminación de servicios',
    'user:permissions_employee_edit_label'  => 'Edición de personal',
    'user:permissions_employee_delete_label' => 'Eliminación de personal',
    'user:permissions_schedule_edit_label'  => 'Edición del horario laboral',
    'user:permissions_clients_label'        => 'Cartera de clientes',
    'user:permissions_view_clients_phone_label' => 'Mostrar números de teléfonos en la lista de clientes',
    'user:permissions_view_client_phone_label' => 'Mostrar número de teléfono en la ficha del cliente',
    'user:permissions_clients_export_xls_label' => 'Cargar la lista de clientes a Excel',
    'user:permissions_statistics_label'     => 'Estadísticas',

    'client:list_header'                    => 'Clientes',
    'client:list_page_header'               => 'Clientes',
    'client:list_actions'                   => 'Acciones',
    'client:list_filters'                   => 'Filtros',
    'client:search_button_label'            => 'Buscar',
    'client:search_field_placeholder'       => 'Búsqueda (por nombre, teléfono o Email)',
    'client:list_send_sms_to_selected'      => 'Enviar SMS a los seleccionados',
    'client:list_send_sms_to_all_found'     => 'Enviar SMS a todos los encontrados',
    'client:list_export_filtered_to_excel'  => 'Cargar a los encontrados a Excel',
    'client:list_export_all_to_excel'       => 'Cargar toda la base a Excel',
    'client:create_new_btn_label'           => 'Agregar nuevo cliente',
    'client:list_delete_selected'           => 'Eliminar a los seleccionados',
    'client:list_delete_all_found'          => 'Eliminar a todos los encontrados',
    'client:list_add_selected_to_category'  => 'Agregar a los seleccionados a la categoría',
    'client:list_add_all_found_to_category' => 'Agregar a los encontrados a la categoría',
    'client:gender_unknown'                 => 'Desconocido',
    'client:gender_men'                     => 'Varón',
    'client:gender_woman'                   => 'Mujer',
    'client:edit_success_message'           => 'Cambios han sido guardados',
    'client:create_success_message'         => 'Cliente ha sido creado',
    'client:name_label'                     => 'Nombre',
    'client:phone_label'                    => 'Móvil',
    'client:email_label'                    => 'E-mail',
    'client:client_category_label'          => 'Categoría',
    'client:gender_label'                   => 'Género',
    'client:importance_label'               => 'Grado de importancia',
    'client:discount_label'                 => 'Descuento',
    'client:birthday_label'                 => 'Fecha de nacimiento',
    'client:comment_label'                  => 'Comentario',
    'client:sms_label'                      => 'SMS',
    'client:birthday_sms_label'             => 'Enviar felicitaciones de cumpleaños via SMS',
    'client:do_not_send_sms_label'          => 'Excluir de envíos SMS',
    'client:online_record_label'            => 'Inscripción en línea',
    'client:online_reservation_available'   => 'Prohibir inscribirse en línea',
    'client:total_bought_label'             => 'Vendido',
    'client:total_paid_label'               => 'Pagado',
    'clients:btn_show_grid_label'           => 'Mostrar a todos los clientes',
    'clients:btn_edit_label'                => 'Editar',
    'client:create_form_header'             => 'Crear la ficha del cliente',
    'client:edit_form_header'               => 'Editar cliente',
    'client:importance_no_category'         => 'Sin grado de importancia',
    'client:importance_bronze'              => 'Bronce',
    'client:importance_silver'              => 'Plata',
    'client:importance_gold'                => 'Oro',
    'client:form_page_header'               => 'Editar cliente',

    'client_category:form_page_header'      => 'Categorías de clientes',
    'client_category:list_page_header'      => 'Categorías de clientes',
    'client_category:create_new_btn_label'  => 'Agregar nueva categoría',
    'client_category:edit_form_header'      => 'Editar categoría de clientes',
    'client_category:create_form_header'    => 'Nueva categoría de clientes',
    'client_category:name_placeholder'      => 'Denominación de categoría..',
    'client_category:btn_save'              => 'Guardar',
    'client_category:color_placeholder'     => 'Color..',
    'client_category:delete_failed_has_clients_message' => 'No es posible eliminar la categoría, porque incluye :cnt servicios',
    'client_category:delete_success_message' => '¡Categoría ha sido eliminada!',
    'client_category:delete_error_message'  => 'Categoría no ha sido encontrada',
    'client_category:edit_success_message'  => 'Cambios han sido guardados',
    'client_category:create_success_message'=> 'Categoría ha sido creada',

    'passport:manage_clients_title'         => 'Gestión de usuarios API',
    'passport:manage_authorized_clients_title' => 'Gestión de usuarios API autorizados',
    'passport:manage_personal_access_tokens_title' => 'Gestión de tokens personalizados',

    'widget:error_time_already_taken'       => 'Por desgracia, la hora seleccionada ya está ocupada. Por favor, vuelva al paso anterior y elija otra hora.',
    'widget:error_wrong_title'          => '¡Algo va mal!',
    'widget:error_no_superorganization' => 'No se ha definido ID de organización superior.',
    'widget:error_no_organization'      => 'No se ha definido ID de organización.',
    'widget:error_categories_title'     => '¡Categorías no han sido encontradas!',
    'widget:error_categories'           => 'Por desgracia, categorías para esta organización no se han definido. Intente a volver al paso anterior y elegir otra opción.',
    'widget:error_category_id'          => 'No se ha definido ID de categoría de servicios',
    'widget:error_services_title'       => '¡Servicios no han sido encontrados!',
    'widget:error_services'             => 'Por desgracia, servicios para esta categoría no se han definido. Intente a volver al paso anterior y elegir otra opción.',
    'widget:error_service_id'           => 'No se ha definido ID de servicio',
    'widget:error_service_not_found'    => 'Servicio con este ID no ha sido encontrado. Intente a volver al paso anterior y elegir otra opción.',
    'widget:error_employee_title'       => '¡Especialistas no han sido encontrados!',
    'widget:error_employee_no'          => 'Por desgracia, no han sido encontrado ningún especialista de este servicio. Intente a volver al paso anterior y elegir otra opción.',
    'widget:error_days_title'           => '¡No hay fechas libres!',
    'widget:error_days_no'              => 'Por desgracia, este especialista ya no tiene fechas libres. Intente a volver al paso anterior y elegir otra opción.',
    'widget:error_times_title'          => '¡No hay horas libres!',
    'widget:error_times_no'             => 'Por desgracia, este especialista ya no tiene horas libres. Intente a volver al paso anterior y elegir otra opción.',

    'widget:division_head'             => 'Choose division',
    'widget:online_registration'       => 'Online registration',
    'widget:employee_head'             => 'Choose employee',
    'widget:service_head'              => 'choose service',
    'widget:time_head'                 => 'Choose time',
    'widget:form_head'                 => 'Input your data',
    'widget:category_head'             => 'Choose service category',
    'widget:day_head'                  => 'Choose date',
];
