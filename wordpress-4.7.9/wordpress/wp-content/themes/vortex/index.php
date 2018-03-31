<?php get_header();	?>

<?php get_template_part( 'loop-meta' ); ?>






  
<div class="container_16 clearfix">

<div class="grid_sleft" style="float: left; margin-left: -165px; position: relative; padding-top: 50px; margin-right: 0px; padding-right: 20px;">
  <div id="sidebar_left">

	<?php if ( is_active_sidebar( 'true_side' ) ) : ?>
 
	<div id="true-side" class="sidebar">
 
		<?php dynamic_sidebar( 'true_side' ); ?>
 
	</div>
 
<?php endif; ?>

  </div> <!-- end #sidebar_left -->
</div>  <!-- end .grid_sleft -->
  
  <div class="grid_11">
    <div id="content">	  
	  
	  <?php if ( have_posts() ) : ?>
      
        <?php while ( have_posts() ) : the_post(); ?>
        
          <?php get_template_part( 'content' ); ?>
        
        <?php endwhile; ?>
      
      <?php else : ?>
                  
        <?php get_template_part( 'loop-error' ); ?>
      
      <?php endif; ?>
      
      <?php vortex_loop_nav(); ?>
    
    </div> <!-- end #content -->
  </div> <!-- end .grid_11 -->
  
  <?php get_sidebar(); ?>

</div> <!-- end .container_16 -->
  
<?php get_footer(); ?>