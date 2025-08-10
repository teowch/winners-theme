<?php
get_template_part('partials/header');
get_template_part('partials/banner-topo');
?>

<main>
  <?php
  $args = [
    'category_name' => 'home',
    'posts_per_page' => 1
  ];
  $query = new WP_Query($args);

  if ($query->have_posts()) :
    $query->the_post();
    the_content();
    wp_reset_postdata();
  endif;
  ?>
</main>

<?php get_template_part('partials/footer'); ?>
