<?php
// Arquivo functions.php

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('winners-variables-style', get_template_directory_uri() . '/assets/css/variables.css', [], '1.0');
  wp_enqueue_style('winners-main-style', get_template_directory_uri() . '/assets/css/style.css', [], '1.0');
  wp_enqueue_style('winners-navbar-style', get_template_directory_uri() . '/assets/css/navbar.css', [], '1.0');
  wp_enqueue_style('winners-banner-topo-style', get_template_directory_uri() . '/assets/css/banner-topo.css', [], '1.0');
  wp_enqueue_style('winners-footer-style', get_template_directory_uri() . '/assets/css/footer.css', [], '1.0');
  wp_enqueue_style('winners-orange-bar-style', get_template_directory_uri() . '/assets/css/orange-bar.css', [], '1.0');
  wp_enqueue_script('winners-navbar-script', get_template_directory_uri() . '/assets/js/navbar.js', [], '1.0', true);
  wp_enqueue_script('winners-banner-topo-script', get_template_directory_uri() . '/assets/js/banner-topo.js', [], '1.0', true);
});

// add_action('template_redirect', function () {
//   if (is_single()) {
//     // Redireciona qualquer tentativa de acesso direto a um post
//     wp_redirect(home_url(), 301);
//     exit;
//   }
// });


add_theme_support('title-tag');
add_theme_support('post-thumbnails');
// Add support for The Events Calendar
function winners_theme_events_support() {
    add_theme_support('tribe-events');
}
add_action('after_setup_theme', 'winners_theme_events_support');

function shortcode_banner_topo() {
    ob_start();
    get_template_part('partials/banner-topo');
    return ob_get_clean();
}
add_shortcode('banner_topo', 'shortcode_banner_topo');

function shortcode_orange_bar() {
    ob_start();
    get_template_part('partials/orange-bar');
    return ob_get_clean();
}
add_shortcode('orange_bar', 'shortcode_orange_bar');

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

// [proximos_eventos qtd="5" cat="federados" titulo="Agenda" debug="true"]
function winners_sc_proximos_eventos( $atts = [] ) {
  require_once get_template_directory() . '/partials/calendar.php';
  return ob_get_clean();
}
add_shortcode( 'proximos_eventos', 'winners_sc_proximos_eventos' );

function winners_events_assets_conditional() {
  global $post;
  if (is_singular() && has_shortcode(get_post()->post_content, 'proximos_eventos')) {
      wp_enqueue_style(
      'winners-eventos-style',
      get_template_directory_uri() . '/assets/css/eventos.css',
      array(),
      null
    );
  }
}
add_action('wp_enqueue_scripts', 'winners_events_assets_conditional');


?>