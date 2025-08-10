<?php
// Arquivo functions.php

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('winners-variables-style', get_template_directory_uri() . '/assets/css/variables.css', [], '1.0');
  wp_enqueue_style('winners-main-style', get_template_directory_uri() . '/assets/css/style.css', [], '1.0');
  wp_enqueue_style('winners-navbar-style', get_template_directory_uri() . '/assets/css/navbar.css', [], '1.0');
  wp_enqueue_style('winners-banner-topo-style', get_template_directory_uri() . '/assets/css/banner-topo.css', [], '1.0');
  wp_enqueue_style('winners-footer-style', get_template_directory_uri() . '/assets/css/footer.css', [], '1.0');
  wp_enqueue_script('winners-banner-topo-script', get_template_directory_uri() . '/assets/js/banner-topo.js', [], '1.0', true);
});

add_action('template_redirect', function () {
  if (is_single()) {
    // Redireciona qualquer tentativa de acesso direto a um post
    wp_redirect(home_url(), 301);
    exit;
  }
});


add_theme_support('title-tag');
add_theme_support('post-thumbnails');

// Permitir templates customizados em subpastas (como /pages)
add_filter('template_include', function ($template) {
  if (is_page('home')) {
    $custom = get_template_directory() . '/pages/home.php';
    if (file_exists($custom)) return $custom;
  }

  if (is_page('quem-somos')) {
    $custom = get_template_directory() . '/pages/quem-somos.php';
    if (file_exists($custom)) return $custom;
  }

  if (is_page('equipes')) {
    $custom = get_template_directory() . '/pages/equipes.php';
    if (file_exists($custom)) return $custom;
  }

  if (is_page('calendario')) {
    $custom = get_template_directory() . '/pages/calendario.php';
    if (file_exists($custom)) return $custom;
  }

  return $template;
});

function shortcode_slider_comissao() {
    ob_start();
    get_template_part('partials/slider-comissao');
    return ob_get_clean();
}
add_shortcode('comissao_tecnica', 'shortcode_slider_comissao');

function comissao_slider_enqueue_scripts() {
    if (is_singular() && has_shortcode(get_post()->post_content, 'comissao_tecnica')) {

        // Enfileira CSS do slider
        wp_enqueue_style(
            'slider-comissao-style',
            get_template_directory_uri() . '/assets/css/slider-comissao.css',
            array(),
            null
        );

        // Enfileira JS do slider
        wp_enqueue_script(
            'slider-comissao-script',
            get_template_directory_uri() . '/assets/js/slider.js',
            array(),
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'comissao_slider_enqueue_scripts');


?>