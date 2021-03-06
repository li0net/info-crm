<div class="side-nav">
    <div class="login">
        <div class="login-open">
            <img src="/img/landing/icon_user2.svg">
            <a href="/login">Ingresar</a> |
            <a href="/register" >Registrarse</a> |
            <div class="dropdown">
                <button  class="btn btn-default btn-xs dropdown-toggle dropbtn btn-flag es">
                    <span class="caret"></span>
                </button>
                <div class="dropdown-content">
                    <a class="lang-flag en" href="/locale/en">English</a>
                    <a class="lang-flag ru" href="/locale/ru">Русский</a>
                </div>
            </div>
        </div>
        <div class="login-close"><a href="#" ><img src="/img/landing/icon_login.svg"></a></div>
    </div>
    <a href="#" class="nav-opener">
        <span></span>
    </a>
    <ul id="nav">
        <li><a href="/" class="@if ($page == 'index') active @endif">
                <span class="visual"><img src="/img/landing/ico01.svg" width="25"></span>
                <span class="text">Infogroup.service</span>
            </a></li>
        <li><a href="/?p=online-booking" class="@if ($page == 'online-booking') active @endif">
                <span class="visual"><img src="/img/landing/ico02.svg" width="24" title="Online booking"></span>
                <span class="text">Inscripción en línea</span>
            </a></li>
        <li><a href="/?p=electronic-schedule" class="@if ($page == 'electronic-schedule') active @endif">
                <span class="visual"><img src="/img/landing/ico03.svg" width="21" title="Electronic schedule"></span>
                <span class="text">Registro electrónico</span>
            </a></li>
        <li><a href="/?p=client-base" class="@if ($page == 'client-base') active @endif">
                <span class="visual"><img src="/img/landing/ico04.svg" width="24" title="Client base"></span>
                <span class="text">Cartera de clientes</span>
            </a></li>
        <li><a href="/?p=statistics-and-analytics" class="@if ($page == 'statistics-and-analytics') active @endif">
                <span class="visual"><img src="/img/landing/ico05.svg" width="24" title="Statistics and analytics"></span>
                <span class="text">Estadística y Analisis</span>
            </a></li>
        <li><a href="/?p=sms-and-email-notification" class="@if ($page == 'sms-and-email-notification') active @endif">
                <span class="visual"><img src="/img/landing/ico06.svg" width="23" title="SMS and Email notifications"></span>
                <span class="text">Avisos SMS y email</span>
            </a></li>
        <li><a href="/?p=salaries" class="@if ($page == 'salaries') active @endif">
                <span class="visual"><img src="/img/landing/ico07.svg" width="22" title="Accounting of salaries"></span>
                <span class="text">Salarios</span>
            </a></li>
        <li><a href="/?p=finances" class="@if ($page == 'finances') active @endif">
                <span class="visual"><img src="/img/landing/ico08.svg" width="24" title="Financial accounting"></span>
                <span class="text">Finanzas</span>
            </a></li>
        <li><a href="/?p=sklad" class="@if ($page == 'sklad') active @endif">
                <span class="visual"><img src="/img/landing/ico09.svg" width="24" title="Inventory control"></span>
                <span class="text">Almacén</span>
            </a></li>
        <li><a href="/?p=electronic-cards" class="@if ($page == 'electronic-cards') active @endif">
                <span class="visual"><img src="/img/landing/ico10.svg" width="22" title="Electronic cards"></span>
                <span class="text">Tarjetas electrónicas</span>
            </a></li>
        <li><a href="/?p=loyalty-program" class="@if ($page == 'loyalty-program') active @endif">
                <span class="visual"><img src="/img/landing/ico11.svg" width="27" title="Loyalty program"></span>
                <span class="text">Programa de fidelización</span>
            </a></li>
        <li><a href="/?p=mobile-application" class="@if ($page == 'mobile-application') active @endif">
                <span class="visual"><img src="/img/landing/ico12.svg" width="25" title="Mobile applications"></span>
                <span class="text">Aplicación móvil</span>
            </a></li>
    </ul>
</div>