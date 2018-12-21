<?php
/**
 * config.php
 *
 * Author: pixelcave
 *
 * Configuration file. It contains variables used in the template as well as the primary navigation array from which the navigation is created
 *
 */

/* Template variables */
date_default_timezone_set('America/El_Salvador');
require_once('mensajes.php');
$template = array(
    'name'              => 'Punto de Venta',
    'version'           => '1.1',
    'author'            => 'Estudio A',
    'robots'            => 'noindex, nofollow',
    'title'             => 'Punto de Venta',
    'email'             => 'info@grupolah.com',
    'description'       => '',
    // true                     enable page preloader
    // false                    disable page preloader
    'page_preloader'    => false,
    // true                     enable main menu auto scrolling when opening a submenu
    // false                    disable main menu auto scrolling when opening a submenu
    'menu_scroll'       => true,
    // 'navbar-default'         for a light header
    // 'navbar-inverse'         for a dark header
    'header_navbar'     => 'navbar-inverse',
    // ''                       empty for a static layout
    // 'navbar-fixed-top'       for a top fixed header / fixed sidebars
    // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars
    'header'            => '',
    // ''                                               for a full main and alternative sidebar hidden by default (> 991px)
    // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)
    // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-mini sidebar-visible-lg-mini'           for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)
    // 'sidebar-mini sidebar-visible-lg'                for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)
    // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)
    // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)
    // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!
    'sidebar'           => 'sidebar-partial sidebar-visible-lg sidebar-no-animations',
    // ''                       empty for a static footer
    // 'footer-fixed'           for a fixed footer
    'footer'            => '',
    // ''                       empty for default style
    // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)
    'main_style'        => '',
    // ''                           Disable cookies (best for setting an active color theme from the next variable)
    // 'enable-cookies'             Enables cookies for remembering active color theme when changed from the sidebar links (the next color theme variable will be ignored)
    'cookies'           => '',
    // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire', 'coral', 'lake',
    // 'forest', 'waterlily', 'emerald', 'blackberry' or '' leave empty for the Default Blue theme
    'theme'             => '',
    // ''                       for default content in header
    // 'horizontal-menu'        for a horizontal menu in header
    // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.php
    'header_content'    => '',
    'active_page'       => basename($_SERVER['PHP_SELF'])
);

/* Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 levels deep) */
$primary_nav = array(
    array(
        'name'  => 'Home',
        'url'   => '../../php/home/index.php',
        'url_real'=> 'index.php',
        'icon'  => 'inicio.svg'
    ),
    /*array(
        'name'  => 'Administración',
        'icon'  => 'gi gi-table',
        'sub'   => array(
            array(
                'name'  => 'Empleados',
                'url'   => '../../php/administrar/empleados.php',
                'url_real'=> 'empleados.php'
            ),
            array(
                'name'  => 'Usuarios',
                'url'   => '../../php/administrar/usuarios.php',
                'url_real'=> 'usuarios.php'
            ),
            array(
                'name'  => 'Cargos de empleados',
                'url'   => '../../php/administrar/cargos.php',
                'url_real'=> 'cargos.php'
            )

        )
    ),*/
     array(
        'name'  => 'Inventario',
        'icon'  => 'inventario.svg',
        'url'   => '../../php/productos/productos.php',
        'url_real' => 'productos.php'
    ),
         array(
        'name'  => 'Servicios',
        'icon'  => 'servicios.svg',
        'url'   => '../../php/servicios/servicios.php',
        'url_real'=> 'servicios.php',
    ),
       array(
        'name'  => 'Clientes',
        'icon'  => 'clientes.svg',
        'url'   => '../../php/clientes/clientes.php',
        'url_real'=> 'clientes.php',
    ),
    array(
        'name'  => 'Proveedores',
        'icon'  => 'proveedores.svg',
        'url'   => '../../php/proveedores/proveedores.php',
        'url_real'=> 'proveedores.php',
    ),
      array(
        'name'  => 'Ventas',
        'icon'  => 'ventas.svg',
        'url'   => '../../php/ventas/ventas.php',
        'url_real'=> 'ventas.php',
    ),
     
   

    /*array(
        'name'  => 'mesas',
        'icon'  => 'gi gi-user',
        'sub'   => array(
            array(
                'name'  => 'Administración de mesas',
                'url'   => '../../php/mesas/mesas.php',
                'url_real'=> 'mesas.php',
            ),
            array(
                'name'  => 'Registro de mesas',
                'url'   => '../../php/mesas/registro_mesa.php',
                'url_real'=> 'registro_mesa.php'
            )
        )
    ),
    array(
        'name'  => 'ordenes',
        'icon'  => 'gi gi-user',
        'sub'   => array(
            array(
                'name'  => 'Administración de ordenes',
                'url'   => '../../php/ordenes/ordenes.php',
                'url_real'=> 'ordenes.php',
            ),
            array(
                'name'  => 'Registro de ordenes',
                'url'   => '../../php/ordenes/registro_orden.php',
                'url_real'=> 'registro_orden.php'
            )
        )
    ),*/
    array(
        'name'  => 'Salir',
        'url'   => '../../php/home/destruir.php',
        'url_real'=> 'destruir.php',
        'icon'  => 'hi hi-log_out'
    )
    // array(
    //     'name'  => 'Widget Kit',
    //     'opt'   => '<a href="javascript:void(0)" data-toggle="tooltip" title="Quick Settings"><i class="gi gi-settings"></i></a>' .
    //                '<a href="javascript:void(0)" data-toggle="tooltip" title="Create the most amazing pages with the widget kit!"><i class="gi gi-lightbulb"></i></a>',
    //     'url'   => 'header',
    // ),
    
);