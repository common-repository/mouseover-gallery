<?php
require_once( dirname(__FILE__) . '/mouseover-gallery.php');
  $mo_main_height=get_option('mo_main_height');
  $mo_main_width=get_option('mo_main_width');
  $mo_thumb_height=get_option('mo_thumb_height');
  $mo_thumb_width=get_option('mo_thumb_width');
  $mo_slide=get_option('mo_slide');
  $mo_border_color=get_option('mo_border_color');
  $mo_background_color=get_option('mo_background_color');
  $mo_caption_color=get_option('mo_caption_color');
  $mo_fwd_back_position=get_option('mo_fwd_back_position');
  $mo_fwd_back_add=get_option('mo_fwd_back');
  $mo_fwd_back_ini = '<div class="clear" style="clear: both;"></div><p class="gallery-nav"><a class="back" href="#" onclick="$.mo_gallery_reloaded.prev(); return false;">&laquo; Back</a>    <a class="forward" href="#" onclick="$.mo_gallery_reloaded.next(); return false;">Forward &raquo;</a></p>';
?>
<style type="text/css" media="screen" rel="stylesheet">
body {opacity: .999;}
.gbackgr {border: 5px solid #<?php echo $mo_border_color; ?>;width:<?php echo $mo_main_width; ?>px;background:#<?php echo $mo_background_color; ?>;text-align:center;}
.caption{color:#<?php echo $mo_caption_color; ?>;display:block;font-style:italic;padding:0 8px 8px 0;float:left;}
.mo_gallery_reloaded {width:<?php echo $mo_main_width; ?>px;margin:auto;}
.mo_gallery_reloaded li div .caption{font:italic 0.9em/1.4 georgia,serif;}
.main_image {width:<?php echo $mo_main_width; ?>px;height:auto;/*In testing - max-height:<?php echo $mo_main_height; ?>px;*/overflow:hidden;}
.main_image img{ margin-bottom:10px;max-width:<?php echo $mo_main_width; ?>px;height:auto;width:auto;max-height:<?php echo $mo_main_height; ?>px;}
.mo_gholder{position: relative;width: <?php echo $mo_main_width; ?>px;overflow: auto;/* For plugin to work on RTL sites */direction:ltr;padding: 0 0 5px 0;}
.mo_gallery_reloaded {width: 10000px;margin: 0 ;padding: 0;list-style: none;}
.mo_gallery_reloaded li {display:block;float:left;height:<?php echo $mo_thumb_height; ?>px;margin:0 8px 0 0;overflow:hidden;width:<?php echo $mo_thumb_width; ?>px;background:none;list-style:none;}
.mo_gallery_reloaded li a {display:none}
.mo_gallery_reloaded li div {position:absolute;display:none;top:0;left:180px}
.mo_gallery_reloaded li div img {cursor:pointer;height:100%;}
.mo_gallery_reloaded li.active div img, .mo_gallery_reloaded li.active div {display:block}
.mo_gallery_reloaded li img.thumb {cursor:pointer;top:auto;left:auto;display:block;width:<?php echo $mo_thumb_width; ?>px;height:<?php echo $mo_thumb_height; ?>px;}
.mo_gallery_reloaded li .caption {display:block;padding-top:.5em}
* html .mo_gallery_reloaded li div span {width:<?php echo $mo_main_width; ?>px;} /* MSIE bug */
p.mo_gallery-nav{max-width:<?php echo $mo_main_width; ?>px;height:30px;margin:0;padding:10px 5px 0;}
p.mo_gallery-nav a.back{background:url('<?php echo bloginfo( 'url' ) . '/wp-content/plugins/mouseover-gallery/images/back.png'; ?>') no-repeat; display:block;width:24px;height:24px;text-indent:-9999px;text-decoration:none;float:left;}
p.mo_gallery-nav a.forward{background:url('<?php echo bloginfo( 'url' ) . '/wp-content/plugins/mouseover-gallery/images/forward.png'; ?>') no-repeat; display:block;width:24px;height:24px;text-indent:-9999px;text-decoration:none;float:right;}
.mo_gallery_reloaded_container a{color: #666666; text-indent:-9999px; background:url('<?php echo bloginfo( 'url' ) . '/wp-content/plugins/mouseover-gallery/images/larger.png'; ?>') no-repeat;height:12px;width:12px;display:block;float:left;text-decoration:none;}
#gr_tooltip{position:absolute;border:1px solid #<?php echo $mo_caption_color; ?>;background:#<?php echo $mo_background_color; ?>;-moz-border-radius:5px;padding:4px 5px;color:#<?php echo $mo_caption_color; ?>;display:none;}
.loading{-moz-border-radius:4px;background:#<?php echo $mo_background_color; ?>;border:1px solid #<?php echo $mo_caption_color; ?>;color:#<?php echo $mo_caption_color; ?>;padding:10px;text-align:center;width:100px;}
#TB_window a:link {color: #666666; text-indent:-9999px; background:url('<?php echo bloginfo( 'url' ) . '/wp-content/plugins/mouseover-gallery/images/close.png'; ?>') no-repeat;height:24px;width:24px;display:block;}
.TB_overlayBG {background-color:#000;filter:alpha(opacity=75);-moz-opacity: 0.75;opacity: 0.75;}
* html #TB_overlay { /* ie6 hack */position: absolute;height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');}
#TB_window {position: fixed;z-index: 102;color:#000000;display:none;top:50%;left:50%;}
* html #TB_window { /* ie6 hack */position: absolute;margin-top: expression(0 - parseInt(this.offsetHeight / 2) + (TBWindowMargin = document.documentElement && document.documentElement.scrollTop || document.body.scrollTop) + 'px');}
#TB_window img#TB_Image {border: 4px solid #<?php echo $mo_border_color; ?>;}
#TB_caption{height:25px;padding:7px 10px 10px 12px;float:left;color:#<?php echo $mo_caption_color; ?>;}
#TB_closeWindow{float:right;height:25px;padding:4px 9px 10px 0;color:#<?php echo $mo_caption_color; ?>;}
.left_part {
 width: 57%;
 float: left;
 padding:0 ;
 border-right: 1px solid white;


 }
.right_part {
 width: 40.5%;
 float: left;
 padding:0 0 0 8px;
 border-left: 1px solid white;
 margin-left: -1px;
 }


.mo-gbackgr .mo_gholder {
overflow:visible;
width: auto;
}
.mo_gallery_reloaded li a {
cursor:default ;
list-style-image:none ;
list-style-position:outside ;
display: inline;
list-style-type:none;
margin:10px 0 0 ;
}

.mo_gallery_reloaded li a .wrapper {
display:none;
}
.mo_gallery_reloaded li{margin:0 2px 0 0;}                                                                                      
.left_part .wrapper {
float:left;
display:none;
width: 100%;
 }

.left_part .wrapper .caption {
background:transparent url('<?php echo bloginfo( 'url' ) . '/wp-content/plugins/mouseover-gallery/images/png.png'; ?>') repeat scroll 0 0;
color: black;
font-weight: bold;
display: block;
opacity:0.5;
padding: 3px  5px;
position:absolute;
clear:both;
width: auto;
}

.mo-gbackgr li {
display: inline;
text-align: left ;
}
.left_part .replaced {
 width: 100%;
 float: left;
 display:block;
}
.mo_gallery_reloaded li a img:first-child {
padding:2px 2px 2px 0;
}
.mo_gallery_reloaded {
width:auto;
}
.thickbox {display: none !important;} /*verhindert Anzeigen des blöden Pfeils beim Thumb-Titel*/
.mo-gbackgr .gallery-nav {
	display:none;
}
.right_part .caption {display:none;}
.rigt_part:after,.left_part:after {
	clear:both;
}
</style>