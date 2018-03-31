<?php get_header();	?>

<div class="container_16 clearfix">
  
  <div class="grid_11">
    <div id="content">	

<div class="share42init" data-url="<?php the_permalink() ?>" data-title="<?php the_title() ?>"></div>
<script type="text/javascript" src="http://spital.org.ua/share42/share42.js"></script>  
	  
	  <?php if ( have_posts() ) : ?>
      
        <?php while ( have_posts() ) : the_post(); ?>
        
          <?php get_template_part( 'content', 'single' ); ?>
        
        <?php endwhile; ?>
      
      <?php else : ?>
                  
        <?php get_template_part( 'loop-error' ); ?>
      
      <?php endif; ?>
      
      <?php vortex_loop_nav_singular_post(); ?>
    
    </div> <!-- end #content -->
  </div> <!-- end .grid_11 -->
  
  <?php get_sidebar(); ?>

</div> <!-- end .container_16 -->
  
<?php get_footer(); ?>