<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">


<script type="text/javascript"> <!-- Анімація в заголовку -->
  var total_pics_num = 2; // колличество изображений
  var interval = 7000;    // задержка между изображениями
  var time_out = 10;       // задержка смены изображений
  var i = 0;
  var timeout;
  var opacity = 100;
  function fade_to_next() {
    opacity--;
    var k = i + 1;
    var image_now = 'image_' + i;
    if (i == total_pics_num) k = 1;
    var image_next = 'image_' + k;
    document.getElementById(image_now).style.opacity = opacity/100;
    document.getElementById(image_now).style.filter = 'alpha(opacity='+ opacity +')';
    document.getElementById(image_next).style.opacity = (100-opacity)/100;
    document.getElementById(image_next).style.filter = 'alpha(opacity='+ (100-opacity) +')';
    timeout = setTimeout("fade_to_next()",time_out);
    if (opacity==1) {
      opacity = 100;
      clearTimeout(timeout);
    }
  }
  setInterval (
    function() {
      i++;
      if (i > total_pics_num) i=1;
      fade_to_next();
    }, interval
  );
</script>

<link rel="icon" href="http://spital.org.ua/wp-content/uploads/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="http://spital.org.ua/wp-content/uploads/favicon.ico" type="image/x-icon"
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>




<div id="my-animation"> <!-- Картинки анімації в заголовку -->
  <img src='http://spital.org.ua/wp-content/uploads/quote-remaster.jpg' id="image_1" style="opacity: 0; filter: alpha(opacity=0); position: absolute; margin-left: 12.8%; padding-top: 20px; margin-right: 12.8%; padding-bottom: 20px;" />
  <img src='http://spital.org.ua/wp-content/uploads/2015/01/symbol_940x200.jpg' id="image_2" style="position: absolute; margin-left: 12.8%; padding-top: 20px; margin-right: 12.8%; padding-bottom: 20px;" />
</div>





<div class="wrapper">  
  <div id="header">  
      
      <div class="container_16 container_header_top clearfix">
        <div class="grid_16">
		  <?php get_template_part( 'custom', 'header' ); ?>
	</div>
      </div>
      
      <div id="nav">
        <div class="container_16 clearfix">
          <div class="grid_16">
            <?php vortex_primary_menu(); ?>
          </div>
        </div>
      </div>      
  
  </div>