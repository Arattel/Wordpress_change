<div id="headimg">

  <?php if ( get_header_image() ) : ?>
  
  <div id="logo-image">
    <?php if (function_exists('vslider')) { vslider('abc'); }?>
  </div><!-- end of #logo -->
  
  <?php else: ?>
  
  <div id="logo-text">
    <span class="site-name"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
    <span class="site-description"><?php bloginfo( 'description' ); ?></span>
  </div><!-- end of #logo -->
  
  <?php endif; ?>

</div>