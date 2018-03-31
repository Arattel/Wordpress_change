<?php get_header();	?>

<?php get_template_part( 'loop-meta' ); ?>
  
<div class="container_16 clearfix">
  
  <div class="grid_11">
    <div id="content">	  
	  
	  <div id="post-0" class="post-0 post type-post error404 not-found">
      
        <div class="entry-content">
    

          
          <p><?php _e( "Це - перелік останніх публікацій. Можливо, він допоможе Вам знайти те, що Ви шукаєте:", 'vortex' ); ?></p>
    
          <ul>
            <?php wp_get_archives( array( 'limit' => 20, 'type' => 'postbypost' ) ); ?>
          </ul>                   
    
        </div><!-- end .entry-content -->
    
      </div><!-- end #post-0 -->
    
    </div> <!-- end #content -->
  </div> <!-- end .grid_11 -->
  
  <?php get_sidebar(); ?>

</div> <!-- end .container_16 -->
  
<?php get_footer(); ?>