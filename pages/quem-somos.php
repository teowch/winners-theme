<?php
get_header();
get_template_part('partials/banner-topo');
?>

<main class="conteudo-principal">
  <h1 class="page-title"><?php the_title(); ?></h1>
  <?php
  while (have_posts()) : the_post();
    the_content(); // Isso processa o conteúdo E os shortcodes
  endwhile;
  ?>
</main>

<?php get_footer(); ?>
