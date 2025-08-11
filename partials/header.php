<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header class="header">
    <a href="<?php echo home_url(); ?>" class="logo">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-winners-laranja.png">
    </a>
    </div>
    <nav class="navbar">
      <!-- Hamburger Button -->
      <div class="menu-icon" id="menu-icon">
        <div class="bar bar-1"></div>
        <div class="bar bar-2"></div>
        <div class="bar bar-3"></div>
      </div>
      <ul id="menu">
        <a href="<?php echo home_url('/home'); ?>"><li>Início</li></a>
        <a href="<?php echo home_url('/quem-somos'); ?>"><li>Quem Somos</li></a>
        <a href="<?php echo home_url('/equipes'); ?>"><li>Equipes</li></a>
        <a href="<?php echo home_url('/calendario'); ?>"><li>Calendário</li></a>
      </ul>
    </nav>
  </header>
