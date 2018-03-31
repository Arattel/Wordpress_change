  <div id="footer">
    <div class="container_16">
      <?php do_action( 'vortex_footer' ); ?>
    </div>
  </div>

</div> <!-- end .wrapper -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59471380-1', 'auto');
  ga('send', 'pageview');

</script>

<div class="share42init" data-url="<?php the_permalink() ?>" data-title="<?php the_title() ?>"></div>
<script type="text/javascript" src="http://spital.org.ua/share42/share42.js"></script>

<?php wp_footer(); ?>
</body>
</html>