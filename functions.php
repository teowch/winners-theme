<?php
// Arquivo functions.php

remove_filter('the_content', 'wpautop');
add_filter('the_content', 'wpautop', 10);

remove_filter('the_content', 'do_shortcode');
add_filter('the_content', 'shortcode_unautop', 11);
add_filter('the_content', 'do_shortcode', 11);

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('winners-variables-style', get_template_directory_uri() . '/assets/css/variables.css', [], '1.0');
  wp_enqueue_style('winners-main-style', get_template_directory_uri() . '/assets/css/style.css', [], '1.0');
  wp_enqueue_style('winners-navbar-style', get_template_directory_uri() . '/assets/css/navbar.css', [], '1.0');
  wp_enqueue_style('winners-banner-topo-style', get_template_directory_uri() . '/assets/css/banner-topo.css', [], '1.0');
  wp_enqueue_style('winners-footer-style', get_template_directory_uri() . '/assets/css/footer.css', [], '1.0');
  wp_enqueue_style('winners-orange-bar-style', get_template_directory_uri() . '/assets/css/orange-bar.css', [], '1.0');
  wp_enqueue_style('tec-style-changes', get_template_directory_uri() . '/assets/css/tec.css', [], '1.0');
  wp_enqueue_script('winners-script', get_template_directory_uri() . '/assets/js/script.js', [], '1.0', true);
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

function shortcode_conteudo($atts, $content = '') {
  return '<div class="conteudo">'.do_shortcode($content).'</div>';
}
add_shortcode('conteudo', 'shortcode_conteudo');

function shortcode_columns($atts, $content=''){
  return '<div class="cols">'.do_shortcode($content).'</div>';
}
add_shortcode('columns','shortcode_columns');

function shortcode_col($atts, $content=''){
  $a = shortcode_atts(['span'=>'1'], $atts);
  return '<div class="col col--span-'.$a['span'].'">'.do_shortcode($content).'</div>';
}
add_shortcode('col','shortcode_col');

function shortcode_banner_topo() {
    ob_start();
    get_template_part('partials/banner-topo');
    return trim(ob_get_clean());
}
add_shortcode('banner_topo', 'shortcode_banner_topo');

function shortcode_orange_bar() {
    ob_start();
    get_template_part('partials/orange-bar');
    return trim(ob_get_clean());
}
add_shortcode('orange_bar', 'shortcode_orange_bar');

function shortcode_slider_comissao() {
    ob_start();
    get_template_part('partials/slider-comissao');
    return trim(ob_get_clean());
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
  return trim(ob_get_clean());
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

function shortcode_carousel_home() {
    ob_start();
    get_template_part('partials/carousel-home');
    return trim(ob_get_clean());
}
add_shortcode('carousel-home', 'shortcode_carousel_home');

function carousel_home_enqueue_scripts() {
    if (is_singular() && has_shortcode(get_post()->post_content, 'carousel-home')) {
        // Enfileira CSS do carousel
        wp_enqueue_style(
            'carousel-home-style',
            get_template_directory_uri() . '/assets/css/carousel-home.css',
            array(),
            null
        );

        // Enfileira JS do carousel
        wp_enqueue_script(
            'carousel-home-script',
            get_template_directory_uri() . '/assets/js/carousel-home.js',
            array(),
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'carousel_home_enqueue_scripts');


// Custom events treatment
add_action('init', function () {
  add_rewrite_rule(
    '^eventos/([0-9]+)/?$',                     // regex da URL
    'index.php?post_type=tribe_events&p=$matches[1]', // query vars WP
    'top'
  );
});

add_action('template_redirect', function () {
  if (is_singular('post')) {
    wp_redirect(home_url(), 301);
    exit;
  }
});

add_filter('template_include', function ($template) {
  if (is_singular('tribe_events')) {
    $custom = get_template_directory() . '/events.php';
    if (file_exists($custom)) return $custom;
  }
  return $template;
});

?>