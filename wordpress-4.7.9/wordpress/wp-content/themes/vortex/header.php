<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<link rel="icon" href="http://spital.org.ua/wp-content/uploads/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="http://spital.org.ua/wp-content/uploads/favicon.ico" type="image/x-icon"
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">  
  <div id="header">    
      

    <div class="myheader" style="display: table; padding-left: 10%; padding-top: 20px; padding-bottom: 25px;">

	<div class="grid_17" style="display: table-cell">
		<img src="http://spital.org.ua/wp-content/uploads/logo_final1.jpg" width="190px" height="220px">			      
	</div>
		
        <div class="grid_16" style="display: table-cell">
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