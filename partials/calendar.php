<?php
// Check if The Events Calendar is active
  if ( ! class_exists('Tribe__Events__Main') ) {
    return '<div style="background: #ffebee; color: #c62828; padding: 15px; border: 1px solid #ef5350; border-radius: 4px; margin: 10px 0;">
      ⚠️ <strong>Erro:</strong> O plugin "The Events Calendar" não está instalado ou ativado.
    </div>';
  }

  if ( ! function_exists('tribe_get_events') ) {
    return '<div style="background: #ffebee; color: #c62828; padding: 15px; border: 1px solid #ef5350; border-radius: 4px; margin: 10px 0;">
      ⚠️ <strong>Erro:</strong> Função tribe_get_events() não encontrada. Verifique a versão do plugin.
    </div>';
  }

  $a = shortcode_atts([
    'qtd'    => 5,
    'cat'    => '',           // slug de categoria do TEC (tribe_events_cat)
    'titulo' => 'Próximos eventos',
    'data'   => 'd/m/Y',  // formato de data
    'debug'  => 'false',      // adicione debug="true" para mostrar informações
  ], $atts, 'proximos_eventos');

  $debug_mode = ($a['debug'] === 'true');
  $debug_output = '';

  $args = [
    'posts_per_page' => (int) $a['qtd'],
    'start_date'     => 'now',
    'eventDisplay'   => 'list',
    'post_status'    => 'publish',
  ];

  if ( ! empty( $a['cat'] ) ) {
    $args['tax_query'] = [[
      'taxonomy' => 'tribe_events_cat',
      'field'    => 'slug',
      'terms'    => sanitize_text_field($a['cat']),
    ]];
  }

  // Debug information
  if ( $debug_mode ) {
    $debug_output .= '<div style="background: #e3f2fd; color: #1565c0; padding: 15px; border: 1px solid #42a5f5; border-radius: 4px; margin: 10px 0;">';
    $debug_output .= '<strong>🔍 Informações de Debug:</strong><br><br>';
    $debug_output .= '<strong>Parâmetros da consulta:</strong><br>';
    $debug_output .= '<pre style="background: #fff; padding: 10px; border-radius: 4px; overflow-x: auto;">' . print_r($args, true) . '</pre>';
    
    // Count all events
    $all_events_args = ['posts_per_page' => -1, 'post_status' => 'publish'];
    $all_events = tribe_get_events($all_events_args);
    $debug_output .= '<strong>Total de eventos no banco:</strong> ' . count($all_events) . '<br><br>';
    
    // Check categories
    $event_categories = get_terms([
      'taxonomy' => 'tribe_events_cat',
      'hide_empty' => false
    ]);
    $debug_output .= '<strong>Categorias disponíveis:</strong> ';
    if ($event_categories && !is_wp_error($event_categories)) {
      $cat_names = array_map(function($cat) {
        return $cat->name . ' (slug: ' . $cat->slug . ')';
      }, $event_categories);
      $debug_output .= implode(', ', $cat_names);
    } else {
      $debug_output .= 'Nenhuma categoria encontrada';
    }
    $debug_output .= '<br><br>';
  }

  $eventos = tribe_get_events( $args );

  if ( $debug_mode ) {
    $debug_output .= '<strong>Eventos encontrados:</strong> ' . count($eventos) . '<br>';
    if ($eventos) {
      $debug_output .= '<strong>Títulos dos eventos:</strong> ';
      $titles = array_map(function($event) {
        return get_the_title($event);
      }, $eventos);
      $debug_output .= implode(', ', $titles);
    }
    $debug_output .= '</div>';
  }

  if ( ! $eventos ) {
    $no_events_msg = '<div style="background: #fff3e0; color: #ef6c00; padding: 15px; border: 1px solid #ffb74d; border-radius: 4px; margin: 10px 0;">';
    $no_events_msg .= '📅 <strong>Nenhum evento encontrado</strong>';
    if ( ! empty( $a['cat'] ) ) {
      $no_events_msg .= ' na categoria "' . esc_html($a['cat']) . '"';
    }
    $no_events_msg .= '.<br><br>';
    $no_events_msg .= 'Verifique se:<br>';
    $no_events_msg .= '• Os eventos estão publicados (não rascunho)<br>';
    $no_events_msg .= '• Os eventos têm data futura<br>';
    $no_events_msg .= '• A categoria especificada existe (se informada)<br><br>';
    $no_events_msg .= 'Use <code>debug="true"</code> no shortcode para mais informações.';
    $no_events_msg .= '</div>';
    
    return $debug_output . $no_events_msg;
  }

  ob_start();
  
  // Output debug info if enabled
  if ( $debug_mode ) {
    echo $debug_output;
  }
  ?>
  <section class="winners-eventos">
    <?php if ( ! empty($a['titulo']) ) : ?>
      <h2 class="winners-eventos__titulo"><?php echo esc_html($a['titulo']); ?></h2>
    <?php
        get_template_part('partials/orange-bar'); 
        endif; ?>

    <div class="winners-eventos__lista">
    <?php foreach ( $eventos as $evento ) : setup_postdata( $evento );
    $categories = get_the_terms($evento, 'tribe_events_cat');
            if ($categories && !is_wp_error($categories)) {
                $cat_names = array_map(function($cat) {
                    return esc_html($cat->name);
                }, $categories);
                $cat_slug = esc_html($categories[0]->slug);

            }
    ?>
      <article class="winners-evento <?php echo $cat_slug;?>">
        <h3 class="winners-evento__titulo"><?php echo get_the_title( $evento ); ?></h3>
            <div class="winners-evento__data winners-evento__info">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/calendar.png" alt="Calendário" class="winners-evento__icon">
              <?php
                $start = esc_html( tribe_get_start_date( $evento, true, $a['data'] ) );
                $end = esc_html( tribe_get_end_date( $evento, true, $a['data'] ) );
                echo $start;
                if ( $start !== $end ) {
                  echo ' - ' . $end;
                }
              ?> 
            </div>
            <?php
            // opcional: local/venue (se preenchido)
            if ( function_exists('tribe_get_venue') ) {
              $venue = tribe_get_venue( $evento );
              if ( $venue ) {
                echo '<div class="winners-evento__local winners-evento__info">
                      <img src="'.get_template_directory_uri().'/assets/images/icons/pin.png" alt="Pin" class="winners-evento__icon">'.esc_html($venue).'</div>';
              }
            }
            echo '<div class="winners-evento__categoria winners-evento__info">
                  <img src="'.get_template_directory_uri().'/assets/images/icons/swimmer.png" alt="Nadador" class="winners-evento__icon">'.
                  'Equipe <div class="categoria categoria-'.$cat_slug.'">' . implode(', ', $cat_names) . '</div></div>';
            ?>
        <div class="winners-evento__saiba-mais">Saiba Mais</div>
      </article>
      <?php endforeach; wp_reset_postdata(); ?>
    </div>
  </section>