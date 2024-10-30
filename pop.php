<?php
$root = dirname(dirname(dirname(dirname(__FILE__))));
$kroot = str_replace("\\", "/", dirname(__FILE__));
define( 'KISH_ABSPATH', dirname(__FILE__));
include_once($kroot.'/functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Kish Multi WP</title>
<link rel='stylesheet' href='<?php echo get_bloginfo('wpurl'); ?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=global,wp-admin&amp;ver=4198bec071152ccaf39ba26fd81dcd63' type='text/css' media='all' />
<link rel='stylesheet' id='colors-css'  href='<?php echo get_bloginfo('wpurl'); ?>/wp-admin/css/colors-classic.css?ver=20091217' type='text/css' media='all' />
<script type="application/javascript" src="<?php echo WP_PLUGIN_URL; ?>/kish-multi/uploadify/scripts/jquery-1.3.2.min.js"></script>
<script type="application/javascript" src="<?php echo WP_PLUGIN_URL; ?>/kish-multi/uploadify/scripts/swfobject.js"></script>
<script type="application/javascript" src="<?php echo WP_PLUGIN_URL; ?>/kish-multi/uploadify/scripts/jquery.uploadify.v2.0.0.min.js"></script>
<script type='text/javascript' src='<?php echo get_bloginfo('wpurl'); ?>/wp-includes/js/jquery/ui.core.js?ver=1.7.1'></script>

<?php kish_multi_wp_addHeaderCode('flag'); 
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
				kish_multi_wp_get_new_home_page();
				kish_nice_editor_init();
 			});	
</script>
</head>
<body>
	<div style="width:100%;display:block;overflow:hidden">
	<div id="kish_multi_wp_mode">This Wordpress Plugin is by <a href="http://www.kisaso.com">Kishore Asokan</a></div>
	<div id="kish_multi_debug"><?php //kish_multi_debug(); ?></div>
	<h2>Kish Multi WP Settings</h2><span id="kish_multi_wp_help" style="border:1px;solid #000000;height:20px"></span>
		<div class="metabox-holder">
			<div class="postbox-container" style="width:98%;">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox ">
							<h3 class="hndle" style="margin-bottom:4px">
								<span style="float:right">Working on <span id="kish_multi_wp_site_info"></span></span>
								<input class="button-secondary" type="button" name="Submit" value="Home &raquo;" onclick = "kish_multi_wp_get_new_home_page(); ">
								<input class="button-secondary" type="button" name="Submit" value="Add Blog &raquo;" onclick = "kish_multi_wp_print_new_site_form(); ">
								<input class="button-secondary" type="button" name="Submit" value="View Latest Posts &raquo;" onclick = "kish_multi_wp_single_post('0'); ">
								<input class="button-secondary" type="button" name="Submit" value="Write a New Post &raquo;" onclick = "kish_multi_wp_new_post(); ">
							</h3>
						<div>
						<div id="kish_multi_wp_prog_1" style="width:20px;height:20px;float:left;"></div>
						<div id="kish_multi_wp_sidebar" align="left"><?php kish_wp_multi_display_saved_sites(); ?></div>
						</div>
						<div id="kish_multi_wp_resultDiv_1">
							<?php //kish_multi_wp_print_new_post_layout(get_site_option('km_default_blog'));	
							$k=new kish_multi_wp();
							$k->load(get_site_option('km_default_blog'));
							?>
							<div style="width:100%;display:block;overflow:hidden;padding:3px">
							<div style="clear:both;"></div>
							<div class="metabox-holder">
									<div class="postbox-container" style="width:29%;display:block;overflow:hidden;">
											<div class="postbox ">
												<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><a href="##" onclick="kish_multi_change_tabs('menu');">Site Links</a></span><span> | <a href="##" onclick="kish_multi_change_tabs('search');">Search</a></span><span id="kish_multi_wp_sitename_prog"></span></h3>
												<div class="inside" id="kish_multi_wp_new_post_sidebar" style="font-size:11px;display:block;overflow:hidden;padding:5px">
													<?php kish_multi_wp_print_site_change_links($blogid); ?>
													<div>
													<input type="button" value="Search Twitter" onclick="kish_multi_twitter_search_selection('km_twitter_search');">
													</div>
													<div id="km_twitter_search" style="height:200px;overflow:auto">
													
													</div>
												</div>
												
												<div class="inside" id="kish_multi_wp_latest_post_titles" style="font-size:11px;display:block;overflow:hidden;padding:5px">
						
												</div>
											</div>
									</div>
								</div>
								<div class="metabox-holder" style="margin-top:-40px">
									<div class="postbox-container" style="width:69%;display:block;overflow:hidden;">
											<div class="postbox ">
												<div class="handlediv"><br></div><h3 class="hndle"><span>New Post to be post on <span id="kmwp-pt"><?php echo $k->getTitle(); ?></span></span></h3>
												<div class="inside" id="kish_multi_wp_new_post_create_cont" style="font-size:11px;display:block;padding:5px">
												<?php kish_multi_wp_new_post_form_print(get_site_option('km_default_blog'), stripslashes($_GET['s'])); ?>
												</div>
												<div class="inside" id="kish_multi_wp_new_post_preview" style="font-size:11px;display:block;overflow:hidden;padding:5px">
												</div>
												<div class="inside" id="kish_multi_wp_new_post_form" style="font-size:11px;display:block;overflow:hidden;padding:5px">
												</div>
												<div class="inside" id="kish_multi_wp_search_results_prog" style="font-size:11px;float:left;display:block;height:30px;float:left">
												</div>
												<div class="inside" id="kish_multi_wp_search_results" style="font-size:11px;display:block;padding:5px;width:100%;float:left">
												</div>						
											</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>