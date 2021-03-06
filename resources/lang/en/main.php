<?php

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
    'hours_in_day'                          => '{0} часов|{1} час|[2,4] часа|[5,20] часов|{21} час|[22,24] часа',
    'minutes_short'                         => 'min',
    'btn_submit_label'                      => 'Save',
    'general_success'                       => 'Success',
    'general_error'                         => 'Error',

    'service_category:list_page_header'     => 'Service categories',

    'service:list_page_header'              => 'Services',

    'service_category:create_form_header'   => 'Создать категорию услуг',
    'service_category:edit_form_header'     => 'Редактировать категорию услуг',
    'service_category:gender_all'           => 'All',
    'service_category:gender_men'           => 'Men',
    'service_category:gender_woman'         => 'Women',
    'service_category:name_label'           => 'Title',
    'service_category:online_reservation_name_label' => 'Title for online reservation',
    'service_category:gender_label'         => 'Gender',
    'service_category:create_new_btn_label' => 'New category',
    'service_category:delete_success_message' => 'Category deleted!',
    'service_category:delete_error_message' => 'Service category not found',
    'service_category:delete_failed_has_services_message' => 'Cannot delete category, because it contains :cnt service(s)',

    'service:create_form_header'            => 'Создать услугу',
    'service:edit_form_header'              => 'Редактировать услугу',
    'service:add_from_page_header'          => 'Добавить услугу',
    'service:service_category_label'        => 'Категория услуг',
    'service:name_label'                    => 'Название',
    'service:price_min_label'               => 'Минимальная цена',
    'service:price_max_label'               => 'Максимальная цена',
    'service:description_label'             => 'Описание',
    'service:duration_label'                => 'Длительность',
    'service:create_new_btn_label'          => 'Новая услуга',
    'service:delete_success_message'        => 'Услуга удалена!',
    'service:delete_error_message'          => 'Услуга не найдена.',
    'service:max_num_appointments'          => 'Maximum number of simultaneous clients',

    'organization:default_name'             => 'BarcelonaCRM',
    'organization:form_page_header'         => 'Main settings',
    'organization:edit_form_header'         => 'Edit organization settings',
    'organization:name_label'               => 'Name',
    'organization:category_label'           => 'Category',
    'organization:timezone_label'           => 'Current time',
    'organization:country_label'            => 'Country',
    'organization:city_label'               => 'City',
    'organization:currency_label'           => 'Currency',
    'organization:logo_label'               => 'Logo',
    'organization:logo_recommend'           => 'We recommend use transparent PNG image 200*50 px',
    'organization:logo_btn'                 => 'Upload photo',
    'organization:info_label'               => 'Description',
    'organization:id_label'                 => 'Organization ID',
    'organization:email_label'              => 'Email',

    'appointment:client_wait_tab_label'     => 'Ожидание клиента',
    'appointment:client_came_tab_label'     => 'Клиент пришел',
    'appointment:client_didnt_came_tab_label' => 'Клиент не пришел',
    'appointment:client_confirm_tab_label' => 'Клиент подтвердил',
    'appointment:create_form_header'        => 'Создать запись',
    'appointment:edit_form_header'          => 'Редактировать запись на услугу',
    'appointment:client_name_label'         => 'Имя Клиента',
    'appointment:client_phone_label'        => 'Телефон',
    'appointment:client_email_label'        => 'Email адрес',
    'appointment:service_id_label'          => 'Услуга',
    'appointment:employee_id_label'         => 'Сотрудник',
    'appointment:date_time_from'            => 'Дата и время',
    'appointment:duration'                  => 'Длительность',
    'appointment:note_label'                => 'Примечания',
    'appointment:client_num_visits'         => 'Количество визитов',
    'appointment:client_last_visit_date'    => 'Последний визит',
    'appointment:error_duration_not_selected' => 'Duration can\'t be 0',
    'appointments:no_permission_to_delete'  => 'You don\'t have permissions to delete this record',
    'appointments:delete_successful'        => 'Appointment have been successfully deleted from database!',
    'appointments:delete_not_found'         => 'Appointment not found in database!',

    'user:list_page_header'                 => 'Список пользователей',

    'user:edit_form_header'                 => 'Редактировать пользователя',
    'user:create_form_header'               => 'Создать пользователя',
    'user:properties_tab_label'             => 'Настройки',
    'user:permissions_tab_label'            => 'Права доступа',
    'user:name_label'                       => 'Имя пользователя',
    'user:info_label'                       => 'Информация',
    'user:email_label'                      => 'E-mail',
    'user:phone_label'                      => 'Телефон',
    'user:create_new_btn_label'             => 'Создать пользователя',
    'user:creation_success_message'         => 'Пользовтель был успешно создан!',
    'user:logo_btn'                         => 'Загрузить фото',
    'user:password_label'                   => 'Password',

    'user:title_personal_data_settings'     => 'Настройки персональных данных',
    'user:title_section_personal_data'      => 'Личные данные',
    'user:page_title_cabinet'               => 'Личный кабинет',
    'user:title_section_settings'           => 'Настройки',
    'user:title_section_mailings'           => 'Рассылки',
    'user:btn_my_records'                   => 'Мои записи',
    'user:receive_news_emails'              => 'Получать новостные и информационные письма',
    'user:receive_marketing_offer_emails'   => 'Получать маркетинговые письма с предложениями',
    'user:receive_system_inf_emails'        => 'Получать письма о работе системы',
    'user:mailings_settings_saved_message'  => 'Настройки сохранены',
    'user:mailings_settings_save_error_message' => 'Ошибка! Настройки не сохранены',
    'user:info_label_usercabinet'           => 'Информация о себе',
    'user:lang_label_usercabinet'           => 'Язык',
    'user:name_city_usercabinet'            => 'Город',
    'user:btn_update_main_info'             => 'Изменить данные',
    'user:main_info_settings_saved_message' => 'Данные сохранены',
    'user:main_info_save_error_message'     => 'Ошибка! Данные не сохранены',
    'user:change_password_heading'          => 'Изменить пароль',
    'user:old_password_label_usercabinet'   => 'Старый пароль',
    'user:new_password_label_usercabinet'   => 'Новый пароль',
    'user:new_password_confirmation_label_usercabinet' => 'Подтвердите пароль',
    'user:btn_update_password'              => 'Изменить пароль',
    'user:password_settings_saved_message'  => 'Пароль изменен',
    'user:wrong_password_error'             => 'Неправильный пароль',
    'user:same_new_password_error'          => 'Новый пароль совпадает со старым',
    'user:change_phone_heading'             => 'Change phone number',
    'user:btn_update_phone'                 => 'Update phone',
    'user:current_phone_label_usercabinet'  => 'Current number',
    'user:new_phone_label_usercabinet'      => 'New number',
    'user:help_text_phone_usercabinet'      => 'SMS with confirmation code will be sent to new number',
    'user:change_email_heading'             => 'Change email',
    'user:email_saved_message'              => 'The link has been sent to your new email address. Please click on it to confirm email address change.',
    'user:current_email_label_usercabinet'  => 'Current Email',
    'user:new_email_label_usercabinet'      => 'New Email',
    'user:help_text_email_usercabinet'      => 'Message with confirmation link will be sent to new email address',
    'user:btn_update_email'                 => 'Change email',
    'user:email_change_confirmation_email_text' => 'On the site :url request had been made to change user email to :email. To confirm change please follow link:',
    'user:email_change_confirmation_email_ignore' => 'If you didn\'t created such request please just ignore this letter.',
    'user:change_email_result_page_header'  => 'Email change',
    'user:email_change_confirmation_error'  => 'Failed to change email address. The link shouldn\'t be modified. Please try again.',
    'user:email_change_confirmation_success' => 'Email address successfully changed! Now you can go to <a href=\':home\'>home page</a> or in the <a href=\':usercabinet\'>user cabinet</a>',

    'user:permissions_appointment_form_label' => 'Окно записи',
    'user:permissions_appointment_create_label' => 'Создавать записи',
    'user:permissions_appointment_edit_label' => 'Редактировать записи',
    'user:permissions_appointment_delete_label' => 'Удалять записи',
    'user:permissions_appointment_client_data_label' => 'Доступ к данным клиентов',
    'user:permissions_settings_label'       => 'Настройки',
    'user:settings_manage_users_label'      => 'Управлять пользователями',
    'user:permissions_service_edit_label'   => 'Редактирование услуг',
    'user:permissions_service_delete_label' => 'Удаление услуг',
    'user:permissions_employee_edit_label'  => 'Редактирование персонала',
    'user:permissions_employee_delete_label' => 'Удаление персонала',
    'user:permissions_schedule_edit_label'  => 'Редактирование графика работы',
    'user:permissions_clients_label'        => 'Клиенты',
    'user:permissions_view_clients_phone_label' => 'Show phone numbers in client list',
    'user:permissions_view_client_phone_label' => 'Show phone number in clients card',
    'user:permissions_clients_export_xls_label' => 'Export client list to Excel',
    'user:permissions_statistics_label'     => 'Statistics',
    'user:permissions_is_admin'             => 'Administration rights',
    'user:permissions_storages_label'       => 'Storages',
    'user:permissions_finances_label'       => 'Finances',
    'user:permissions_wage_schemes_view_label' => 'Wage schemes - view',
    'user:permissions_wage_schemes_edit_label' => 'Wage schemes - edit',

    'client:list_header'                    => 'Clients',
    'client:list_page_header'               => 'Clients',
    'client:list_actions'                   => 'Actions',
    'client:list_filters'                   => 'Filters',
    'client:search_button_label'            => 'Search',
    'client:search_field_placeholder'       => 'Search (by name, phone or email)',
    'client:list_send_sms_to_selected'      => 'Send SMS to all selected',
    'client:list_send_sms_to_all_found'     => 'Send SMS to all found',
    'client:list_export_filtered_to_excel'  => 'Export found to Excel',
    'client:list_export_all_to_excel'       => 'Export all to Excel',
    'client:create_new_btn_label'           => 'Add new client',
    'client:list_delete_selected'           => 'Delete selected',
    'client:list_delete_all_found'          => 'Delete all found',
    'client:list_add_selected_to_category'  => 'Add selected to category',
    'client:list_add_all_found_to_category' => 'Add found to category',
    'client:gender_unknown'                 => 'Unknown',
    'client:gender_men'                     => 'Man',
    'client:gender_woman'                   => 'Woman',
    'client:edit_success_message'           => 'Changes saved',
    'client:create_success_message'         => 'Client created',
    'client:name_label'                     => 'Name',
    'client:phone_label'                    => 'Phone',
    'client:email_label'                    => 'E-mail',
    'client:client_category_label'          => 'Category',
    'client:gender_label'                   => 'Gender',
    'client:importance_label'               => 'Importance category',
    'client:discount_label'                 => 'Discount',
    'client:birthday_label'                 => 'Birth date',
    'client:comment_label'                  => 'Note',
    'client:sms_label'                      => 'SMS',
    'client:birthday_sms_label'             => 'Send birthday congratulation SMS',
    'client:do_not_send_sms_label'          => 'Exclude from SMS mailing list',
    'client:online_record_label'            => 'Online record',
    'client:online_reservation_available'   => 'Forbid to record online',
    'client:total_bought_label'             => 'Sold',
    'client:total_paid_label'               => 'Payed',
    'clients:btn_show_grid_label'           => 'View all clients',
    'clients:btn_edit_label'                => 'Edit',
    'client:create_form_header'             => 'Create client card',
    'client:edit_form_header'               => 'Edit client',
    'client:importance_no_category'         => 'No importance category',
    'client:importance_bronze'              => 'Bronze',
    'client:importance_silver'              => 'Silver',
    'client:importance_gold'                => 'Gold',
    'client:filter_panel_title'             => 'Filters',
    'client:filter_button'                  => 'Filter',
    'client:filter_no_category_label'       => 'No category',

    'client_category:form_page_header'      => 'Категории клиентов',
    'client_category:list_page_header'      => 'Категории клиентов',
    'client_category:create_new_btn_label'  => 'Добавить новую категорию',
    'client_category:edit_form_header'      => 'Редактировать категорию клиентов',
    'client_category:create_form_header'    => 'Новая категория клиентов',
    'client_category:name_placeholder'      => 'Название категории..',
    'client_category:btn_save'              => 'Сохранить',
    'client_category:color_placeholder'     => 'Цвет..',
    'client_category:delete_failed_has_clients_message' => 'Невозможно удалить категорию, т.к. она содержит :cnt услуг',
    'client_category:delete_success_message' => 'Категория удалена!',
    'client_category:delete_error_message'  => 'Категория клиентов не найдена',
    'client_category:edit_success_message'  => 'Изменения сохранены',
    'client_category:create_success_message'=> 'Категория создана',

    'widget:error_time_already_taken'       => 'Unfortunately selected time is already occupied. Please return to previous step and select other time.',
    'widget:error_wrong_title'              => 'Something wrong!',
    'widget:error_no_superorganization'     => 'No SuperOrganization ID set.',
    'widget:error_no_organization'          => 'No Organization ID set.',
    'widget:error_categories_title'         => 'Categories empty!',
    'widget:error_categories'               => 'Sorry but this organization have no service categories. Please back one step and try to choose another item.',
    'widget:error_category_id'              => 'Service Category  ID was not set',
    'widget:error_services_title'           => 'Services empty!',
    'widget:error_services'                 => 'Sorry but no services found for category chosen. Please back one step and try to choose another item.',
    'widget:error_service_id'               => 'Service ID not set',
    'widget:error_service_not_found'        => 'Service with this ID was not found. Please back one step and try to choose another item.',
    'widget:error_employee_title'           => 'No employees',
    'widget:error_employee_no'              => 'Sorry, but no employees for this service found. Please back one step and try to choose another item.',
    'widget:error_days_title'               => 'No free days',
    'widget:error_days_no'                  => 'Sorry, but this employee have no free days in this month anymore. Please back one step and try to choose another one.',
    'widget:error_times_title'              => 'No free time',
    'widget:error_times_no'                 => 'Sorry, but this employee have no free time in chosen day anymore. Please back one step and try to choose another one.',
    'widget:division_head'                  => 'Choose division',
    'widget:online_registration'            => 'Online registration',
    'widget:employee_head'                  => 'Choose employee',
    'widget:service_head'                   => 'choose service',
    'widget:time_head'                      => 'Choose time',
    'widget:form_head'                      => 'Input your data',
    'widget:category_head'                  => 'Choose service category',
    'widget:day_head'                       => 'Choose date',
    'widget:employee_doesnot_matter_text'   => 'Employee doesn\'t matter',
    'widget:name'                           => 'Your Name',
    'widget:7_phone'                        => '+7 phone',
    'widget:comment'                        => 'Comment',
    'widget:remind_me'                      => 'Remind me',
    'widget:hour'                           => 'hour',
    'widget:hours'                          => 'hours',
    'widget:day'                            => 'day',
    'widget:i_agree'                        => 'I agree to the',
    'widget:terms_conditions'               => 'Terms of use and privacy policy ',
    'widget:send'                           => 'Send',
    'widget:duration'                       => 'duration',
    'widget:info'                           => 'Information',
    'widget:contacts'                       => 'Contacts',
    'widget:phone'                          => 'Phone',
    'widget:address'                        => 'Address',
    'widget:work_hours'                     => 'Work hours',

    'employee:sync_wage_schemes_error_message'      => 'Error syncing wage calculation scheme. Please report about this error to your administrator.',
    'employee:sync_wage_schemes_success_message'    => 'Wage calculation scheme successfully saved.',
    'employee:wage_scheme_label'                    => 'Wage scheme',
    'employee:wage_scheme_start_from_label'         => 'Valid from',

    'calculated_wage:grid_pay_link'                 => 'Pay',

    'branch:list_page_header'               => 'Branches',
    'branch:list_header'                    => 'Branches',
    'branch:create_new_btn_label'           => 'Add branch',
];