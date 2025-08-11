<?php
// ID da página atual (ou do post atual em contexto de página)
$post_id = get_queried_object_id();

// Se tiver imagem destacada, renderiza o banner
if ( $post_id && has_post_thumbnail( $post_id ) ) :
  $url  = get_the_post_thumbnail_url( $post_id, 'full' );
  // Opcional: alt/title a partir do título da página
  $alt  = get_the_title( $post_id );
  ?>
  <section class="banner-topo" role="img" aria-label="<?php echo esc_attr( $alt ); ?>">
    <div
      class="banner-topo-image"
      style="background-image: url('<?php echo esc_url( $url ); ?>');">
     <div class="mask"></div>
    </div>
  </section>
<?php
endif;