<?php
/*
Plugin Name: Kish Manage Multiple Wordpress
Plugin URI: http://www.kisaso.com/technology/wordpress-plugin-to-manage-multiple-blogs-initial-version-released/
Description: This plugin is used to manage multiple blogs from a single blog.
Version:2.1
Author: Kishore Asokan
Author URI: http://www.kisaso.com 
*/

/*  Copyright 2008  Kishore Asokan  (email : kishore@asokans.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
$kroot = str_replace("\\", "/", dirname(__FILE__));
global $kish_multi_wp_client, $kish_multi_wp_site, $globedival, $globalsite;
global $thisblogid, $thisblogname, $thisblogdesc, $thisblogurl, $thisbloguname, $thisblogpw;
include_once($kroot.'/functions.php');

if($_POST['req']) {
	if($_POST['req']=='getmetadetails') {
		kish_multi_wp_geturldetails($_POST['url']); 
	}
	else if($_POST['req']=='updatesiteoption') {
		kish_set_default_blog($_POST['siteid']);
	}
	else if($_POST['req']=='newhome') {
		kish_multi_wp_print_homepage_structure(); 
	}
	else if($_POST['req']=='shownewsiteform') {
		kish_multi_wp_add_site_page($_POST['id']); 
	}
	else if($_POST['req']=='updatetitle') {
		kish_multi_wp_site_title_print($_POST['siteid']); 
	}
	else if($_POST['req']=='showsidebar') {
		kish_wp_multi_display_saved_sites();
	}
	else if($_POST['req']=='savesite') {
		kish_wp_multi_save_site($_POST['b'], $_POST['u'], $_POST['p']); 
	}
	else if($_POST['req']=='siteoptionspage') {
		kish_wp_multi_get_site_options($_POST['siteid']); 
	}
	else if($_POST['req']=='updatesite') {
		kish_wp_multi_update_site($_POST['siteid'],$_POST['b'], $_POST['u'], $_POST['p']); 
	}
	else if($_POST['req']=='deletesite') {
		kish_wp_multi_delete_site($_POST['siteid']); 
	}
	else if($_POST['req']=='poststatus') {
		kish_multi_wp_get_latest_posts($_POST['siteid'], KISH_MULT_WP_MAX_POSTS);
	}
	else if($_POST['req']=='getcomments') {
		kish_multi_wp_get_blog_get_comments($_POST['siteid'],$_POST['status'], $_POST['num'], $_POST['offset']);
	}
	else if($_POST['req']=='gettags') {
		kish_multi_wp_get_blog_get_tags($_POST['id']);
	}
	else if($_POST['req']=='gettagseditnew') {
		kish_multi_wp_get_blog_get_tags_for_post($_POST['siteid']);
	}
	else if($_POST['req']=='getblogsettings') {
		kish_multi_wp_get_blog_info($_POST['siteid']);
	}
	else if($_POST['req']=='delcomments') {
		kish_multi_wp_get_blog_del_comment($_POST['siteid'], $_POST['comid']);
	}
	else if($_POST['req']=='modcom') {
		kish_multi_wp_get_blog_single_comment_moderate($_POST['siteid'], $_POST['comid'], $_POST['status']);
	}
	else if($_POST['req']=='editcomment') {
		kish_multi_wp_edit_comment($_POST['siteid'], $_POST['comid'], $_POST['content']);
	}
	else if($_POST['req']=='showcomform') {
		kish_multi_wp_print_comment_reply_form($_POST['siteid'],$_POST['comid']);
	}
	else if($_POST['req']=='showcomformemail') {
		kish_multi_wp_print_comment_reply_form_email($_POST['siteid'],$_POST['comid']);
	}
	else if($_POST['req']=='showcomeditform') {
		kish_multi_wp_print_comment_edit_form($_POST['siteid'],$_POST['comid']);
	}
	else if($_POST['req']=='singlepost') {
		kish_multi_wp_print_single_post_layout($_POST['siteid'],$_POST['postid']);
	}
	else if($_POST['req']=='loadnewsitecats') {
		kish_multi_wp_print_site_categories($_POST['siteid']);
	}
	else if($_POST['req']=='reloadsitessidebar') {
		kish_multi_wp_print_site_change_links($_POST['siteid']);
	}
	else if($_POST['req']=='singlepostsidebar') {
		kish_multi_wp_single_post($_POST['siteid'],$_POST['postid']);
	}
	else if($_POST['req']=='singleposteditpostnewpost') {
		kish_multi_wp_single_post_print_without_links($_POST['siteid'],$_POST['postid']);
	}
	else if($_POST['req']=='reloadsidebar') {
		kish_multi_wp_get_latest_post_titles($_POST['siteid'],$_POST['num']);
	}
	else if($_POST['req']=='reloadsidebareditpostnewpost') {
		kish_multi_wp_get_latest_post_titles_edit_post_mode($_POST['siteid'],$_POST['num']);
	}
	else if($_POST['req']=='search') {
		kish_multi_wp_rss_search($_POST['keywords']);
	}
	else if($_POST['req']=='twittersearch') {
		if(function_exists('kish_twitter_search')) { kish_twitter_search($_POST['keywords']); }
	}
	else if($_POST['req']=='updatepost') {
		kish_multi_wp_update_post($_POST['siteid'],$_POST['postid'], stripslashes($_POST['title']), stripslashes($_POST['content']), $_POST['status'],stripslashes($_POST['category']), stripslashes($_POST['tags']), stripslashes($_POST['aiotitle']), stripslashes($_POST['aiokeywords']), stripslashes($_POST['aiodesc']), stripslashes($_POST['video']), $_POST['pubdate']);
	}
	else if($_POST['req']=='savenewpost') {
		kish_multi_wp_publish_new_post($_POST['siteid'], stripslashes($_POST['title']), stripslashes($_POST['content']), $_POST['status'],stripslashes($_POST['category']), stripslashes($_POST['tags']), stripslashes($_POST['aiotitle']), stripslashes($_POST['aiokeywords']), stripslashes($_POST['aiodesc']), stripslashes($_POST['video']), $_POST['pubdate']);
	}
	else if($_POST['req']=='crossposting') {
		kish_multi_wp_publish_crosspost($_POST['blogidtopublish'],$_POST['postid'],$_POST['postblogid'] );
	}
	else if($_POST['req']=='uploadimagefromurlnextstep') {
		kish_multi_copy_image_from_url_to_server_step_two($_POST['siteid'], $_POST['imgurl']);	
	}
	else if($_POST['req']=='uploadimagefile') {
		kish_multi_upload_image_to_server($_FILES["file"],$_POST['siteid']);	
	}
	else if($_POST['req']=='showcomments') {
		kish_multi_wp_wp_get_comment_for_post($_POST['siteid'],$_POST['postid']);
	}
	else if($_POST['req']=='replycom') {
		kish_multi_reply_comment($_POST['siteid'], $_POST['comid'],$_POST['comtext']);
	}
	else if($_POST['req']=='replycomemail') {
		kish_multi_reply_comment_email($_POST['siteid'], $_POST['comid'],$_POST['comtext']);
	}
	else if($_POST['req']=='modpost') {
		kish_multi_wp_change_post_status($_POST['id'],$_POST['postid'], $_POST['status']);
	}
	else if($_POST['req']=='editpost') {
		kish_multi_wp_change_post_status($_POST['id'],$_POST['postid'], $_POST['status']);
	}
	else if($_POST['req']=='homepage') {
		kish_multi_wp_print_home_page();
	}
	else if($_POST['req']=='delpost') {
		kish_multi_wp_delete_post($_POST['id'],$_POST['postid']);
	}
	else if($_POST['req']=='getpendcomsallblogs') {
		kish_multi_wp_get_blog_get_comments($_POST['siteid'], 'hold');
	}
	else if($_POST['req']=='showtwitterkishmulti') {
		kish_multi_wp_print_twitter_layout();
	}
}
else {
	if( function_exists('add_action') ) {
		add_action('admin_print_styles', 'kish_do_css' );
		add_action('admin_menu', 'kish_multi_wp_add_admin');
		add_action('init', 'kish_multi_wp_install');
	}
	if( function_exists('register_activation_hook') ) {
		register_activation_hook(__FILE__,"kish_multi_wp_install");
	}
}
?>