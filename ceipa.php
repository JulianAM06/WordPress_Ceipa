<?php

// Agregar menú en el Dashboard
add_action('admin_menu', 'scantoolwp_add_menu');

//Crea las páginas del menú y las añade al menú de administración de WordPress
function scantoolwp_add_menu() {
    add_menu_page('ScanToolWP', 'ScanToolWP', 'manage_options', 'scantoolwp_dashboard', 'scantoolwp_dashboard_page');
    add_submenu_page('scantoolwp_dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'scantoolwp_dashboard', 'scantoolwp_dashboard_page');
    add_submenu_page('scantoolwp_dashboard', 'About', 'About', 'manage_options', 'scantoolwp_about', 'scantoolwp_about_page');
}


// Página de Dashboard
function scantoolwp_dashboard_page() {
    // Obtener datos
    $site_name = get_bloginfo('name');
    $site_url = site_url();
    $wordpress_url = admin_url();
    $wordpress_version = get_bloginfo('version');
    $themes = wp_get_themes();
    $active_theme = wp_get_theme()->get('Name');
    $plugins = get_plugins();
    $published_pages = wp_count_posts('page')->publish;
    $published_posts = wp_count_posts()->publish;

    // Mostrar información
    echo "<h2>Dashboard</h2>";
    echo "<p><strong>Nombre del sitio:</strong> $site_name</p>";
    echo "<p><strong>URL de instalación:</strong> $site_url</p>";
    echo "<p><strong>URL de WordPress:</strong> $wordpress_url</p>";
    echo "<p><strong>Versión de WordPress:</strong> $wordpress_version</p>";
    echo "<p><strong>Temas instalados:</strong></p>";
    echo "<ul>";
    foreach ($themes as $theme) {
        echo "<li>" . ($theme->get('Name') == $active_theme ? "<strong>{$theme->get('Name')}</strong>" : $theme->get('Name')) . "</li>";
    }
    echo "</ul>";
    echo "<p><strong>Plugins instalados:</strong></p>";
    echo "<ul>";
    foreach ($plugins as $plugin_path => $plugin) {
        echo "<li style='color: " . (is_plugin_active($plugin_path) ? 'green' : 'red') . ";'>$plugin[name]</li>";
    }
    echo "</ul>";
    echo "<p><strong>Número de páginas publicadas:</strong> $published_pages</p>";
    echo "<p><strong>Número de blogs publicados:</strong> $published_posts</p>";
}

// Página About
function scantoolwp_about_page() {
    echo "<h2>About</h2>";
    echo "<p><strong>Nombre del autor del plugin:</strong> Tu Nombre</p>";
    echo "<p><a href='https://www.facebook.com/nativapps' class='button-primary'>Facebook</a></p>";
    echo "<p><a href='https://www.instagram.com/nativapps/' class='button-primary'>Instagram</a></p>";
    echo "<p><a href='https://www.linkedin.com/company/nativapps-inc/' class='button-primary'>LinkedIn</a></p>";
}

// Registrar Custom Post Type para libros
add_action('init', 'scantoolwp_register_book_post_type');

function scantoolwp_register_book_post_type() {
    $labels = array(
        'name' => 'Libros',
        'singular_name' => 'Libro',
        'menu_name' => 'Libros',
        'add_new' => 'Agregar Nuevo',
        'add_new_item' => 'Agregar Nuevo Libro',
        'edit_item' => 'Editar Libro',
        'new_item' => 'Nuevo Libro',
        'view_item' => 'Ver Libro',
        'search_items' => 'Buscar Libros',
        'not_found' => 'No se encontraron libros',
        'not_found_in_trash' => 'No se encontraron libros en la papelera',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'libros'),
        'supports' => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('book', $args);
}
