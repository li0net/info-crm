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
    'minutes_short'                         => 'мин',
    'btn_submit_label'                      => 'Сохранить',
    'general_success'                       => 'Успешно',
    'general_error'                         => 'Ошибка',

    'service_category:list_page_header'     => 'Категории услуг',

    'service:list_page_header'              => 'Услуги',

    'service_category:create_form_header'   => 'Создать категорию услуг',
    'service_category:edit_form_header'     => 'Редактировать категорию услуг',
    'service_category:gender_all'           => 'Все',
    'service_category:gender_men'           => 'Мужчины',
    'service_category:gender_woman'         => 'Женщины',
    'service_category:name_label'           => 'Название',
    'service_category:online_reservation_name_label' => 'Название для онлайн регистрации',
    'service_category:gender_label'         => 'Пол',
    'service_category:create_new_btn_label' => 'Новая категория',
    'service_category:delete_success_message' => 'Категория удалена!',
    'service_category:delete_error_message' => 'Категория услуг не найдена',
    'service_category:delete_failed_has_services_message' => 'Невозможно удалить категорию, т.к. она содержит :cnt услуг',

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

    'organization:default_name'             => 'BarcelonaCRM',
    'organization:form_page_header'         => 'Основные настройки',
    'organization:edit_form_header'         => 'Редактировать настройки',
    'organization:name_label'               => 'Название',
    'organization:category_label'           => 'Категория',
    'organization:timezone_label'           => 'Текущее время',
    'organization:country_label'            => 'Страна',
    'organization:city_label'               => 'Город',
    'organization:logo_label'               => 'Логотип',
    'organization:logo_btn'                 => 'Загрузить фото',
    'organization:info_label'               => 'Описание',

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
    'appointment:error_duration_not_selected' => 'Длительность не может быть равна 0',
    'appointments:no_permission_to_delete'  => 'У вас нет прав на удаление этой записи',
    'appointments:delete_successful'   => 'Запись успешно удалена из справочника!',
    'appointments:delete_not_found'    => 'Запись не найдена в справочнике!',

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
    'user:grid_phone_hidden_message'        => 'скрыт',
    'user:password_label'                   => 'Пароль',

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
    'user:phone_saved_message'              => 'Номер телефона изменен',
    'user:change_phone_heading'             => 'Изменить номер телефона',
    'user:btn_update_phone'                 => 'Изменитиь номер',
    'user:current_phone_label_usercabinet'  => 'Текущий номер',
    'user:new_phone_label_usercabinet'      => 'Новый номер',
    'user:help_text_phone_usercabinet'      => 'На новый номер будет выслано sms сообщение с кодом подтверждения',
    'user:change_email_heading'             => 'Изменить Email',
    'user:email_saved_message'              => 'Ссылка была отправлена на ваш новый Email адрес, пожалуйста перейдите по ней, что подтвердить смену Email',
    'user:current_email_label_usercabinet'  => 'Текущий Email',
    'user:new_email_label_usercabinet'      => 'Новый Email',
    'user:help_text_email_usercabinet'      => 'На новый Email будет выслано письмо со ссылкой для подтверждения',
    'user:btn_update_email'                 => 'Изменить Email',
    'user:email_change_confirmation_email_text' => 'На сайте :url был сделан запрос на смену email пользователя на :email. Чтобы подтвердить изменение, пожалуйста, перейдите по ссылке:',
    'user:email_change_confirmation_email_ignore' => 'Если вы не создавали этот запрос просто проигнорируйте данное письмо.',
    'user:change_email_result_page_header'  => 'Смена Email',
    'user:email_change_confirmation_error'  => 'Не удалось сменить Email. Ссылка не должна модифицироваться. Попробуйте еще раз.',
    'user:email_change_confirmation_success' => 'Email успешно изменен! Теперь вы можете перейти на <a href=\':home\'>главную страницу</a> или в <a href=\':usercabinet\'>личный кабинет</a>',

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
    'user:permissions_clients_label'        => 'Клиентская база',
    'user:permissions_view_clients_phone_label' => 'Показывать номера телефонов в списке клиентов',
    'user:permissions_view_client_phone_label' => 'Показывать номер телефона в карточке клиента',
    'user:permissions_clients_export_xls_label' => 'Выгружать список клиентов в Excel',
    'user:permissions_statistics_label'     => 'Статистика',
    'user:permissions_is_admin'             => 'Права администратора',
    'user:permissions_storages_label'       => 'Склады',
    'user:permissions_finances_label'       => 'Финансы',
    'user:permissions_wage_schemes_view_label' => 'Схемы рассчета зарплаты - просмотр',
    'user:permissions_wage_schemes_edit_label' => 'Схемы рассчета зарплаты - редактирование',

    'client:list_header'                    => 'Клиенты',
    'client:list_page_header'               => 'Клиенты',
    'client:list_actions'                   => 'Действия',
    'client:list_filters'                   => 'Фильтры',
    'client:search_button_label'            => 'Искать',
    'client:search_field_placeholder'       => 'Поиск (по имени, телефону или Email)',
    'client:list_send_sms_to_selected'      => 'Отправить SMS выбранным',
    'client:list_send_sms_to_all_found'     => 'Отправить SMS всем найденным',
    'client:list_export_filtered_to_excel'  => 'Выгрузить найденных в Excel',
    'client:list_export_all_to_excel'       => 'Выгрузить всю базу в Excel',
    'client:create_new_btn_label'           => 'Добавить нового клиента',
    'client:list_delete_selected'           => 'Удалить выбранных',
    'client:list_delete_all_found'          => 'Удалить всех найденных',
    'client:list_add_selected_to_category'  => 'Добавить выбранных в категорию',
    'client:list_add_all_found_to_category' => 'Добавить найденных в категорию',
    'client:gender_unknown'                 => 'Неизвестен',
    'client:gender_men'                     => 'Мужчина',
    'client:gender_woman'                   => 'Женщина',
    'client:edit_success_message'           => 'Изменения сохранены',
    'client:create_success_message'         => 'Клиент создан',
    'client:name_label'                     => 'Имя',
    'client:phone_label'                    => 'Сотовый',
    'client:email_label'                    => 'E-mail',
    'client:client_category_label'          => 'Категория',
    'client:gender_label'                   => 'Пол',
    'client:importance_label'               => 'Класс важности',
    'client:discount_label'                 => 'Скидка',
    'client:birthday_label'                 => 'Дата рождения',
    'client:comment_label'                  => 'Комментарий',
    'client:sms_label'                      => 'SMS',
    'client:birthday_sms_label'             => 'Поздравлять с днем рождения по SMS',
    'client:do_not_send_sms_label'          => 'Исключить из SMS рассылок',
    'client:online_record_label'            => 'Онлайн запись',
    'client:online_reservation_available'   => 'Запретить записываться онлайн',
    'client:total_bought_label'             => 'Продано',
    'client:total_paid_label'               => 'Оплачено',
    'clients:btn_show_grid_label'           => 'Посмотреть всех клиентов',
    'clients:btn_edit_label'                => 'Редактировать',
    'client:create_form_header'             => 'Создать карточку клиента',
    'client:edit_form_header'               => 'Редактировать клиента',
    'client:importance_no_category'         => 'Без класса важности',
    'client:importance_bronze'              => 'Бронза',
    'client:importance_silver'              => 'Серебро',
    'client:importance_gold'                => 'Золото',
    'client:form_page_header'               => 'Редактировать клиента',

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

    'passport:manage_clients_title'         => 'Управление API пользователями',
    'passport:manage_authorized_clients_title' => 'Управление авторизованными API пользователями',
    'passport:manage_personal_access_tokens_title' => 'Управление персональными токенами',

    'widget:error_time_already_taken'      => 'К сожалению, выбранное время уже занято. Пожалуйста, вернитесь на предыдущий шаг и выберите другое время.',
    'widget:error_wrong_title'          => 'Что-то не так!',
    'widget:error_no_superorganization' => 'Не задан ID суперорганизации.',
    'widget:error_no_organization'      => 'Не задан ID организации.',
    'widget:error_categories_title'     => 'Категории не найдены!',
    'widget:error_categories'           => 'К сожалению, для данной организации не заданы категории. Попробуйте вернуться на шаг назад и выбрать другой вариант.',
    'widget:error_category_id'          => 'Не задан ID категории услуг',
    'widget:error_services_title'       => 'Услуги не найдены!',
    'widget:error_services'             => 'К сожалению для данной категории не заданы услуги. Попробуйте вернуться на шаг назад и выбрать другой вариант.',
    'widget:error_service_id'           => 'Не задан ID услуги',
    'widget:error_service_not_found'    => 'Услуга с текущим ID не найдена. Попробуйте вернуться на шаг назад и выбрать другой вариант.',
    'widget:error_employee_title'       => 'Исполнители не найдены!',
    'widget:error_employee_no'          => 'К сожалению, не найдено ни одного исполнителя для данной услуги. Попробуйте вернуться на шаг назад и выбрать другой вариант.',
    'widget:error_days_title'           => 'Нет свободных дней!',
    'widget:error_days_no'              => 'К сожалению, у текущего исполнителя не осталось свободных дней. Попробуйте вернуться на шаг назад и выбрать другой вариант.',
    'widget:error_times_title'          => 'Нет свободного времени!',
    'widget:error_times_no'             => 'К сожалению, у текущего исполнителя не осталось временных интервалов. Попробуйте вернуться на шаг назад и выбрать другой вариант.',

    'widget:division_head'             => 'Выбор филиала',
    'widget:online_registration'       => 'Онлайн-запись',
    'widget:employee_head'             => 'Выбор исполнителя',
    'widget:service_head'              => 'Выбор услуги',
    'widget:time_head'                 => 'Выбор времени',
    'widget:form_head'                 => 'Оформление',
    'widget:category_head'             => 'Выбор категории услуги',
    'widget:day_head'                  => 'Выбор даты',
];
