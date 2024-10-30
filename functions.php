<?php
global $globalsite,$arrimages;
include_once('kish_multi_wp.class.php');
$root = dirname(dirname(dirname(dirname(__FILE__))));
$kroot = str_replace("\\", "/", dirname(__FILE__));
file_exists($root.'/wp-load.php') ? require_once($root.'/wp-load.php') : require_once($root.'/wp-config.php');
define('KISH_MULT_WP_LOADER_TWO',WP_PLUGIN_URL.'/kish-multi/img/ajax-loader.gif', true);
define('KISH_MULT_WP_LOADER',WP_PLUGIN_URL.'/kish-multi/img/indicator.gif', true);
define('KISH_MULT_WP_LOADER_THREE',WP_PLUGIN_URL.'/kish-multi/img/loader3.gif', true);
define('KISH_MULT_WP_AJAXURL',WP_PLUGIN_URL.'/kish-multi/kish-multi-wp.php', true);
define('KISH_MULT_WP_AJAXURL_2',WP_PLUGIN_URL.'/kish-multi/index.php', true);
define('KISH_MULT_WP_POPURL',WP_PLUGIN_URL.'/kish-multi/pop.php', true);
define('KISH_MULT_WP_IMG_DIR_URL',WP_PLUGIN_URL.'/kish-multi/img/', true);
define('KISH_MULT_WP_EMAIL_REPLY', true, true);
define('KISH_MULT_WP_NUMPOSTS_SIDEBAR', 50, true);
define('KISH_MULT_WP_DEFAULT_SITE', get_site_option('km_default_blog'), true);
define('KISH_MULT_WP_IMG_FOLDER_PATH', kmp_get_img_folder_path(), true);
define('KISH_MULT_WP_IMG_FOLDER_PATH_POP', 'uploadify/uploads', true);
define('KISH_MULT_WP_DEFAULT_FEED', substr(get_site_option('km_default_feed', true),0,4)=='http' ? get_site_option('km_default_feed', true) : "http://kishpress.com/feed/"); 
define('KISH_MULT_WP_GOOGLE_API_KEY', get_site_option('km_google_api_key'), true);
define('KISH_MULT_WP_IMG_FOLDER_PATH_FROM_ROOT', $root.'/wp-content/plugins/kish-multi/uploadify/uploads/' , true);
define('KISH_MULT_WP_MAX_POSTS', strlen(get_site_option('km_max_posts', true)) ? get_site_option('km_max_posts', true) : 1);
define('KISH_MULTI_WP_SCREENLOCK', 'true', true);
define('KISH_MULTI_WP_VERSION', '1.0', true);
$kmp_a_theme=function_exists('get_user_meta') ? get_user_meta($current_user->ID, 'admin_color', true) : get_usermeta($current_user->ID, 'admin_color', true);
define('KISH_MULTI_THEME_COLOR', $kmp_a_theme, true);
function kish_multi_wp_create_db() {
	global $wpdb;
	$sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."kish_multi_wp` (`kish_multi_wp_id` INT NOT NULL AUTO_INCREMENT ,`kish_multi_wp_blog_url` VARCHAR( 200 ) NOT NULL , `kish_multi_wp_username` VARCHAR( 20 ) NOT NULL ,`kish_multi_wp_password` VARCHAR( 30 ),`kish_multi_wp_blog_name` VARCHAR( 100 ),`kish_multi_blog_desc` VARCHAR( 200 ) NOT NULL , PRIMARY KEY (  `kish_multi_wp_id` ) ,UNIQUE (`kish_multi_wp_id`));" ;
	if(mysql_query($sql, $wpdb->dbh)) {		
	}
	else {
		echo "Error Creating Table";
	}
}
function kmp_get_img_folder_path() {
	$root = dirname(dirname(dirname(dirname(__FILE__))));
	if(is_dir("/wp-content/plugins/kish-multi/uploadify/uploads")) {
		$imgfolder="/wp-content/plugins/kish-multi/uploadify/uploads";
	}
	else {
		$imgfolder="../wp-content/plugins/kish-multi/uploadify/uploads";
	}
	return $imgfolder;
}
function kish_multi_wp_addHeaderCode($flag="") {
	echo "<script type=\"text/javascript\" src=\"" . WP_PLUGIN_URL ."/kish-multi/kish_multi_wp_js.php?flag=".$flag."&yser=no\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"" . WP_PLUGIN_URL ."/kish-multi/kish-multi-wp-ajax.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"" . WP_PLUGIN_URL ."/kish-multi/uploadify/scripts/jquery-1.3.2.min.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"" . WP_PLUGIN_URL ."/kish-multi/uploadify/scripts/swfobject.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"" . WP_PLUGIN_URL ."/kish-multi/uploadify/scripts/jquery.uploadify.v2.0.0.min.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"" . WP_PLUGIN_URL ."/kish-multi/kish-multi-wp-ajax.js\"></script>\n";
}
function kish_multi_wp_style() {
?>
<style>
	.kish_inside {padding:5px;margin:5px 2px 2px 2px;border:1px solid #CACACA;}
	.kmp_search_buttons{}
	.kmp_footer{background:#CACACA;height:25px;color:#000;padding:5px;}
	.kmp_footer a{color:#000;}
	.kmp_search_buttons img {width:30px;height:30px}
	.kishpost { font-size:11px;min-height:50px;padding:3px}
	.kishpost img {width:40px;height:40px;float:left;padding:3px;}
	.kishpost_pending { font-size:11px;min-height:55px; background-color:#FBFCE3;margin:3px 0px 3px 0px;padding:4px 2px 2px 2px;}
	.kishpost_approved { font-size:11px;min-height:55px; margin:3px 0px 3px 0px;padding:4px 2px 2px 2px;}
	.kishpost_single_view_app { font-size:11px;padding:3px}
	.kishpost_single_view_pend { font-size:11px; background-color:#FBFCE3;margin:3px 0px 3px 0px;padding:4px 2px 2px 2px;}
	.kishpost_approved { font-size:11px;min-height:50px; margin:3px 0px 3px 0px;padding:4px 2px 2px 2px;}
	.kishcomment_pending { font-size:11px;min-height:50px; background-color:#FBFCE3;margin:3px 0px 3px 0px}	
	.kishcomment_pending p{font-size:11px; margin-top:2px}
	.kishcomment_approved { font-size:11px;min-height:50px;margin:3px 0px 3px 0px}
	.kishcomment_approved p{font-size:11px; margin-top:2px}
	.kishcat_selected {font-size:16px; margin-top:2px;height:15px; background-color:#CA0000;color:#FFFFFF;font-weight:bolder;}
	.kishcat_selected a{color:#FFFFFF;}
	.kishcat_unselected {font-size:12px; margin-top:2px;height:15px; background-color:#FFFFFF;color:#000000;font-weight:normal;}
	#kish_multi_wp_help{min-height:35px;display:block;}
	#kmp_single_blog_coms {margin:10px 10px 5px 10px;border:1px solid #CACACA;padding:5px 5px 5px 10px;height:350px;overflow:auto;}	
	.kish_multi_wp_info_main {padding:3px; float:left; width:32%; border:1px solid #ffffff; float:left; min-height:300px;border-bottom:hidden;}
	.kish_multi_wp_info_header {padding:3px; float:left; width:32%; border:1px solid #ffffff; float:left; min-height:20px;font-size:14px; font-stretch:extra-expanded; font-weight:bolder; background-color:#3b5998; color:#FFFFFF;}
</style>
<?php
}
function kish_multi_wp_add_admin() {
	$plugin_page=add_options_page('Kish Multi Pro', 'Kish Multi', 8, 'kish-multi-wp', 'kish_multi_wp_option');
	add_action( 'admin_head-'. $plugin_page, 'kish_multi_wp_addHeaderCode' );
	add_action( 'admin_head-'. $plugin_page, 'add_tinymce' );
	add_action( 'admin_head-'. $plugin_page, 'kish_multi_wp_style' );
}
function add_tinymce() {
    wp_print_scripts('jquery-ui-core');
    wp_print_scripts('jquery-ui-tabs');
    wp_print_scripts('editor');
    add_thickbox();
	add_action( 'admin_head', 'wp_tiny_mce' );
}
function kish_do_css() {
    wp_enqueue_style('thickbox');
}
function kish_multi_wp_install() {
	kish_multi_wp_create_db();
}
function kish_multi_wp_get_site_info($siteid){
	$k=new kish_multi_wp();
	$k->load($siteid);
	$info=array('title'=>$k->getTitle(), 'desc'=>$k->getDesc(), 'url'=>$k->getUrl());
	return $info;
}
function kish_multi_wp_site_title_print($siteid){
	$info=kish_multi_wp_get_site_info($siteid);
	echo "<a href =\"".$info['url']."\" title=\"".$info['desc']."\">".$info['title']."</a>";
}

function kish_multi_wp_option() {
	kish_multi_check_default_blog();
	?>
	<div style="width:100%;display:block;overflow:hidden">
	<div id="kish_multi_wp_mode">This Wordpress Plugin is by <a target="_blank" href="http://www.kisaso.com">Kishore Asokan</a><a target="_blank" href="http://kishpress.com"><img style="float:right;margin:10px" src="http://kishpress.com/img/kp_logo.png"></img></a></div>
	<div id="kish_multi_debug"><?php //kish_multi_debug(); ?></div>
	<h2>Kish Multi</h2><span id="kish_multi_wp_help" style="height:25px;display:block"></span>
		<div class="metabox-holder">
			<div class="postbox-container" style="width:98%;">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox ">
							<h3 class="hndle" style="margin-bottom:4px">
								<span style="float:right">Working on <span id="kish_multi_wp_site_info"></span></span>
								<input class="button-secondary" type="button" name="Submit" value="Home &raquo;" onclick = "kish_multi_wp_get_new_home_page();return false; ">
								<input class="button-secondary" type="button" name="Submit" value="Add Blog &raquo;" onclick = "kish_multi_wp_print_new_site_form();return false; ">
								<input class="button-secondary" type="button" name="Submit" value="Latest Posts &raquo;" onclick = "kish_multi_wp_single_post('0');return false; ">
							</h3>
						<div>
						<div id="kish_multi_wp_prog_1" style="width:25px;height:20px;float:left;margin-left:3px"></div>
						<div id="kish_multi_wp_sidebar" align="center"><?php kish_wp_multi_display_saved_sites(); ?></div>
						</div>
						<div id="kish_multi_wp_resultDiv_1">
							<?php kish_multi_wp_print_homepage_structure();	?>
						</div>
					</div>
				</div>
				<div id="kmp_footer" class="kmp_footer">
					<a href="http://kishpress.com/kish-multi-pro" target="_blank">Kish Multi Pro</a> | 
					<a href="http://kishpress.com/affiliates/" target="_blank">Affiliate Program</a>
				</div>
			</div>
		</div>
	</div>
<?php
}
function kish_multi_wp_print_homepage_structure() {
	?>
	<div style="width:100%;display:block;overflow:hidden">
	<div style="clear:both;"></div>
	<div class="metabox-holder">
			<div class="postbox-container" style="width:49%;display:block;overflow:hidden;">
					<div class="postbox ">
						<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span>Latest Pending commentss</span></h3>
						<div class="inside" id="kish_multi_wp_pending_comments" style="display:block;overflow:hidden;padding:3px">
							<?php kish_multi_wp_pending_comments_homepage (); ?>
						</div>
					</div>
			</div>
		</div>
		<div class="metabox-holder" style="margin-top:-40px">
			<div class="postbox-container" style="width:49%;display:block;overflow:hidden;">
					<div class="postbox ">
						<div class="handlediv"><br></div><h3 class="hndle"><span>Latest Blog Posts</span></h3>
						<div class="inside" id="kish_multi_wp_latest_posts" style="display:block;overflow:hidden;padding:3px">
							<?php kish_multi_wp_pending_posts_homepage (); ?>
						</div>
					</div>
			</div>
		</div>
	</div>
	<?php
}
function kish_multi_get_site_id_to_array() {
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	$strsites="";
	$counter=1;
	if ($results){
		foreach ($results as $result) :
			if($counter==1) {
				$strsites=$result->kish_multi_wp_id;
			}
			else {
				$strsites.=",".$result->kish_multi_wp_id;
			}
			$counter++;
		endforeach;
	}
	return $strsites;
}
function kish_multi_get_site_id_name_to_array() {
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	$strsites="";
	$counter=1;
	if ($results){
		foreach ($results as $result) :
			if($counter==1) {
				$strsites=$result->kish_multi_wp_id.",".addslashes($result->kish_multi_wp_blog_name);
			}
			else {
				$strsites.="|".$result->kish_multi_wp_id.",".addslashes($result->kish_multi_wp_blog_name);
			}
			$counter++;
		endforeach;
	}
	return $strsites;
}

function kish_multi_get_first_site_id() {
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	$counter=1;
	if ($results){
		foreach ($results as $result) :
			if($counter==1) {
				$strsites=$result->kish_multi_wp_id;
			}
			$counter++;
		endforeach;
	}
	return $strsites;
}
function kish_multi_get_site_url_to_array() {
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	$strsites="";
	$counter=0;
	$selsite=count($results);
	if ($results){
		foreach ($results as $result) :
			if($counter==$selsite) {
				$url=str_replace("http://", "", $result->kish_multi_wp_blog_url);
				$url=str_replace("www.", "", $url);
				$strsites=$url;
			}
			$counter++;
		endforeach;
	}
	return $strsites;
}
function kish_multi_get_site_rss_url_to_array() {
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	$strsites="";
	$counter=0;
	$selsite=count($results);
	if ($results){
		foreach ($results as $result) :
			if($counter==1) {
				$strsites=$result->kish_multi_wp_blog_url;
			}
			else {
				$strsites.=",".$result->kish_multi_wp_blog_url;
			}
			$counter++;
		endforeach;
	}
	return $strsites;
}
function kish_multi_wp_pending_comments_homepage () {
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	if ($results){
		foreach ($results as $result) :
			$blogid=$result->kish_multi_wp_id;
			$kish->load($blogid);	
			?>
				<div style="border:1px solid #CACACA;min-height:25px" id="kish_multi_wp_l_comments_<?php echo $blogid; ?>">
					<div style="float:right;width:20px;height:20px" id="kish_multi_wp_pending_comments_prog_<?php echo $blogid; ?>"></div>
				<?php echo "<p style=\"font-size:11px\">Getting Un-approved comments from ".$kish->getTitle()." ..</p>";?>
									
				</div>				
			<?php
		endforeach;	
	}
}
function kish_multi_wp_pending_posts_homepage () {
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	if ($results){
		foreach ($results as $result) :
			$blogid=$result->kish_multi_wp_id;
			$kish->load($blogid);	
			?>
			<?php echo "<strong> Posts for ".$kish->getTitle()."</strong>";?>
				<div style="border:1px solid #CACACA;min-height:25px;margin-top:5px" id="kish_multi_wp_l_posts_<?php echo $blogid; ?>">
					<div style="float:right;width:20px;height:20px" id="kish_multi_wp_pending_posts_prog_<?php echo $blogid; ?>"></div>
				<?php echo "<p style=\"font-size:11px\">Getting Posts from ".$kish->getTitle()." ..</p>";?>
				
				</div>				
			<?php
		endforeach;	
	}
}
function kish_multi_wp_print_all_site_pending_comments() {	
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	if ($results){		
		?>
		<div style="width:100%;display:block;overflow:hidden;padding:3px;margin-top:5px">
			<div class="metabox-holder" style="margin-top:5px;">
				<div class="postbox-container" style="width:49%;display:block;overflow:hidden">
					<div class="postbox ">
						<div class="handlediv"><br>
						</div><h3 class="hndle"><span><?php echo "Pending Comments"; ?></span></h3>
							<div class="inside" id="kish_multi_wp_p_coms" style="padding:3px">
								<?php
								foreach ($results as $result) :
									$blogid=$result->kish_multi_wp_id;						
									?>
									<div style="border:1px solid #CACACA;min-height:25px" id="kish_multi_wp_l_comments_<?php echo $blogid; ?>">
									
										<div style="float:right;width:20px;height:20px" id="kish_multi_wp_pending_comments_prog_<?php echo $blogid; ?>"></div>
									</div>
									<?php
								endforeach;	
								?>
							</div>
					</div>
				</div>	
			</div>
		</div>
		<div id="kish_multi_wp_help"></div>
		<?php	
	}
}
function kish_multi_wp_print_home_page_2() {
	?>
	<div style="width:100%;display:block;overflow:hidden;padding:3px;margin-top:5px" id="kish_multi_new_home">
		<div id=" ">
			<?php kish_multi_wp_print_home_page();	?>	
		</div>
		
	</div>
	<div id="kish_multi_wp_help"></div>
	<?php
}
function kish_multi_wp_print_home_page() {	
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	if ($results){
		?>
		<div style="width:100%;display:block;overflow:hidden;padding:3px;margin-top:5px">
			<div class="metabox-holder" style="margin-top:5px;">
				<div class="postbox-container" style="width:49%;display:block;overflow:hidden">
					<div class="postbox ">
						<div class="handlediv"><br>
						</div><h3 class="hndle"><span><?php echo "Pending Comments"; ?></span></h3>
							<div class="inside" id="kish_multi_wp_tags" style="padding:3px">
								<?php
								foreach ($results as $result) :
									$blogid=$result->kish_multi_wp_id;						
									?>
									<div style="border:1px solid #CACACA;min-height:25px" id="kish_multi_wp_l_comments_<?php echo $blogid; ?>">
										<div style="float:right;width:20px;height:20px" id="kish_multi_wp_pending_comments_prog_<?php echo $blogid; ?>"></div>
										<?php kish_multi_wp_get_blog_get_comments($blogid, 'hold'); ?>
									</div>									
									<?php
								endforeach;	
								?>
							</div>
					</div>
				</div>	
			</div>
		</div>
		<div id="kish_multi_wp_help"></div>
		
		<?php	
	}
}
function kish_multi_wp_add_site_page($siteid=0) {	
	$flag=false;
	$f=false;
	global $globalsite;
	if($siteid!=0) {	
		if($siteid==get_site_option('km_default_blog'))	{
			$f=true;
		}
		$flag=true;	
		$globalsite=new kish_multi_wp();
		$thisbuttontext="Update";
		$delmsg="Are you sure to delete ".addslashes($thisblogname)."?";
		$results=$globalsite->getSiteFromDb($siteid);
		if ($results){
			foreach ($results as $result) :
				$thisblogid=$siteid;			
				$thisblogname=$result->kish_multi_wp_blog_name;
				$thisblogdesc=$result->kish_multi_blog_desc;
				$thisblogurl=$result->kish_multi_wp_blog_url;
				$thisbloguname=$result->kish_multi_wp_username;
				$thisblogpw=$result->kish_multi_wp_password;
				$thisbuttontext="Update";
				$delmsg="Are you sure to delete ".addslashes($thisblogname)."?";
			endforeach;
		}
	}
	else {
		$thisblogname='';
		$thisblogdesc='';
		$thisblogurl='';
		$thisbloguname='';
		$thisblogpw='';
		$thisbuttontext="Save ";
	}
	?>
	<div style="width:100%;display:block;overflow:hidden;padding:3px">
		<div class="metabox-holder">
			<div class="postbox-container" style="width:49%;">				
					<div class="postbox ">
						<div class="handlediv"><br></div><h3 class="hndle"><span>Site Details</span></h3>
						<div class="table" style="display:block;overflow:hidden;padding:3px">
							<input type="hidden" id="kish_multi_wp_id" value="<?php echo $thisblogid; ?>">
								<table id="hor-zebra" width="90%" align="left" style="margin-left:15px">
									<tr><td width="30%">Blog URL :</td><td><input type="text" size="50" id="kish_multi_wp_blog_url" value="<?php echo $thisblogurl; ?>"></td></tr>
									<tr><td width="30%">Admin User Name :</td><td><input type="text" size="20" id="kish_multi_wp_username" value="<?php echo $thisbloguname; ?>"></td></tr>
									<tr><td width="30%">Admin Password :</td><td><input type="password" size="20" id="kish_multi_wp_password" value="<?php echo $thisblogpw; ?>"></td></tr>
									<tr><td width="50%" id="kish_multi_wp_msg_1"></td><td><input class="button-secondary" type="button" name="Submit" value="<?php echo $thisbuttontext; ?> &raquo;" onclick ="<?php if($flag) { ?> kish_multi_wp_update_site(); <?php } else { ?> kish_multi_wp_save_new_site(); <?php } ?>">
									<?php if($flag) { ?> <input class="button-secondary" type="button" name="Submit" value="Delete &raquo;" onclick ="kish_multi_wp_delete_site()"><?php if(!$f) { ?><span id="kmp_def_site"><input class="button-secondary" type="button" name="Submit" value="Set Default &raquo;" onclick ="kish_update_default_site('<?php echo $siteid; ?>')"></span><?php } } ?></td></tr>
								</table>
						</div>
					</div>				
			</div>
		</div>
		<div class="metabox-holder" style="margin-top:-50px;">
			<div class="postbox-container" style="width:49%;display:block;overflow:hidden">
					<div class="postbox ">
						<div class="handlediv"><br></div><h3 class="hndle"><span>Tags</span></h3>
						<div class="inside" id="kish_multi_wp_tags" style="padding:3px">
							<p class="sub">To Be Loaded...</p>
						</div>
					</div>
			</div>
		</div>		
		<div class="metabox-holder">
			<div class="postbox-container" style="width:49%;display:block;overflow:hidden;">
					<div class="postbox ">
						<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span>Latest Blog Posts</span></h3>
						<div class="inside" id="kish_multi_wp_post_status" style="display:block;overflow:hidden;padding:3px">
							<p class="sub">To Be Loaded...</p>
						</div>
					</div>
			</div>
		</div>
		<div class="metabox-holder">
			<div class="postbox-container" style="width:49%;display:block;overflow:hidden;">
					<div class="postbox ">
						<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span>Latest comments</span></h3>
						<div class="inside" id="kish_multi_wp_latest_comments" style="display:block;overflow:hidden;padding:3px">
							<p class="sub">To Be Loaded...</p>
						</div>
					</div>
			</div>
		</div>
		<div class="metabox-holder">
			<div class="postbox-container" style="width:49%;display:block;overflow:hidden;">
					<div class="postbox ">
						<div class="handlediv"><br></div><h3 class="hndle"><span>Blog Info</span></h3>
						<div class="inside" id="kish_multi_wp_bloginfo" style="display:block;overflow:hidden;padding:3px">
							<p class="sub">To Be Loaded...</p>
						</div>
					</div>
			</div>
		</div>
	</div>

	<?php
}
function kish_set_default_blog($blogid){
	update_site_option('km_default_blog', $blogid);
	echo "Done..";
}
function kish_wp_multi_display_saved_sites() {
	$site=new kish_multi_wp();
	$results=$site->getSavedSites();
	if ($results){
		foreach ($results as $result) :
			echo "<input type=\"button\" value =\"".$result->kish_multi_wp_blog_name."\" onclick=\"kish_multi_wp_updateinfo('".$result->kish_multi_wp_id."');\">";
		endforeach;	
	}
	else {
		?>
		<input class="button-secondary" type="button" name="Submit" value="Add your first blog and start up &raquo;" onclick = "kish_multi_wp_print_new_site_form(); ">
		<?php
	}
}
function kish_multi_wp_get_blog_info($blogid){
	$k=new kish_multi_wp();
	$k->load($blogid);
	echo $k;	
}
function kish_multi_wp_check_in_array($value, $array) {
	$flag=false;
	foreach($array as $val):
		if($val==$value){$flag= true;}
	endforeach;
	return $flag;
}
function addtinymce() {
    echo '<script language="javascript" type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-includes/js/tinymce/tiny_mce.js"></script>';
    echo '<script language="javascript" type="text/javascript">';
    echo 'tinyMCE.init({mode : "textareas", plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",theme : "advanced", theme_advanced_buttons1 : "bold,italic,strikethrough,bullist,numlist,outdent,indent,link,unlink", theme_advanced_buttons2 : "", theme_advanced_buttons3 : "", language : "en",theme_advanced_toolbar_location : "top", theme_advanced_toolbar_align : "left"});';
    echo '</script>';
} 
function kish_multi_wp_single_post_print_without_links($blogid, $postid) {
	$k=new kish_multi_wp();
	$k->load($blogid);
	$options=$k->wp_get_post($postid);
	echo "<div id =\"kish_multi_wp_post_container\">"; //post container
	$postdate=$options['dateCreated'];
	$postid=$options['postid'];
	if($options['post_status']=='pending'||$options['post_status']=='draft') {
		$class='kishpost_pending';
	}
	else {
		$class='kishpost_approved';
	}
	echo "<div id=\"k-post-".$postid."\" style=\"border-bottom:1px solid #CACACA; padding:4px 2px 2px 2px;\">";
	echo "<div class=\"".$class."\">";
	echo "<h2 id=\"kish_post_title\" >".$options['title']."</h2>";
	echo "<div id=\"kish_post_desc\">".$options['description']."</div>"; 
	$postdate=$options['dateCreated'];
	echo "<p style=\"font-size:10px;font-weight:bold;\">Posted on - ".$postdate->day ."-".$postdate->month ."-".$postdate->year ."<span> | ".$options['post_status']." | Posted By - ".$options['wp_author_display_name']."</span></p>";
	?>
	<div>
		<p><strong>Categorized Under :</strong>
		<?php
			$cats=$options['categories'];
				foreach($cats as $cat):
					$thiscat .= $cat. ", ";					
				endforeach;
			echo substr(trim($thiscat),0,-1);
		?>
		</p>
		<p><strong>Tagged :</strong>
		<?php echo $options['mt_keywords']; ?>
		</p>
		<p><?php echo "<span style=\"margin-bottom:2px\"><strong><a href=\"".$options['link']."\">Visit the Post Page</a></strong></span><br>";?></p>
	</div>								
	<?php	
	echo "</div>";
	echo "</div>";
}
function kish_get_img_from_content($content) {
	preg_match('/<img.+?src=\"(.+?)\b\"/is', stripslashes($content), $match);
	if(strlen($match[1])) {
		return $match[1];
	}
	else {
		return false;
	}
}
function kish_multi_wp_single_post($blogid, $postid){
	$flag=false;
	$k=new kish_multi_wp();
	$k->load($blogid);
	if($postid>1) {$options=$k->wp_get_post($postid);}
	else {$options=$k->getLatestPosts(1);$flag=true;}	
	if($options) {		
		if($flag){
			echo "<div id =\"kish_multi_wp_post_container_with_mod_links\">";//container open with mod links
			echo "<div id =\"kish_multi_wp_post_container\">";//container open			
			$firstPageMsg="<p><strong>Latest Post at ".$k->getTitle()."</strong></p>";
			foreach($options as $results):				
				$postid=$results['postid'];
				$cfields=$results['custom_fields'];
				foreach($cfields as $tnail):
					if($tnail['key']=='thumbnail') { $thumbnail = $tnail['value']; }
					if($tnail['key']=='views') { $views = " | ".$tnail['value']." Views"; }	
					if($tnail['key']=='_aioseop_title') { $aiotitle = $tnail['value']; }	
					if($tnail['key']=='_aioseop_keywords') { $aiokeywords = $tnail['value']; }		
					if($tnail['key']=='_aioseop_description') { $aiodescription = $tnail['value']; }					
				endforeach;
				if($results['post_status']=='pending'||$results['post_status']=='draft') {
					$class='kishpost_single_view_pend';
				}
				else {
					$class='kishpost_single_view_app';
				}
				echo "<div id=\"k-post-".$postid."\" style=\"border-bottom:1px solid #CACACA; padding:4px 2px 2px 2px;\">"; //k-post open
				echo "<div class=\"".$class."\">";//class open
				echo $firstPageMsg;				
				echo "<span><h2 id=\"kish_post_title\" >".$results['title']."</h2></span>";
				echo "<div id=\"kish_post_desc\">".$results['description']."</div>"; 
				$postdate=$results['dateCreated']; ?>
				<p><?php echo "<span style=\"margin-bottom:2px\"><strong><a target=\"_blank\" href=\"".$results['link']."\">Visit the Post Page</a></strong></span><br>";?></p>
				<?php
				echo "<p style=\"font-size:10px;font-weight:bold;\">Posted on - ".$postdate->day ."-".$postdate->month ."-".$postdate->year ."<span> | ".$results['post_status']." | Posted By - ".$results['wp_author_display_name'].$views."</span></p>";
				echo "</div>"; // 3 closed
				echo "</div>";//class closed
				echo "</div>";//container closed
				echo "<div style=\"font-size:11px;margin-top:5px;margin-bottom:5px\">"; //3open
				echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-post-prog-".$postid."\"></div>";
				echo "&nbsp;<input type=\"button\" value =\"Show Comments\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_wp_get_comment_for_post('".$postid."','k-post-prog-".$postid."','kish_multi_wp_this_post_comments')\">";
				echo "</div>"; //mod links
				kish_multi_wp_print_cross_posting_links($blogid, $postid);
				echo "</div>"; //posts with mod links
				
				echo "<div style=\"margin-top:5px\" id=\"kish_multi_wp_this_post_comments\"></div>";	
				echo "<div style=\"margin-top:5px\" id=\"kish_multi_wp_this_post_edit_msg\"></div>";
				echo "<div style=\"margin-top:5px\" id=\"kish_multi_wp_this_post_edit_form\"></div>";
			endforeach;
		}
		else {
		//print_r($options);
		$cfields=$options['custom_fields'];
		foreach($cfields as $tnail):
			if($tnail['key']=='thumbnail') { $thumbnail = $tnail['value']; }
			if($tnail['key']=='views') { $views = " | ".$tnail['value']." Views"; }	
			if($tnail['key']=='_aioseop_title') { $aiotitle = $tnail['value']; }	
			if($tnail['key']=='_aioseop_keywords') { $aiokeywords = $tnail['value']; }		
			if($tnail['key']=='_aioseop_description') { $aiodescription = $tnail['value']; }					
		endforeach;
		echo "<div id =\"kish_multi_wp_post_container_with_mod_links\">";//container open with mod links
		echo "<div id =\"kish_multi_wp_post_container\">"; //post container
		$postdate=$options['dateCreated'];
		$postid=$options['postid'];
		if($options['post_status']=='pending'||$options['post_status']=='draft') {
			$class='kishpost_pending';
		}
		else {
			$class='kishpost_approved';
		}
		echo "<div id=\"k-post-".$postid."\" style=\"border-bottom:1px solid #CACACA; padding:4px 2px 2px 2px;\">";
		echo "<div class=\"".$class."\">";
			
		echo "<span><h2 id=\"kish_post_title\" >".$options['title']."</h2></span>";
		echo "<div id=\"kish_post_desc\">".$options['description']."</div>"; 
		$postdate=$options['dateCreated'];
		echo "<p style=\"font-size:10px;font-weight:bold;\">Posted on - ".$postdate->day ."-".$postdate->month ."-".$postdate->year ."<span> | ".$options['post_status']." | Posted By - ".$options['wp_author_display_name'].$views."</span></p>";
		
		?>
		<div>
			<p><strong>Categorized Under :</strong>
			<?php
				$cats=$options['categories'];
					foreach($cats as $cat):
						$thiscat .= $cat. ", ";					
					endforeach;
				echo substr(trim($thiscat),0,-1);
				?>
			</p>
			<p><strong>Tagged :</strong>
			<?php echo $options['mt_keywords']; ?>
			</p>
			<p><?php echo "<span style=\"margin-bottom:2px\"><strong><a target=\"_blank\" href=\"".$options['link']."\">Visit the Post Page</a></strong></span><br>";?></p>
		</div>	
		<div>
			<strong>All in One SEO Settings</strong>
			<p>Title : <?php echo $aiotitle; ?></p>
			<p>KeyWords : <?php echo $aiokeywords; ?></p>
			<p>Meta Description : <?php echo $aiodescription; ?></p>
		</div>							
		<?php		
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "<div style=\"font-size:11px;margin-top:5px;margin-bottom:5px\">";
		echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-post-prog-".$postid."\"></div>";
		echo "&nbsp;<input type=\"button\" value =\"Show Comments\"  onclick=\"setSiteId('".$blogid."');kish_multi_wp_wp_get_comment_for_post('".$postid."','k-post-prog-".$postid."','kish_multi_wp_this_post_comments')\">";

		echo "</div>"; // post container
		kish_multi_wp_print_cross_posting_links($blogid, $postid);
		echo "</div>"; //posts with mod links
		if(function_exists('kish_twit_pro_print_search_box_below_post_kish_multi')) :
		?>
		<div align="center" style="height:25px;display:inline-block;width:455px">
		<?php
		kish_twit_pro_print_search_box_below_post_kish_multi($postid, $blogid);
		?>
		</div>
		<div>
			<?php 
				$msg=$options['title'];
				$msg.=" - ".$k->getUrl()."?p={$postid}";
			?>
			<?php kish_twit_pro_print_account_buttons(true, false); ?>
			<?php if(function_exists('kish_twit_pro_print_tweetthis_link_kish_multi')) :?>
			<span id="kish_multi_post_tweet"><?php kish_twit_pro_print_tweetthis_link_kish_multi(addslashes($msg), 'kish_multi_post_tweet', true); ?></span>
			<?php endif; ?>
		</div>
		<div id="ktp_cont_sr"></div>
		<?php endif;?>
		<?php 
		echo "<div id=\"kish_multi_wp_this_post_comments\"></div>";
		echo "<div id=\"kish_multi_wp_this_post_edit_msg\"></div>";
		return $options;		
		}
	}
}
function kish_multi_check_if_kish_twit_enabled() {
	if(function_exists('kish_twit_pro_print_search_box_below_post_kish_multi')) {
		echo 'true';
	}
	else {
		echo 'false';
	}
}
function kish_multi_wp_wp_get_comment_for_post($blogid, $postid) {
	$site=new kish_multi_wp();
	$site->load($blogid);
	$info=array('post_id'=>$postid);
	$options=$site->wp_get_comment_for_post($info);
	$msg="Sorry No Comments Yet...";
	if(empty($options)){echo "<p style=\"font-size:11px;color:#3A8C03\"><strong>".$msg."</strong></p>"; return;}
			if(strlen($status)) {
				echo "<p style=\"font-size:11px\"><strong>Comments from - <a href=\"".$site->getUrl()."\">".$site->getTitle()."</a></strong></p>";
			}
			echo "<div id=\"kish_multi_wp_latest_comments_".$site->getId()."\">";	
			foreach($options as $results):
				$gimg="http://www.gravatar.com/avatar/".md5($results['author_email']). ".jpg";	
				$results['status']=='hold' ? $class='kishcomment_pending' : $class='kishcomment_approved';
				$comid=$results['comment_id'];				
				echo "<div id=\"k-com-".$comid."\" style=\"border-bottom:1px solid #CACACA; padding:4px 2px 2px 2px;\">";
				echo "<div class=\"".$class."\">";
				echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-prog-".$comid."\"></div>";
				echo "<img style=\"float:left;margin-right:2px;border 1px solid\" src=\"".$gimg."\" width=\"40\" height=\"40\">";
				if(strlen($results['author_url'])) {
					echo "<span style=\"font-size:12px;font-weight:bold\"><a href=\"".$results['author_url']."\">".$results['author']."</a> on <a target=\"_blank\"href=\"".$site->getUrl()."/?p=".$results['post_id']."\">".$results['post_title']."</a></span><br>";
				}
				else {
					echo "<span style=\"font-size:12px;font-weight:bold\">".$results['author']." on <a target=\"_blank\"href=\"".$site->getUrl()."/?p=".$results['post_id']."\">".$results['post_title']."</a></span><br>";
				}
				echo "<p>".stripslashes($results['content'])."</p>";				
				echo "<div style=\"font-size:11px;margin:5px\">";
				echo "<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_del_comment('".$comid."','kish_multi_wp_prog_1','k-com-".$comid."');return false;\"><a href=\"#\">Delete</a></span>";
				if($results['status']=='hold'){
					echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','approve');return false;\"><a href=\"#\">Approve</a></span>";	
				}
				else {
					echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','hold');return false;\"><a href=\"#\">Pending</a></span>";
				}	
				echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','spam');return false;\"><a href=\"#\">Spam</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_reply_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_reply_form_email('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply Via Email</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_edit_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Edit</a></span>";
				echo "<div style=\"margin-top:3px\" id=\"k-com-reply-".$comid."\"></div>";		
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			endforeach;
	
}
function kish_multi_print_site_postview_links($removesiteid) {
	$site=new kish_multi_wp();
	$results=$site->getSavedSites();
	if ($results){
		echo "<div style=\"font-size:12px;margin-top:5px\">";
		echo "<h3>Other Connected Sites</h3>";
		foreach ($results as $result) :
			if($result->kish_multi_wp_id!=$removesiteid){
				echo "<li><span onclick=\"if(kish_multi_wp_checkmode('postView')) {setSiteId('".$result->kish_multi_wp_id."');kish_multi_wp_single_post('');return false;} else{return false;}\"><a href=\"#\">".$result->kish_multi_wp_blog_name."&nbsp;</a></span></li>";
			}
		endforeach;	
		echo "</div>";
	}	
}
function kish_multi_wp_get_latest_post_titles($blogid, $num){
	//$num=KISH_MULT_WP_NUMPOSTS_SIDEBAR;
	$counter=0;
	$k=new kish_multi_wp();
	$k->load($blogid);
	echo "<strong>Latest ".$num." posts from ".$k->getTitle()."</strong>";
	$options=$k->wp_get_recent_posts_titles($num);
	if($options) {
		//print_r($options);
		foreach($options as $results):			
			echo "<li><span onclick=\"if(kish_multi_wp_checkmode('postView')) {setSiteId('".$blogid."');kish_multi_wp_single_post_sidebar('".$results['postid']."', 'kish_multi_wp_single_post');return false;}else{return false;}\"><a href=\"#\">".$results['title']."&nbsp;</a></span></li>";
			$counter++;	
		endforeach;		
	}
	if($num<=$counter) {
		$next=$counter + KISH_MULT_WP_NUMPOSTS_SIDEBAR;
	?>
	<div style="height:20px;margin:2px">
		<div style="float:left" id="kish_multi_wp_post_titles_prog">			
		</div>
		<div style="float:right">
		<input class="button-secondary" type="button" name="Submit" value="Load more .." onclick = "kish_multi_wp_reloadsitebar('<?php echo $blogid; ?>','<?php echo $next; ?>', 'kish_multi_wp_post_titles_prog', 'kish_multi_wp_latest_post_titles'); ">	
		</div>
	</div>
	<?php
	}
	//kish_multi_print_site_postview_links($blogid);	
}
// USING THIS FUNCTION TO DISPLAY POST DURING EDIT AND POST MODE
function kish_multi_wp_get_latest_post_titles_edit_post_mode($blogid, $num){
	$counter=0;
	$k=new kish_multi_wp();
	$k->load($blogid);
	$options=$k->wp_get_recent_posts_titles($num);
	if($options) {
		echo "<strong>Latest ".$num." posts from ".$k->getTitle()."</strong>";
		//print_r($options);
		foreach($options as $results):			
			echo "<li><span onclick=\"kish_multi_wp_single_post_sidebar_edit_post_mode('".$blogid."','".$results['postid']."', 'kish_multi_wp_search_results');\"><a href=\"#kish_multi_wp_search_results_prog\">".$results['title']."&nbsp;</a></span></li>";
			$counter++;	
		endforeach;		
	}
	if($num<=$counter) {
		$next=$counter + KISH_MULT_WP_NUMPOSTS_SIDEBAR;
	?>
	<div style="height:20px;margin:2px">
		<div style="float:left" id="kish_multi_wp_post_titles_prog">			
		</div>
		<div style="float:right">
		<input class="button-secondary" type="button" name="Submit" value="Load more .." onclick = "kish_multi_wp_reloadsitebar('<?php echo $blogid; ?>','<?php echo $next; ?>', 'kish_multi_wp_post_titles_prog', 'kish_multi_wp_latest_post_titles'); ">	
		</div>
	</div>
	<?php
	}
	kish_multi_print_site_postview_links($blogid);	
}
function kish_multi_wp_print_site_change_links($blogid){
	$site=new kish_multi_wp();
	$results=$site->getSavedSites();
	if ($results){
		echo "<ul>";
		foreach ($results as $result) :			
			if($result->kish_multi_wp_id==$blogid){
				echo "<li><span style=\"font-weight:bold\"><a href=\"#\">".$result->kish_multi_wp_blog_name."</a></span><span style=\"font-size:10px\" onclick=\"kish_multi_wp_get_latest_posts('".$result->kish_multi_wp_id."', 10, 'kish_multi_wp_prog_1', 'kish_multi_wp_latest_post_titles');return false;\">&nbsp;<a href=\"#\">[Get Posts]</a></span></li>";
			}
			else {
				echo "<li><span onclick=\"setSiteId('".$result->kish_multi_wp_id."');kish_multi_wp_load_new_site_cats('kish_wp_site_cats', 'kish_multi_wp_prog_1');kish_multi_wp_reload_sidebar_site_details('kish_multi_wp_new_post_sidebar', 'kish_multi_wp_prog_1');return false;\"><a href=\"#\">".$result->kish_multi_wp_blog_name."</a></span><span style=\"font-size:10px\" onclick=\"kish_multi_wp_get_latest_posts('".$result->kish_multi_wp_id."', 10, 'kish_multi_wp_prog_1', 'kish_multi_wp_latest_post_titles');return false;\">&nbsp;<a href=\"#\">[Get Posts]</a></span></li>";
			}
			
			//echo "<input type=\"button\" value =\"".$result->kish_multi_wp_blog_name."\" onclick=\"kish_multi_wp_updateinfo('".$result->kish_multi_wp_id."');\">";
		endforeach;	
		echo "</ul>";
		?>
		<span onclick="kish_multi_wp_get_tags_edit_new_post('kish_multi_wp_new_post_tags_edit_new','kish_multi_wp_new_post_tags_edit_new');return false;"><a href="#">Get Tags</a></span>
		<div class="inside" id="kish_multi_wp_new_post_tags_edit_new" style="display:block;overflow:hidden;padding:5px">
		</div>
		<?php		
	}
}
function kish_multi_wp_print_cross_posting_links($blogid, $postid){
	$site=new kish_multi_wp();
	$results=$site->getSavedSites();
	if ($results){
		echo "<div style=\"border:1px solid #CACACA;padding:5px\">";
		echo "<div id=\"kish_multi_wp_prog_cross_post\" style=\"width:auto;height:30px;font-size:12px\"><strong>Click on the Links below for cross Posting..[<a target=\"_blank\" href=\"http://kishpress.com/blog/2010/05/30/increase-traffic-and-seo-by-crossposting/\">?</a>]</strong></div>";
		echo "<ul>";
		foreach ($results as $result) :			
			if($result->kish_multi_wp_id==$blogid){
				
			}
			else {
				echo "<span onclick=\"setSiteId('".$result->kish_multi_wp_id."');kish_multi_wp_new_post_crossposting('".$blogid."','".$postid."','kish_multi_wp_prog_cross_post', 'kish_multi_wp_prog_cross_post');return false;\"><a href=\"#\">".$result->kish_multi_wp_blog_name."</a></span>&nbsp;";
			}
			
			//echo "<input type=\"button\" value =\"".$result->kish_multi_wp_blog_name."\" onclick=\"kish_multi_wp_updateinfo('".$result->kish_multi_wp_id."');\">";
		endforeach;	
		echo "</ul>";
		echo "</div>";
	}
}

function kish_multi_wp_publish_crosspost($blogidtopublish, $postid, $postblogid) {
	$k=new kish_multi_wp();
	$k->load($postblogid);
	$site=new kish_multi_wp();
	$site->load($blogidtopublish);
	$options=$k->wp_get_post($postid);
	$title=$options['title'];
	$content=$options['description'];
	$content= strip_tags($content,'');
	$content=substr($content, 0,200);
	$footer="<p><strong>Post Source : </strong><a href=\"".$options['link']."\">".$options['title']."</a> from <a href=\"".$k->getUrl()."\">".$k->getTitle()."- ".$k->getDesc()."</a></p>";
	$status="publish";
	$content .=$footer;
	$categories=$options['categories'];
	$tags=$options['mt_keywords'];
	//print_r($categories);
	$postinfo=array('mt_keywords'=>$tags, 'categories'=>$categories, 'post_status'=>$status, 'title'=>$title,'description'=>$content);
	if($postid=$site->wp_new_post($postinfo)) {
		echo "Cross Posting Done..<a target=\"_blank\" href=\"".$site->getUrl()."?p=".$postid."\">View this post</a>";
	}
	else {echo "Error Cross Posting";}
}
function kish_multi_wp_print_single_post_layout($blogid, $postid, $num=50) {
	$k=new kish_multi_wp();
	$k->load($blogid);
	?>
	<div style="width:100%;display:block;overflow:hidden;padding:3px">
	<div style="clear:both;"></div>
	<div class="metabox-holder">
			<div class="postbox-container" style="width:29%;display:block;overflow:hidden;">
					<div class="postbox ">
						<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span>Latest <?php echo $num; ?> Posts from <?php echo $k->getTitle(); ?></span></h3>
						<div class="inside" id="kish_multi_wp_latest_post_titles" style="font-size:11px;display:block;overflow:hidden;padding:5px">
							<?php kish_multi_wp_get_latest_post_titles($blogid, $num); ?>
						</div>
					</div>
			</div>
		</div>
		<div class="metabox-holder" style="margin-top:-40px">
			<div class="postbox-container" style="width:69%;display:block;overflow:hidden;">
					<div class="postbox ">
						<div class="handlediv"><br></div><h3 class="hndle"><span>This Post is from <?php echo $k->getTitle(); ?></span></h3>
						<div class="inside" id="kish_multi_wp_single_post" style="font-size:11px;display:block;overflow:hidden;padding:5px">
							<?php kish_multi_wp_single_post($blogid, $postid); ?>
						</div>
					</div>
			</div>
		</div>
	</div>
	<?php
}
function kish_multi_wp_get_latest_posts($blogid, $num=10){
	$k=new kish_multi_wp();
	$k->load($blogid);
	$options=$k->getLatestPosts($num);
	foreach($options as $results):				
		$thumbnail='';
		$cfields=$results['custom_fields'];
		foreach($cfields as $tnail):
			if($tnail['key']=='thumbnail') { $thumbnail = $tnail['value']; }
			if($tnail['key']=='views') { $views = " | ".$tnail['value']." Views"; }					
		endforeach;
		$postid=$results['postid'];
		if($results['post_status']=='pending'||$results['post_status']=='draft') {
			$class='kishpost_pending';
		}
		else {
			$class='kishpost_approved';
		}
		$thumbnail=strlen($thumbnail) ? $thumbnail : kish_get_img_from_content($results['description']);
		echo "<div id=\"k-post-".$postid."\" style=\"border-bottom:1px solid #CACACA; padding:4px 2px 2px 2px;\">";
		echo "<div class=\"".$class."\">";
		echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-post-prog-".$postid."\"></div>";
		if(strlen($thumbnail)) {echo "<img style=\"float:left;margin-right:2px;border 1px solid\" height=\"48\" width=\"48\"src=\"".$thumbnail."\">";}
		echo "<span style=\"margin-bottom:2px\"><strong><a href=\"".$results['link']."\">".$results['title']."</a></strong></span><br>";
		echo substr(strip_tags($results['description']),0,280);
		echo "</p>";
		$postdate=$results['dateCreated'];
		echo "<p style=\"font-size:10px;font-weight:bold;\">Posted on - ".$postdate->day ."-".$postdate->month ."-".$postdate->year ."<span> | ".$results['post_status']." | Posted By - ".$results['wp_author_display_name'].$views."</span></p>";
		echo "<div style=\"font-size:11px;margin:5px\">";
		echo "<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_delete_post('".$postid."','k-post-prog-".$postid."','k-post-".$postid."');return false;\"><a href=\"#\">Delete</a></span>";
		if($results['post_status']=='pending'||$results['post_status']=='draft'){
			echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_post('".$postid."','k-post-prog-".$postid."','k-post-".$postid."','publish');return false;\"><a href=\"#\">Approve</a></span>";	
		}
		if($results['post_status']!='pending') {
			echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_post('".$postid."','k-post-prog-".$postid."','k-post-".$postid."','pending');return false;\"><a href=\"#\">Pending</a></span>";
		}	
		if($results['post_status']!='draft') {
			echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_post('".$postid."','k-post-prog-".$postid."','k-post-".$postid."','draft');return false;\"><a href=\"#\">Draft</a></span>";
		}
		echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_single_post('".$postid."')\"><a href=\"#\">View</a></span>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
	endforeach;
}

function kish_multi_wp_change_post_status($blogid, $postid, $status){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$options=$site->wp_get_post($postid);
	$editval=array('post_status'=>$status, 
			'title'=>$options['title'],
			'description'=>$options['description'],
			'categories'=>$options['categories']);
	if($site->wp_edit_post($postid, $editval)) {
		$results=$site->wp_get_post($postid);
		//print_r($results);
		$cfields=$results['custom_fields'];
		$thumbnail='';
		foreach($cfields as $tnail):
			if($tnail['key']=='thumbnail') { $thumbnail = $tnail['value']; }	
			if($tnail['key']=='views') { $views = $tnail['value']." Views"; }				
		endforeach;
		$postid=$results['postid'];
		if($results['post_status']=='pending'||$results['post_status']=='draft') {
			$class='kishpost_pending';
		}
		else {
			$class='kishpost_approved';
		}
		echo "<div id=\"kish_multi_wp_latest_posts_".$site->getId()."\">";
		echo "<div id=\"k-post-".$postid."\" style=\"border-bottom:1px solid #CACACA;\">";
		echo "<div class=\"".$class."\">";
		echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-post-prog-".$postid."\"></div>";
		if(strlen($thumbnail)) {echo "<img style=\"float:left;margin-right:2px;border 1px solid\" height=\"48\" width=\"48\"src=\"".$thumbnail."\">";}
		echo "<span style=\"margin-bottom:2px\"><strong><a href=\"".$results['link']."\">".$results['title']."</a></strong></span><br>";
		echo substr(strip_tags($results['description']),0,280);
		echo "</p>";
		$postdate=$results['dateCreated'];
		echo "<p style=\"font-size:10px;font-weight:bold;\">Posted on - ".$postdate->day ."-".$postdate->month ."-".$postdate->year ."<span> | ".$results['post_status']." | Posted By - ".$results['wp_author_display_name'].$views."</span></p>";
		echo "<div style=\"font-size:11px;margin:5px\">";
		echo "<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_delete_post('".$postid."','k-post-prog-".$postid."','k-post-".$postid."');return false;\"><a href=\"#\">Delete</a></span>";
		if($results['post_status']=='pending'||$results['post_status']=='draft'){
			echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_post('".$postid."','k-post-prog-".$postid."','k-post-".$postid."','publish');return false;\"><a href=\"#\">Approve</a></span>";	
		}
		if($results['post_status']!='pending') {
			echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_post('".$postid."','k-post-prog-".$postid."','k-post-".$postid."','pending');return false;\"><a href=\"#\">Pending</a></span>";
		}	
		if($results['post_status']!='draft') {
			echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_post('".$postid."','k-post-prog-".$postid."','k-post-".$postid."','draft');return false;\"><a href=\"#\">Draft</a></span>";
		}
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
	}
}
function kish_multi_wp_delete_post($blogid, $postid) {
	$site=new kish_multi_wp();
	$site->load($blogid);
	$site->delPost($postid);
}
function kish_multi_wp_get_blog_get_comments($blogid, $status="", $num=10, $offset=0){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$options=$site->wp_get_comments($status, $num, $offset);
	switch ($status) {
		case 'hold' :
			$msg = "No Pending Comments - Check Later | ".$site->getTitle();
			break;
		case 'publish' :
			$msg = "No published Comments";
			break;
		case 'spam' :
			$msg = "No Spam Comments";
			break;
		default :
			$msg = "No Comments on this site!! Very Bad";
	}
	if(empty($options)){echo "<p style=\"margin-left:5px;font-size:11px;color:#3A8C03\"><strong>".$msg."</strong></p>"; return;}
			if(strlen($status)) {
				echo "<p style=\"font-size:11px\"><strong>Comments from - <a href=\"".$site->getUrl()."\">".$site->getTitle()."</a></strong></p>";
			}
			$counter=0;
			echo "<div id=\"kish_multi_wp_latest_comments_".$site->getId()."\">";	
			foreach($options as $results):
				$gimg="http://www.gravatar.com/avatar/".md5($results['author_email']). ".jpg";	
				$results['status']=='hold' ? $class='kishcomment_pending' : $class='kishcomment_approved';
				$comid=$results['comment_id'];				
				echo "<div id=\"k-com-".$comid."\" style=\"border-bottom:1px solid #CACACA; padding:4px 2px 2px 2px;\">";
				echo "<div class=\"".$class."\">";
				echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-prog-".$comid."\"></div>";
				echo "<img style=\"float:left;margin-right:2px;border 1px solid\" src=\"".$gimg."\" width=\"40\" height=\"40\">";
				if(strlen($results['author_url'])) {
					echo "<span style=\"font-size:12px;font-weight:bold\"><a href=\"".$results['author_url']."\">".$results['author']."</a> on <a target=\"_blank\"href=\"".$site->getUrl()."/?p=".$results['post_id']."\">".$results['post_title']."</a></span><br>";
				}
				else {
					echo "<span style=\"font-size:12px;font-weight:bold\">".$results['author']." on <a target=\"_blank\"href=\"".$site->getUrl()."/?p=".$results['post_id']."\">".$results['post_title']."</a></span><br>";
				}
				echo "<p>".stripcslashes($results['content'])."</p>";				
				echo "<div style=\"font-size:11px;margin:5px\">";
				echo "<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_del_comment('".$comid."','kish_multi_wp_prog_1','k-com-".$comid."');return false;\"><a href=\"#\">Delete</a></span>";
				if($results['status']=='hold'){
					echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','approve');return false;\"><a href=\"#\">Approve</a></span>";	
				}
				else {
					echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','hold');return false;\"><a href=\"#\">Pending</a></span>";
				}	
				echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','spam');return false;\"><a href=\"#\">Spam</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_reply_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_reply_form_email('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply Via Email</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_edit_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Edit</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px;color:#CACACA\">".$results['date_created_gmt']->day."-".$results['date_created_gmt']->month."-".$results['date_created_gmt']->year."</span>";
				echo "<div style=\"margin-top:3px\" id=\"k-com-reply-".$comid."\"></div>";		
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				$counter++;
			endforeach;
			if($counter==$num) {
				$divid=$counter+$offset;
				?>
				<div style="min-height:35px;display:block;margin-top:5px" id="com_loadmore_<?php echo $divid; ?>">
					<input class="button-secondary" type="button" name="loadmore" value="Load More &raquo;" onclick = "kish_wp_showprogress('com_loadmore_<?php echo $divid; ?>', '', loader3);kish_multi_wp_get_comments('com_loadmore_<?php echo $divid; ?>','', 10, <?php echo $divid;?>); ">
				</div>	
				<?php
			}
}
function kish_multi_wp_get_blog_get_all_comments_post($blogid, $info_struct){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$options=$site->wp_get_comment_for_post($info_struct);
	switch ($status) {
		case 'hold' :
			$msg = "No Pending Comments - Check Later | ".$site->getTitle();
			break;
		case 'publish' :
			$msg = "No published Comments";
			break;
		case 'spam' :
			$msg = "No Spam Comments";
			break;
		default :
			$msg = "No Comments on this site!! Very Bad";
	}
	if(empty($options)){echo "<p style=\"margin-left:5px;font-size:11px;color:#3A8C03\"><strong>".$msg."</strong></p>"; return;}
			if(strlen($status)) {
				echo "<p style=\"font-size:11px\"><strong>Comments from - <a href=\"".$site->getUrl()."\">".$site->getTitle()."</a></strong></p>";
			}
			echo "<div id=\"kish_multi_wp_latest_comments_".$site->getId()."\">";	
			foreach($options as $results):
				$gimg = get_avatar( $results['author_email'], '40');
				$gimg="http://www.gravatar.com/avatar/".md5($results['author_email']). ".jpg";	
				$results['status']=='hold' ? $class='kishcomment_pending' : $class='kishcomment_approved';
				$comid=$results['comment_id'];				
				echo "<div id=\"k-com-".$comid."\" style=\"border-bottom:1px solid #CACACA; padding:4px 2px 2px 2px;\">";
				echo "<div class=\"".$class."\">";
				echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-prog-".$comid."\"></div>";
				echo "<img style=\"float:left;margin-right:2px;border 1px solid\" src=\"".$gimg."\" width=\"40\" height=\"40\">";
				if(strlen($results['author_url'])) {
					echo "<span style=\"font-size:12px;font-weight:bold\"><a href=\"".$results['author_url']."\">".$results['author']."</a> on <a target=\"_blank\"href=\"".$site->getUrl()."/?p=".$results['post_id']."\">".$results['post_title']."</a></span><br>";
				}
				else {
					echo "<span style=\"font-size:12px;font-weight:bold\">".$results['author']." on <a target=\"_blank\"href=\"".$thisblogurl."/?p=".$results['post_id']."\">".$results['post_title']."</a></span><br>";
				}
				echo "<p>".stripcslashes($results['content'])."</p>";				
				echo "<div style=\"font-size:11px;margin:5px\">";
				echo "<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_del_comment('".$comid."','kish_multi_wp_prog_1','k-com-".$comid."');return false;\"><a href=\"#\">Delete</a></span>";
				if($results['status']=='hold'){
					echo "&nbsp;<span onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','approve');return false;\"><a href=\"#\">Approve</a></span>";	
				}
				else {
					echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','hold');return false;\"><a href=\"#\">Pending</a></span>";
				}	
				echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','spam');return false;\"><a href=\"#\">Spam</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_reply_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply</a></span>";
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_reply_form_email('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply Via Email</a></span>"; 
				echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_edit_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Edit</a></span>";				
				echo "<div style=\"margin-top:3px\" id=\"k-com-reply-".$comid."\"></div>";		
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			endforeach;
}

function kish_multi_wp_print_comment_reply_form($blogid, $comid) {
	?>
	<textarea style="width:100%" id="kish_multi_wp_reply_comment_<?php echo $comid; ?>" rows="10" cols="85%"></textarea><br>
	<input type="button" value="Submit" onclick="setSiteId('<?php echo $blogid; ?>');kish_multi_reply_comment('<?php echo $comid; ?>','k-prog-save-<?php echo $comid; ?>','kish_multi_wp_latest_comments_<?php echo $blogid;?>')">
	<input type="button" value="Cancel" onclick="kish_wp_multi_clear('k-com-reply-<?php echo $comid; ?>')">
	<?php
	echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-prog-save-".$comid."\"></div>";
}
function kish_multi_wp_print_comment_reply_form_email($blogid, $comid) {
	?>
	<textarea style="width:100%" id="kish_multi_wp_reply_comment_email_<?php echo $comid; ?>" rows="10" cols="85%"></textarea><br>
	<input type="button" value="Reply Via Email" onclick="setSiteId('<?php echo $blogid; ?>');kish_multi_reply_comment_email('<?php echo $comid; ?>','k-prog-save-<?php echo $comid; ?>','k-com-reply-<?php echo $comid;?>')">
	<input type="button" value="Cancel" onclick="kish_wp_multi_clear('k-com-reply-<?php echo $comid; ?>')">
	<?php
	echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-prog-save-".$comid."\"></div>";
}
function kish_multi_wp_print_comment_edit_form($blogid, $comid) {
	$site=new kish_multi_wp();
	$site->load($blogid);
	$options=$site->wp_get_comment($comid);
	?>
	<textarea style="font-size:11px;width:100%" id="kish_multi_wp_com_edit_<?php echo $comid; ?>" rows="10" cols="85%"><?php echo stripslashes($options['content']); ?></textarea><br>
	<input type="button" value="Save" onclick="setSiteId('<?php echo $blogid; ?>');kish_multi_wp_edit_comment('<?php echo $comid; ?>','k-prog-save-<?php echo $comid; ?>','k-com-<?php echo $comid;?>')">
	<input type="button" value="Cancel" onclick="kish_wp_multi_clear('k-com-reply-<?php echo $comid; ?>')">
	<?php
	echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-prog-save-".$comid."\"></div>";
}
function kish_multi_reply_comment($blogid, $comid, $comtext){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$options=$site->wp_get_comment($comid);
	$cominfo=array('comment_parent'=>$comid, 'content'=>$comtext);
	if($site->wp_new_comment($options['post_id'], $cominfo)) {echo "Comment Posted Successfully"; return true;}
	if(KISH_MULT_WP_EMAIL_REPLY) {
		$authoremail=$options['author_email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: '.$options['author'].' <'.$options['author_email'].'>' . "\r\n";
		$headers .= 'From: '.$site->getTitle().' <'.get_option('admin_email').'>' . "\r\n";
		$subject=$options['post_title']." - Personal Reply";	
		$content .="Hi ".$options['author']."<br><br>";
		$content .= "In response to your comment : ".$options['link']."<br><br>";
		$content .=$comtext;
		$content .="<br />Cheers<br />";
		$content .="<a href =\"".$site->getUrl()."\">".$site->getTitle()."</a><br><br>";
		$content .="Email Replying done by <a href=\".http://www.kisaso.com/technology/\">Kishore's Multi Wordpress Managing Plugin</a>";
		//echo $content;
		//print_r($options);
		if(wp_mail($authoremail, $subject, $content, $headers)) {
			echo "Reply Sent Succesfully to ". $authoremail."\n";
			echo "<pre>".$content."</pre>";
		}
		else {echo "Error sending email !!!";}
	}
}
function kish_multi_reply_comment_email($blogid, $comid, $comtext){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$options=$site->wp_get_comment($comid);
	$authoremail=$options['author_email'];
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'To: '.$options['author'].' <'.$options['author_email'].'>' . "\r\n";
	$headers .= 'From: '.$site->getTitle().' <'.get_option('admin_email').'>' . "\r\n";
	$subject=$options['post_title']." - Personal Reply";	
	$content .="Hi ".$options['author']."<br><br>";
	$content .= "In response to your comment : ".$options['link']."<br><br>";
	$content .=$comtext;
	$content .="<br />Cheers<br />";
	$content .="<a href =\"".$site->getUrl()."\">".$site->getTitle()."</a><br><br>";
	$content .="Email Replying done by <a href=\".http://www.kisaso.com/technology/\">Kishore's Multi Wordpress Managing Plugin</a>";
	//echo $content;
	//print_r($options);
	if(wp_mail($authoremail, $subject, $content, $headers)) {
		echo "Reply Sent Succesfully to ". $authoremail."\n";
		echo "<pre>".$content."</pre>";
	}
	else {echo "Error sending email !!!";}
	//$cominfo=array('comment_parent'=>$options['parent'], 'content'=>$comtext);
	//if($site->wp_new_comment($options['post_id'], $cominfo)) {echo "Comment Posted Successfully"; return true;}
}
function kish_multi_wp_get_comment_status_list($url, $username, $pw) {
	substr($url, -1)=='/' ? $url .="xmlrpc.php" : $url.="/xmlrpc.php";
	include_once('class-IXR.php');
	if($kish_multi_wp_client = new IXR_Client($url)) {
		if($kish_multi_wp_client->query('wp.getCommentStatusList', 0, $username, $pw)) {
			$options = $kish_multi_wp_client->getResponse();
			print_r($options);
		}
	}
}
function kish_multi_wp_get_blog_single_comment_moderate($blogid, $comid, $status){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$options=$site->wp_get_comment($comid);
	$cominfo=array('status'=>$status, 'date_created_gmt'=>"",
			'content'=>$options['content'],
			'author'=>$options['author'],
			'author_url'=>$options['author_url'],
			'author_email'=>$options['author_email']);
	if($site->wp_edit_comment($comid, $cominfo)) {
		$options=$site->wp_get_comment($comid);
		$gimg="http://www.gravatar.com/avatar/".md5($options['author_email']). ".jpg";	
		$options['status']=='hold' ? $class='kishcomment_pending' : $class='kishcomment_approved';	
		echo "<div class=\"".$class."\">";
		echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-prog-".$comid."\"></div>";
		echo "<img style=\"float:left;margin-right:2px;border 1px solid\" src=\"".$gimg."\" width=\"40\" height=\"40\">";
		if(strlen($options['author_url'])) {
			echo "<span style=\"font-size:12px;font-weight:bold\"><a href=\"".$options['author_url']."\">".$options['author']."</a> on <a target=\"_blank\"href=\"".$site->getUrl()."/?p=".$options['post_id']."\">".$options['post_title']."</a></span><br>";
		}
		else {
			echo "<span style=\"font-size:12px;font-weight:bold\">".$options['author']." on <a target=\"_blank\"href=\"".$site->getUrl()."/?p=".$options['post_id']."\">".$options['post_title']."</a></span><br>";
		}
		//echo "<span style=\"font-size:12px;font-weight:bold\"><a href=\"".$options['author_url']."\">".$options['author']."</a> on <a target=\"_blank\"href=\"".$site->getUrl()."/?p=".$options['post_id']."\">".$options['post_title']."</a></span><br>";
		echo "<p>".stripcslashes($options['content'])."</p>";			
		echo "<div style=\"font-size:11px;margin:5px\">";
		echo "<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_del_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."');return false;\"><a href=\"#\">Delete</a></span>";
		if($options['status']=='hold'){
			echo "&nbsp;<span onclick=\"kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','approve');return false;\"><a href=\"#\">Approve</a></span>";	
		}
		else {
			echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','hold');return false;\"><a href=\"#\">Pending</a></span>";
		}	
		echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','spam');return false;\"><a href=\"#\">Spam</a></span>";
		echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_print_comment_reply_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply</a></span>";
		echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_reply_form_email('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply Via Email</a></span>"; 
		echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_edit_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Edit</a></span>";
		echo "<div style=\"margin-top:3px\" id=\"k-com-reply-".$comid."\"></div>";	
		echo "</div>";	
		echo "</div>";
		//echo "</div>";
	}
	else {echo "Unable to edit the comment"; return false;}
}
function kish_multi_wp_edit_comment($blogid, $comid, $content){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$options=$site->wp_get_comment($comid);
	$cominfo=array('date_created_gmt'=>"",
			'content'=>stripslashes($content),
			'author'=>$options['author'],
			'author_url'=>$options['author_url'],
			'author_email'=>$options['author_email']);
	if($site->wp_edit_comment($comid, $cominfo)) {
		$options=$site->wp_get_comment($comid);
		$gimg="http://www.gravatar.com/avatar/".md5($results['author_email']). ".jpg";	
		$options['status']=='hold' ? $class='kishcomment_pending' : $class='kishcomment_approved';	
		echo "<div class=\"".$class."\">";
		echo "<div style=\"float:right;height:20px;width:20px\" id=\"k-prog-".$comid."\"></div>";
		echo "<img style=\"float:left;margin-right:2px;border 1px solid\" src=\"".$gimg."\" width=\"40\" height=\"40\">";
		echo "<span style=\"font-size:12px;font-weight:bold\"><a href=\"".$options['author_url']."\">".$options['author']."</a> on <a target=\"_blank\"href=\"".$thisblogurl."/?p=".$options['post_id']."\">".$options['post_title']."</a></span><br>";
		echo "<p>".stripcslashes($options['content'])."</p>";			
		echo "<div style=\"font-size:11px;margin:5px\">";
		echo "<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_del_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."');return false;\"><a href=\"#\">Delete</a></span>";
		if($options['status']=='hold'){
			echo "&nbsp;<span onclick=\"kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','approve');return false;\"><a href=\"#\">Approve</a></span>";	
		}
		else {
			echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','hold');return false;\"><a href=\"#\">Pending</a></span>";
		}	
		echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_moderate_comment('".$comid."','k-prog-".$comid."','k-com-".$comid."','spam');return false;\"><a href=\"#\">Spam</a></span>";
		echo "&nbsp;<span style=\"font-size:11px;padding-right:5px\" onclick=\"kish_multi_wp_print_comment_reply_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply</a></span>";
		echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_reply_form_email('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Reply Via Email</a></span>"; 
		echo "&nbsp;<span style=\"font-size:11px;margin-top:5px;padding-right:5px\" onclick=\"setSiteId('".$blogid."');kish_multi_wp_print_comment_edit_form('".$comid."','k-prog-".$comid."','k-com-reply-".$comid."');return false;\"><a href=\"#\">Edit</a></span>";
		echo "<div style=\"margin-top:3px\" id=\"k-com-reply-".$comid."\"></div>";	
		echo "</div>";	
		echo "</div>";
		//echo "</div>";
	}
	else {echo "Unable to edit the comment"; return false;}
}
function kish_multi_wp_get_blog_del_comment($blogid, $comid){
	$site=new kish_multi_wp();
	$site->load($blogid);
	if($site->wp_delete_comment($comid)) {
		return true;
	}
	else {echo "Error Deleting comment"; return false;}
}
function kish_multi_wp_get_blog_get_tags($blogid){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$data=$site->get_tags();
	foreach ($data as $key => $row) {
		$name[$key]  = $row['name'];
		$count[$key] = $row['count'];
		$html_url[$key] = $row['html_url'];
	}
	if(is_array($count)){array_multisort($count, SORT_DESC, $data);}
	echo "<h4>You have ".count($data)." tags on your blog</h4>";
	$maxcounttag = $data[0]['count'];
	echo "The biggest tag count is for ".$data[0]['name']." which is ".$maxcounttag."<br>";
	$highestfontsize=36;
	$counter=1;
	echo "<div style=\"max-width:33%; display:inline;overflow:hidden\">";
	foreach ($data as $result) :
		if($counter==50){return;}	
		$tagcount=$result['count'];
		$fontsize=($highestfontsize*$tagcount)/$maxcounttag;
		if($fontsize<=8){$fontsize=8;}
		echo "<a style=\"font-size:".$fontsize."px\" target=\"_blank\" href=\"".$result['html_url']."\">".$result['name']."</a>&nbsp;";
		$counter++;
	endforeach;
	echo "</div>";
}
function kish_multi_wp_get_blog_get_tags_for_post($blogid){
	$site=new kish_multi_wp();
	$site->load($blogid);
	$data=$site->get_tags();
	foreach ($data as $key => $row) {
		$name[$key]  = $row['name'];
		$count[$key] = $row['count'];
		$html_url[$key] = $row['html_url'];
	}
	if(is_array($count)){array_multisort($count, SORT_DESC, $data);}
	echo "<h4>You have ".count($data)." tags on your blog</h4>";
	$maxcounttag = $data[0]['count'];
	echo "The biggest tag count is for ".$data[0]['name']." which is ".$maxcounttag."<br>";
	$highestfontsize=36;
	$counter=1;
	echo "<div style=\display:inline\">";
	foreach ($data as $result) :
		if($counter==50){return;}	
		$tagcount=$result['count'];
		$fontsize=($highestfontsize*$tagcount)/$maxcounttag;
		if($fontsize<=8){$fontsize=8;}
		echo "<span style=\"padding:3px\" onclick=\"kish_multi_wp_add_remove_cats('".$result['name']."');return false;\"><a style=\"font-size:".$fontsize."px\" href=\"#\">".$result['name']."</a></span>";
		$counter++;
	endforeach;
	echo "</div>";
}
function kish_wp_multi_get_site_info_db($siteid){
	$kish=new kish_multi_wp();
	return $kish->getSiteFromDb($siteid);
}
function kish_wp_multi_save_site($blogurl, $username, $password) {
	$k=new kish_multi_wp($blogurl, $username, stripslashes($password),'','');
	if($k->save()) {
		echo $k;
		$k->getSiteInfoFromUrl($blogurl);
		$siteid=$k->getId();
		echo "<input id=\"kish_latest_site_id\" type=\"hidden\" value=\"".$siteid."\">";
	}
	else {
		//echo $k->getPassWord();
	}
}
function kish_wp_multi_update_site($blogid, $blogurl, $username, $password) {
	$site = new kish_multi_wp();
	$site->load($blogid);
	$site->setUrl($blogurl);
	$site->setUname($username);
	$site->setPassword($password);
	if($site->getBlogInfo()) {
		if($site->update()) {echo "Site Updated : ".$site->getTitle();}
		else {echo "Error Updating the site";}
	}
	else {echo "There is something wrong in your login details"; return false;}
}
function kish_wp_multi_get_site_options($blogid) {
	echo "Blog id is ".$blogid;
	$site=new kish_multi_wp;
	$site->load($blogid);
	$options=$site->getBlogOptions($blogid);
	print_r($options);
}
function kish_wp_multi_delete_site($blogid) {
	$site=new kish_multi_wp;
	$site->deleteSite($blogid);
	if($blogid==KISH_MULT_WP_DEFAULT_SITE) {
		kish_set_default_blog(kish_multi_get_first_site_id());
	}
}
function kish_multi_check_default_blog() {
	if(strlen(KISH_MULT_WP_DEFAULT_SITE)) {
		$strsites=kish_multi_get_site_id_to_array();
		$arrsites=explode(",",$strsites);
		if (!in_array(KISH_MULT_WP_DEFAULT_SITE, $arrsites)) {
			kish_set_default_blog(kish_multi_get_first_site_id());
		}
	}
}
function kish_multi_wp_check_site_already_added($url){
	$site=new kish_multi_wp;
}
function kish_multi_wp_get_latest_posts_front_end_all($num=3) {
//echo "I am in";
	$kish=new kish_multi_wp();
	$results=$kish->getSavedSites();
	if ($results){
		foreach ($results as $result) :
			$blogid=$result->kish_multi_wp_id;
			$kish->load($blogid);	
			?>
			<?php echo "<h2><a title=\"".$kish->getDesc()."\" href=\"".$kish->getURL()."\">Latest Posts for ".$kish->getTitle()."</a></h2>";?>
            <?php echo "<strong><p>".$kish->getDesc()."</p></strong>"; ?>
				<div style="padding:5px;margin:3px 0px 2px 0px; border-bottom:2px solid #CACACA">					
				<?php kish_multi_get_posts_front_end($blogid, $num); ?>
				</div>				
			<?php
		endforeach;	
		echo "<p>This Page is generated using <a href=\"http://www.kisaso.com/technology/wordpress-plugin-to-manage-multiple-blogs-initial-version-released/\">Multiple Blog Managing Plugin</a> by <a href=\"http://www.asokans.com\">Kishore Asokan</a></p>";
	}
	
}
function kish_multi_get_posts_front_end($blogid, $num) {
	$k=new kish_multi_wp();
	$k->load($blogid);
	$options=$k->getLatestPosts($num);
		foreach($options as $results):				
			$thumbnail='';
			$cfields=$results['custom_fields'];
			foreach($cfields as $tnail):
				if($tnail['key']=='thumbnail') { $thumbnail = $tnail['value']; }
				if($tnail['key']=='views') { $views = " | ".$tnail['value']." Views"; }					
			endforeach;
			$postid=$results['postid'];
			echo "<h3><a target=\"_blank\" href=\"".$results['link']."\">".$results['title']."</a></h3>";
			if(strlen($thumbnail)) {echo "<p><img style=\"float:left;margin-right:2px;border 1px solid\" height=\"48\" width=\"48\"src=\"".$thumbnail."\">";}
			
			echo substr(strip_tags($results['description']),0,350).".. <a target=\"_blank\" href=\"".$results['link']."\">Read More..</a>";
			echo "</p>";
			$postdate=$results['dateCreated'];
			echo "<p class=\"post_date\" style=\"font-size:10px;font-weight:bold;\">Posted on - ".$postdate->day ."-".$postdate->month ."-".$postdate->year ."<span> | Posted By - ".$results['wp_author_display_name'].$views."</span></p>";
			
			endforeach;
}
function kish_clean_text($str) {
	$str=str_replace("'", "##", $str);
	$str=str_replace('"', "###", $str);
	return $str;
}
?>