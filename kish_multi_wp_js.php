<?php
 	include_once('functions.php') ;
?>
var ktp_ajaxurl = '<?php echo KISH_MULT_WP_AJAXURL; ?>';
var loader = '<?php echo KISH_MULT_WP_LOADER; ?>';
var loader2 = '<?php echo KISH_MULT_WP_LOADER_TWO; ?>';
var loader3 = '<?php echo KISH_MULT_WP_LOADER_THREE; ?>';
var imgdir = '<?php echo KISH_MULT_WP_IMG_FOLDER_PATH; ?>';
var defaultSite = '<?php echo KISH_MULT_WP_DEFAULT_SITE; ?>';
var ktp_ajax_loader=loader2;
var thissiteid = null;
var thissiteurl = null;
var thissiteadmin = null;
var thissitepw = null;
var thiscomid=null;
var thiscomment=null;
var oneditpostid=null;
var arrSites = new Array();
var siteIdString='<?php echo kish_multi_get_site_id_to_array(); ?>';
var siteUrlNameString='<?php echo kish_multi_get_site_id_name_to_array(); ?>';
var arrSites = siteIdString.split(',');
var arrSitesName = siteUrlNameString.split('|');
var arrCategories = new Array();
var arrCatLoaded = false;
var tastartPos=-1;
var kishTiny=false;
var kishMode='HomePage';
var element;
var heading=false;
var temphead='';
var tempcont='';
var tempPostId='';
var poptitle='<?php echo $_REQUEST['t']; ?>';
var popcont="<?php echo trim(addcslashes($_REQUEST['s'], "\\\'\"&\n\r<>")); ?>";
var popurl='<?php echo $_REQUEST['u']; ?>';
var popflag='<?php echo $_REQUEST['flag']; ?>';
var uploadifyPath='';
var defaultFeedUrl='<?php echo KISH_MULT_WP_DEFAULT_FEED; ?>';
var loadingfeed='';
var feedstatus='';
var menutabdata='';
var tabmode='menu';
var newsSearch;
var searchMode;
var toblogitfeedid='';
var kmpIsIe=kmp_detectie();
var kmpTheme='<?php echo KISH_MULTI_THEME_COLOR; ?>';
var kishTwit=<?php kish_multi_check_if_kish_twit_enabled();?>;
var kmpScreenLock=<?php echo KISH_MULTI_WP_SCREENLOCK; ?>;
var kmpLastSiteId;
if(popflag=='flag') {
	uploadifyPath='<?php echo KISH_MULT_WP_IMG_FOLDER_PATH; ?>';
}
else {
	uploadifyPath='<?php echo KISH_MULT_WP_IMG_FOLDER_PATH; ?>';
}
var defaultFeed='<?php echo trim(KISH_MULT_WP_DEFAULT_FEED); ?>';
var ktpPopUrl = '<?php echo KISH_MULT_WP_POPURL; ?>';
var kmtxt='';

jQuery(document).ready(function(){
	if(kmpTheme=='classic') {
		$.blockUI.defaults.overlayCSS.backgroundColor = '#065baa';  
	}
	else {
		$.blockUI.defaults.overlayCSS.backgroundColor = '#000000'; 
	}	
	$.blockUI.defaults.overlayCSS.opacity = .2; 
	if(popflag!='flag') {
		jQuery('html, body').animate({scrollTop:0}, 'slow');
		kish_multi_wp_get_new_home_page();
	}
});
jQuery(document).ready(function() {
	jQuery('.backtotop').click(function(){
		jQuery('html, body').animate({scrollTop:0}, 'slow');
	});
});
function kmp_get_site_name(siteid) {
	var x =0;
	var temparr= new Array();
	for (x in arrSitesName)  {
		temparr=arrSitesName[x].split(',');
		if(temparr[0]==siteid){
			return temparr[1];
		}
  	}
	return false;
}
function kish_multi_wp_geturldetails(progressDiv, resultDiv) {
	var data ='req=getmetadetails&url=' + val('kish_multi_wp_url') + '&xe=dsaeu';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progressDiv, loader3);
}
function kish_multi_wp_load_into_array(category) {
	arrCategories.push(category);
}
function kish_multi_wp_setMode(newmode, alertmsg) {
	if(alertmsg.length>0) {
		if(confirm(alertmsg)) {	kishMode=newmode; return true;}
		else {return false;}
	}
	else {
		kishMode=newmode;	
		if(document.getElementById('kish_multi_wp_mode')) { 
			return true;
		}
	}
}
function kish_multi_wp_checkmode(newmode) {
	if(kishMode=='newPost') {
		return kish_multi_wp_setMode(newmode, 'Are you sure to navigate, You have not saved the post!!');
	}
	if(kishMode=='editPost') {
		return kish_multi_wp_setMode(newmode, 'Are you sure to navigate, You have not saved the post edit !!');
	}
	if(kishMode=='addNewBlog') {
		return kish_multi_wp_setMode(newmode, 'Are you sure to navigate, You have not saved the new site !!');
	}
	else {
		return kish_multi_wp_setMode(newmode, '');
	}
}

function val(x) {
	if (window.document.getElementById(x)) {
		return window.document.getElementById(x).value;
	}
}

function setSiteId(id) {
	if(thissiteid!=id) {
		kish_wp_showprogress('kish_multi_wp_site_info', '', loader2);
		thissiteid=id;
		kish_multi_wp_update_site_title_info(id, 'kish_multi_wp_site_info', 'kish_multi_wp_site_info');
		if(document.getElementById('kmwp-pt')) {
			kish_multi_wp_update_site_title_info(id, 'kmwp-pt', 'kmwp-pt');
		}
	}
}
function kish_multi_wp_update_site_title_info(id, resultDiv, progressDiv) {
	var data='req=updatetitle&siteid=' + id + '&xe=dsaeu';
	kmp_do(ktp_ajaxurl, data, kish_wp_multi_update_title_text, resultDiv, progressDiv, loader3);
}
function kish_wp_multi_update_title_text(text, resultDiv, progressDiv) {      
	if(window.document.getElementById(progressDiv)){  
		window.document.getElementById(progressDiv).innerHTML = '';
	}
	if(window.document.getElementById(resultDiv)){  
		window.document.getElementById(resultDiv).style.display = 'none';
		window.document.getElementById(resultDiv).innerHTML = text;
		jQuery("#"+resultDiv).fadeIn("slow");
	}
}
function setComId(id) {
	thiscomid=id;
}
function help(msg, color) {
	color==undefined?color='000000':color=color;
	if(document.getElementById('kish_multi_wp_help')) {	
		jQuery("#kish_multi_wp_help").css("color", "#CACACA");
		jQuery("#kish_multi_wp_help").html('<span style="font-size:11px; color:#' + color + '">'+ msg + '</span>');	
		jQuery("#kish_multi_wp_help").css("color", "#000000");
	}
	else {
		alert(msg);
	}
}
function kish_multi_wp_show_new_site_form(text, resultDiv, progressDiv) {
	tinyMCE.execCommand('mceRemoveControl', true, 'kish_multi_wp_edit_desc');
	kishTiny=false;
	window.document.getElementById(resultDiv).innerHTML = text;	
	data='req=loadnewsiteform&siteid=' + thissiteid + '&x=32';
	kmp_do(ktp_ajaxurl, data, kish_multi_load_form_tinymce, 'kish_multi_wp_new_post_form', 'kish_multi_wp_prog_1', loader3);
	jQuery("#kish_multi_wp_resultDiv_1").slideDown("slow");
}

function getSelText() {
    kmtxt = '';
	if (window.getSelection) {
        kmtxt = window.getSelection();
     }
    else if (document.getSelection) {
        kmtxt = document.getSelection();
    }
    else if (document.selection) {
        kmtxt = document.selection.createRange().text;
    }
    else return;
}


function kish_update_default_site(siteid) {
	var data = 'req=updatesiteoption&siteid='+siteid+'&s=kksi';
	kmp_do(ktp_ajaxurl, data, kmp_show, 'kmp_def_site', 'kmp_def_site', loader3);
}

function kish_multi_wp_print_new_site_form() {
	if(kish_multi_wp_checkmode('addNewBlog')) {
		kmp_show_msg('Loading New Site Page..', 2000);
		var data='req=shownewsiteform&xe=yees';
		kmp_do(ktp_ajaxurl, data, kmp_show,'kish_multi_wp_resultDiv_1', 'kish_multi_wp_prog_1', loader3);
		help('You can add new site here, please make sure that you have enabled remote publishing of the site to be added..', 'CA0000');
	}
	else {return false; }
}
function kish_multi_wp_load_new_site_cats(resultDiv, progressDiv) {
	arrCategories.length=0;
	arrCatLoaded = false;
	var data='req=loadnewsitecats&siteid=' + thissiteid + '&x=32';
	kmp_do(ktp_ajaxurl, data, kmp_show,resultDiv, progressDiv, loader3);
}
function kish_multi_wp_reload_sidebar_site_details(resultDiv, progressDiv) {
	var data='req=reloadsitessidebar&siteid=' + thissiteid + '&x=32';
	kmp_do(ktp_ajaxurl, data, kmp_show,resultDiv, progressDiv, loader3);
}

function kish_check_default_site_id_not_set() {
	if(defaultSite=='') {
		defaultSite=siteIdString[0];
	}
}
function kish_multi_wp_get_new_home_page() {
	kmp_show_msg('Loading Pending Comments and latest posts...', 5000);
	kish_check_default_site_id_not_set();
	if(popflag.length>=2) {
		if(defaultSite>=1) {
			if(thissiteid!=defaultSite) {
				kish_wp_showprogress('kish_multi_wp_site_info', '', loader2);
				thissiteid=defaultSite;
				kish_multi_wp_update_site_title_info(defaultSite, 'kish_multi_wp_site_info', 'kish_multi_wp_site_info');
				if(document.getElementById('kmwp-pt')) {
					kish_multi_wp_update_site_title_info(defaultSite, 'kmwp-pt', 'kmwp-pt');
				}
			}
		}
		kish_multi_press_it();
		return true;
	}
	if(kish_multi_wp_checkmode('homeView')) {
		var resultDiv = 'kish_multi_wp_resultDiv_1';
		var progressDiv = 'kish_multi_wp_prog_1' ;	
		help('Loading Dashboard..');
		setSiteId(defaultSite);
		kish_wp_showprogress(progressDiv, '', loader);
		var data='req=newhome';
		jQuery.post(ktp_ajaxurl,data,function(data) {
			jQuery("#" + progressDiv).html('');
			jQuery("#" + resultDiv).html(data);
			var x=0;
			var count=arrSites.length-1;
			kmpLastSiteId=arrSites[count];
			for (x in arrSites)  {
		 		kish_multi_wp_get_comments_with_vals(arrSites[x]);
		 		kish_multi_wp_latest_posts_homepage(arrSites[x], 3);
		 		help('Getting Pending Comments and Latest Posts..');
		  	}		
		},"html");
		help('Request Processed..');
		kmp_show_msg('Loaded Pending Comments and latest posts...', 3000);
		//kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_multi_wp_load_pend_coms_site_loop, resultDiv, progressDiv);
	}
	else {return false; }
}
function kish_multi_wp_load_pend_coms_site_loop(text, resultDiv, progressDiv) {
	jQuery("#" + progressDiv).html('');
	jQuery("#" + resultDiv).html(text);
	var x=0;
	for (x in arrSites)  {
 		kish_multi_wp_get_comments_with_vals(arrSites[x]);
 		kish_multi_wp_latest_posts_homepage(arrSites[x], 3);
  	}
  	help('Request Processed..');
}
function kish_multi_wp_get_comments_with_vals(id) {
	help('Loading Dashboard..');
	var data ='req=getpendcomsallblogs&siteid=' + id + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, 'kish_multi_wp_l_comments_' + id , 'kish_multi_wp_pending_comments_prog_' + id , loader3);
}
function kish_multi_wp_latest_posts_homepage(id, num) {
	var data ='req=poststatus&siteid=' + id + '&num=' + num + '&y=xys';
	var msg='';
	if(id==kmpLastSiteId) {
		msg='You can now moderate pending comments and posts...';
	}
	kmp_do(ktp_ajaxurl, data, kmp_show, 'kish_multi_wp_l_posts_'+id, 'kish_multi_wp_pending_posts_prog_'+id, loader3, msg);
}
function kish_multi_wp_single_post(postid) {
	if(kishMode=='feedPost') {
		km_toggle_div('kish_blogit_new_post_form');
		return false;
	}
	if(kish_multi_wp_checkmode('postView')) {
		if(postid==0) {
			kmp_show_msg('Loading Posts Browser..');
		}
		help('You can read posts of all the blogs you have connected. Click on the blog button below to select a particular blog..');
		if(thissiteid==null){ setSiteId(arrSites[0]); }
		jQuery("#kish_multi_wp_resultDiv_1").slideUp("slow");
		kish_wp_showprogress('kish_multi_wp_prog_1', '', loader);
		var data='req=singlepost&siteid=' + thissiteid + '&postid=' + postid + '&xe=yees';
		jQuery.post(ktp_ajaxurl,data,function(data) {
			jQuery("#kish_multi_wp_resultDiv_1").html(data);
			jQuery("#kish_multi_wp_resultDiv_1").slideDown("slow");
			jQuery("#kish_multi_wp_prog_1").html('');
			kmp_show_msg('Post Loaded....', 1000);
		},"html");
	}
	else {return false; }
}

function kish_multi_wp_show_settings_page() {
	if(kish_multi_wp_checkmode('postView')) {
		kmp_show_msg('You can update your settings here..', 2000);
		help('You can update your settings here..');
		jQuery("#kish_multi_wp_resultDiv_1").slideUp("slow");
		kish_wp_showprogress('kish_multi_wp_prog_1', '', loader);
		var data='req=settingspage';
		jQuery.post(ktp_ajaxurl,data,function(data) {
			jQuery("#kish_multi_wp_resultDiv_1").fadeOut("slideUp", function() {
				jQuery("#kish_multi_wp_resultDiv_1").html(data);
				jQuery("#kish_multi_wp_resultDiv_1").fadeIn("slideDown");
				jQuery("#kish_multi_wp_prog_1").html('');
			});
		},"html");
	}
	else {
		return false;
	}
}
function kish_multi_wp_show_site_options_page() {
	if(kish_multi_wp_checkmode('siteOptions')) {
		jQuery("#kish_multi_wp_resultDiv_1").slideUp("slow");
		kish_wp_showprogress('kish_multi_wp_prog_1', '', loader);
		var data='req=siteoptionspage&siteid=' + thissiteid  + '&xe=yees';
		jQuery.post(ktp_ajaxurl,data,function(data) {
			jQuery("#kish_multi_wp_resultDiv_1").fadeOut("slideUp", function() {
				jQuery("#kish_multi_wp_resultDiv_1").html(data);
				jQuery("#kish_multi_wp_resultDiv_1").fadeIn("slideDown");
				jQuery("#kish_multi_wp_prog_1").html('');
			});
		},"html");
	}
	else {
		alert('out');
		return false;
	}
}

function kmp_show_msg(msg, timeout) {
	if(kmpScreenLock) {
		var overlay=false;
		var kmpbg='#000';
		if(kmpTheme=='classic') {kmpbg='#065baa'}
		if(timeout==undefined) {
			timeout=1000000;
			overlay=true;
			center=true;
			msg='<img src="'+loader3+'">' + '  ' + msg;
		}
		jQuery.blockUI({ 
			message: msg, 
		    fadeIn: 700, 
		    fadeOut: 700, 
		    timeout: timeout, 
		    showOverlay: overlay, 
		    centerY: false, 
		    css: { 
		   		width: '350px', 
		      	top: '10px', 
		     	left: '', 
		        right: '10px', 
		        border: 'none', 
		        padding: '5px', 
		        backgroundColor: kmpbg, 
		       	'-webkit-border-radius': '10px', 
		       	'-moz-border-radius': '10px', 
		        opacity: .6, 
		        color: '#fff' 
		 	} 
		 });
	 }
}

function km_clear_div(divid){
	jQuery("#"+divid).html('');
}
function km_hide_div(divid){
	jQuery("#"+divid).fadeOut("slideUp");
}
function km_toggle_div(divid){
	jQuery("#"+divid).toggle(400);
	return false;
}
function km_clear_txtdiv(divid){ 
	jQuery("#"+divid).val('');
}
function kish_multi_wp_single_post_edit_post(postid, resultDiv, status) {
	data='req=editpost&title=' + val(kish_multi_wp_edit_title) + '&desc=' + val(kish_multi_wp_edit_desc) + '&siteid=' + thissiteid + '&postid=' + postid + '&status=' + status + '&xe=yees';
	kmp_do(ktp_ajaxurl, data, kmp_show, 'kish_multi_wp_resultDiv_1', 'kish_multi_wp_prog_1', loader3);
}
function kish_multi_wp_single_post_sidebar(postid, resultDiv) {
	if(kish_multi_wp_checkmode('postView')) {
		jQuery("#"+resultDiv).fadeOut("slow");
		var request='singlepostsidebar';
		if(kishMode=='newPost') {
			resultDiv='kish_multi_wp_search_results';
			request='singleposteditpostnewpost';
		}
		data='req=' +request + '&siteid=' + thissiteid + '&postid=' + postid + '&xe=yees';
		jQuery('html, body').animate({scrollTop:180}, 'slow');
		kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, 'kish_multi_wp_prog_1', loader3);
	}
}
function kish_multi_wp_single_post_sidebar_edit_post_mode(blogid, postid, resultDiv) {
	kmp_show_msg('Loading Post...', 2000);
	var request='singlepostsidebar';
	if(kishMode=='newPost') {
		resultDiv='kish_multi_wp_search_results';
		request='singleposteditpostnewpost';
	}
	var data='req=' +request + '&siteid=' + blogid + '&postid=' + postid + '&xe=yees';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, 'kish_multi_wp_search_results_prog', loader3);
}
function kish_multi_wp_reloadsitebar(blogid, num, progressDiv, resultDiv) {
	var request = 'reloadsidebar';
	if(kishMode=='newPost') {
		request='reloadsidebareditpostnewpost';
	}
	var data='req=' + request +  '&siteid=' + blogid + '&num=' + num + '&xe=yees';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progressDiv, loader3);
}

function kish_multi_wp_get_latest_posts(siteid, num, progressDiv, resultDiv) {
	kmp_show_msg('Getting latest ' + num + ' posts from ' + kmp_get_site_name(siteid), 2000);
	var request = 'reloadsidebar';
	if(kishMode=='newPost') {
		request='reloadsidebareditpostnewpost';
	}
	var data='req=' + request +  '&siteid=' + siteid + '&num=' + num + '&xe=yees';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progressDiv, loader3, 'Ya Got it..');
}
function kish_multi_wp_edit_post_form_print(postid, progressDiv, resultDiv) {
	kish_multi_wp_setMode('editPost', '');
	tinyMCE.execCommand('mceRemoveControl', true, 'kish_multi_wp_edit_desc');
	kishTiny=false;
	arrCategories.length=0;
	arrCatLoaded = false;
	var data='req=showposteditform&siteid=' + thissiteid + '&postid=' + postid + '&xe=yees';
	kmp_do(ktp_ajaxurl, data, kish_multi_wp_show_edit_form_post, resultDiv, progressDiv, loader3);
}

function kish_multi_wp_moderate_post_single_page(postid, progDiv, resultDiv, status) {
	var data ='req=modpost&status=' + status + '&postid=' + postid + '&id=' + thissiteid + '&b=' + val('kish_multi_wp_blog_url') + '&u=' + val('kish_multi_wp_username') + '&p=' + val('kish_multi_wp_password') + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kish_multi_wp_moderate_post_single_page_show, resultDiv, progDiv, loader3);
	help('The post is now - ' + status);
}
function kish_multi_wp_wp_get_comment_for_post(postid, progressDiv, resultDiv) {
	var data ='req=showcomments&postid=' + postid + '&siteid=' + thissiteid + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progressDiv, loader3);
	help('The post is now - ' + status);
}
function kish_multi_wp_moderate_post_single_page_show(postid, resultDiv) {
	kish_multi_wp_single_post_sidebar(postid, resultDiv);
}
function kish_multi_wp_print_home_page() {
	help('Please hold on, it may take some time to get all the pending comments from all the sites added...');
	var data='req=homepage';
	kmp_do(ktp_ajaxurl, data, kmp_show, 'kish_multi_wp_resultDiv_1', 'kish_multi_wp_prog_1', loader3);
}
function kish_multi_wp_updateinfo(id) {
	//kmp_show_msg(kishMode, 2000);
	if(kishMode=='postView') {	
		if(kish_multi_wp_checkmode('postView')) {
			kmp_show_msg('Loading Post from ' + kmp_get_site_name(id), 2000);
			jQuery("#kish_multi_wp_resultDiv_1").slideUp("slow");
			setSiteId(id);
			kish_multi_wp_single_post('');
		} 
		else{
			return false;
		}
	}
	else if(kishMode=='newPost' || kishMode=='feedPost') {
		if(kishMode=='newPost') {
			kmp_show_msg('This post will be posted to ' + kmp_get_site_name(id), 2000);
		}
		setSiteId(id);
		kish_multi_wp_load_new_site_cats('kish_wp_site_cats', 'kish_multi_wp_prog_1');
		kish_multi_wp_reload_sidebar_site_details('kish_multi_wp_new_post_sidebar', 'kish_multi_wp_prog_1');
	}
	else if(kishMode=='commentView') {
		setSiteId(id);
		kish_multi_load_comments();
	}
	else {
		if(kish_multi_wp_checkmode('siteView')) {
			kmp_show_msg('Loading Details from ' + kmp_get_site_name(id), 3000);
			setSiteId(id);
            jQuery.noConflict(); 
			jQuery("#kish_multi_wp_resultDiv_1").slideUp("slow");
			data='req=shownewsiteform&id=' + id;
			kmp_do(ktp_ajaxurl, data, kish_wp_multi_displayWidgets, 'kish_multi_wp_resultDiv_1', 'kish_multi_wp_prog_1', loader3);
			help('Enter the Blog Details..');
		}
		else {return false; }
	}
}
function kish_wp_multi_displayWidgets(text, resultDiv, progressDiv) {  		
	document.getElementById(progressDiv).innerHTML = '';
	document.getElementById(resultDiv).innerHTML = text;
	document.getElementById('kish_multi_wp_post_status').innerHTML='<img src = '+ loader +' align = center>'; 
	kish_multi_wp_post_status();
	document.getElementById('kish_multi_wp_tags').innerHTML='<img src = '+ loader +' align = center>';   
	kish_multi_wp_get_tags();
	document.getElementById('kish_multi_wp_bloginfo').innerHTML='<img src = '+ loader +' align = center>';  
	kish_multi_wp_get_blog_options();
	document.getElementById('kish_multi_wp_latest_comments').innerHTML='<img src = '+ loader +' align = center>'; 
	kish_multi_wp_get_comments('kish_multi_wp_latest_comments');
	jQuery("#kish_multi_wp_resultDiv_1").slideDown("slow");
}
function kish_multi_wp_save_new_site() {
	if(val('kish_multi_wp_blog_url').substr(0,7)!='http://') { 
		help('You have to enter your blog url starting with http://');
		alert('Please start your blog url with http://'); 
		return false; 
	}
	if(val('kish_multi_wp_blog_url').length<10) { alert('Please enter the full URL of the blog'); help('Please enter the url of your blog home page'); return false; }
	if(val('kish_multi_wp_username').length<2) { alert('Please enter your blog username'); help('The Username you entered does not look correct..'); return false; }
	if(val('kish_multi_wp_password').length<2) { alert('Please enter your blog password'); help('Please check your password'); return false; }
	kmp_show_msg('Trying to add new site ' + val('kish_multi_wp_blog_url'));
	kish_multi_wp_setMode('saveNewSite', '');
	help('Trying to save the information of new site..');	
	var data ='req=savesite&b=' + val('kish_multi_wp_blog_url') + '&u=' + val('kish_multi_wp_username') + '&p=' + val('kish_multi_wp_password') + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kish_wp_multi_new_site, 'kish_multi_wp_msg_1', 'kish_multi_wp_prog_1', loader3);
	help(''); 
}
function kish_wp_multi_new_site(text, resultDiv, progressDiv) {	
	help('Trying to add new site..');      
	document.getElementById(progressDiv).innerHTML = '';
	document.getElementById(resultDiv).innerHTML = text;
	if(kishMode=='saveNewSite') {
		if(document.getElementById('kish_latest_site_id')) {
			kish_multi_wp_refresh_sidebar();
			arrSites.push(val('kish_latest_site_id'));
			setSiteId(arrSites[arrSites.length-1]);
			kish_multi_wp_updateinfo(thissiteid);
			kish_multi_wp_setMode('sitePageView', '');
			kmp_show_msg('Site Added Successfully...', 2000);
		}
		else {
			kmp_show_msg('There is a problem - Either you have not enabled <a target="_blank" href="http://kishpress.com/blog/2010/05/30/enabling-remote-publishing-in-wordpress/">Remote Publishing</a> or the login information is wrong', 10000);
			help('There is a problem - Either you have not enabled <a target="_blank" href="http://kishpress.com/blog/2010/05/30/enabling-remote-publishing-in-wordpress/">Remote Publishing</a> or the login information is wrong!!' + text);
			alert(text);
		}
	}
	if(kishMode=='delSite') {
		x=inArray(thissiteid, arrSites);
		arrSites.splice(x,1);
		setSiteId(arrSites[arrSites.length-1]);
		kish_multi_wp_updateinfo(thissiteid);
		kish_multi_wp_setMode('sitePageView', '');
	}				
}
function kish_multi_wp_refresh_sidebar() {
	help('Sidebar Refreshed..');
	var data = 'req=showsidebar';
	kmp_do(ktp_ajaxurl, data, kmp_show, 'kish_multi_wp_sidebar', 'kish_multi_wp_prog_1', loader3);
}
function kish_multi_wp_update_site() {
	help('Trying to update the information of new site..');	
	var data ='req=updatesite&siteid=' + thissiteid + '&b=' + val('kish_multi_wp_blog_url') + '&u=' + val('kish_multi_wp_username') + '&p=' + val('kish_multi_wp_password')+'&y=xys';
	kmp_do(ktp_ajaxurl, data, kish_wp_multi_new_site, 'kish_multi_wp_msg_1', 'kish_multi_wp_prog_1', loader3);
}
function kish_multi_wp_delete_site() {
	if(confirm('Are you sure to delete?')) {
		kish_multi_wp_setMode('delSite', '');
		help('Trying to delete the site..');	
		var data ='req=deletesite&siteid=' + val('kish_multi_wp_id') + '&y=xys';
		kmp_do(ktp_ajaxurl, data, kish_wp_multi_new_site, 'kish_multi_wp_resultDiv_1', 'kish_multi_wp_prog_1', loader3);
		//kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_new_site, 'kish_multi_wp_resultDiv_1', 'kish_multi_wp_prog_1');
	}
	else {return false;}
}
function kish_multi_wp_post_status() {
	help('Trying to latest posts..');	
	var data ='req=poststatus&siteid=' + thissiteid + '&y=xys';
	if(kmp_detectie()) {
		kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_displayMode, 'kish_multi_wp_post_status', 'kish_multi_wp_prog_1');
	}
	else {
		kmp_do(ktp_ajaxurl, data, kmp_show, 'kish_multi_wp_post_status', 'kish_multi_wp_prog_1', loader3);
	}
}
function kish_multi_load_comments() {
	if(kish_multi_wp_checkmode('commentView')) {
		kmp_show_msg('Loading Comments..');
		kish_wp_showprogress('kish_multi_wp_prog_1', '', loader3);
		jQuery("#kish_multi_wp_resultDiv_1").html('<div id="kmp_single_blog_coms"></div>');
		jQuery("#kmp_single_blog_coms").slideUp("slow");
		kish_multi_wp_get_comments('kmp_single_blog_coms','', 25, 0);
	}
	else {
		return false;
	}
}
function kish_multi_wp_get_comments(resultDiv,status, num, offset) {
	if(num==undefined) {
		num=10;
	}
	if(offset==undefined) {
		offset=0;
	}
	if(status==undefined) {
		status='';
	}
	help('View comments of the selected blog. You can navigate to other blog comments using the blog selection buttons below. All the comments are shown below ..');	
	var data ='req=getcomments&siteid=' + thissiteid + '&num=' + num + '&offset=' + offset + '&status=' + status + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, '', loader3, 'Comments Loaded..');
	//kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_displayMode, resultDiv, 'kish_multi_wp_prog_1');
}

function kish_wp_multi_refresh_comments_homepage(text, resultDiv, progressDiv) {
	kish_multi_wp_get_comments(resultDiv);
	help('I thing you got what you wanted ..');
}

function kish_multi_wp_moderate_comment(comid, progDiv, resultDiv, status) {
	kmp_show_msg('Changing comment status to ' + status, 2000);
	var data ='req=modcom&status=' + status + '&comid=' + comid + '&siteid=' + thissiteid + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progDiv, loader3);
}
function kish_multi_wp_edit_comment(comid, progDiv, resultDiv) {
	kmp_show_msg('Editing comment.. ' + status, 2000);
	var data ='req=editcomment&comid=' + comid + '&content=' + val('kish_multi_wp_com_edit_' + comid) + '&siteid=' + thissiteid + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progDiv, loader3);
	help('Comment edited and saved');
}
function kish_multi_wp_moderate_post(postid, progDiv, resultDiv, status) {
	var data ='req=modpost&status=' + status + '&postid=' + postid + '&id=' + thissiteid + '&b=' + val('kish_multi_wp_blog_url') + '&u=' + val('kish_multi_wp_username') + '&p=' + val('kish_multi_wp_password') + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progDiv, loader3);
	//kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_displayMode, resultDiv, progDiv);
	help('The post is now - ' + status);
}
function kish_multi_wp_delete_post(postid, progDiv, resultDiv) {
	if(confirm("Sure you want to delete this post? There is NO undo!")) {
		var data ='req=delpost&postid=' + postid + '&id=' + thissiteid + '&y=xys';
		//kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_displayMode, resultDiv, progDiv);
		kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progDiv, loader3);		
		var t=setTimeout(function(){
		document.getElementById(resultDiv).innerHTML = '';
		document.getElementById(resultDiv).style.border = "none";
		},500);
	}
	else {
	help('Great you told No, Its always good to change your decision ..');
	}
}
function kish_multi_wp_print_comment_reply_form(comid, progDiv, resultDiv) {
	setComId(comid);
	help('Now you can type your reply to this comment and hit the submit button..');	
	var data ='req=showcomform&status=' + status + '&comid=' + comid + '&siteid=' + thissiteid + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progDiv, loader3);
}
function kish_multi_wp_print_comment_reply_form_email(comid, progDiv, resultDiv) {
	setComId(comid);
	help('Now you can type your reply to this comment and hit the submit button..');	
	var data ='req=showcomformemail&status=' + status + '&comid=' + comid + '&siteid=' + thissiteid + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, resultDiv, progDiv, loader3);
}
function kish_multi_wp_print_comment_edit_form(comid, progDiv, resultDiv) {
	setComId(comid);
	var data='';
	kish_wp_showprogress(progDiv, '', loader);
	help('Now you can type your reply to this comment and hit the submit button..');	
	data +='req=showcomeditform&comid=' + comid + '&siteid=' + thissiteid + '&y=xys';
	kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_displayMode, resultDiv, progDiv);
}
function kish_multi_reply_comment(comid, progDiv, resultDiv) {
	setComId(comid);
	var data='';
	thiscomment=val('kish_multi_wp_reply_comment_' + comid);
	if(val('kish_multi_wp_reply_comment_' + comid).length==0){alert('Please enter the comments first..'); return false;}
	kish_wp_showprogress(progDiv, '', loader);
	help('Trying to post post your reply..');	
	data +='req=replycom&siteid=' + thissiteid + '&comid=' + comid + '&comtext=' + val('kish_multi_wp_reply_comment_' + comid) + '&y=xys';
	kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_refresh_comments, resultDiv, progDiv);
}
function kish_multi_reply_comment_email(comid, progDiv, resultDiv) {
	setComId(comid);
	var data='';
	thiscomment=val('kish_multi_wp_reply_comment_' + comid);
	if(val('kish_multi_wp_reply_comment_email_' + comid).length==0){alert('Please enter the comments first..'); return false;}
	kish_wp_showprogress(progDiv, '', loader);
	help('Trying to post post your reply..');	
	data +='req=replycomemail&siteid=' + thissiteid + '&comid=' + comid + '&comtext=' + val('kish_multi_wp_reply_comment_email_' + comid) + '&y=xys';
	kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_displayMode, resultDiv, progDiv);
}
function kish_wp_multi_refresh_comments(text, resultDiv, progressDiv) {
	if (document.getElementById('kish_multi_wp_latest_comments')) { 
		kish_multi_wp_get_comments('kish_multi_wp_latest_comments');
	}
	else {
		var id;
		id=resultDiv.substr(-2);
		if (document.getElementById('k-com-reply-' + thiscomid)) {
		thiscomment='<strong>Your Reply</strong><br>' + thiscomment;
		document.getElementById('k-com-reply-' + thiscomid).innerHTML=thiscomment;
		opacity('k-com-reply-' + thiscomid,0, 100, 500);	
		}
	}
	help('Comments Refreshed ..');

}
function kish_multi_wp_del_comment(comid, progDiv, resultDiv) {
	if(confirm("Sure you want to delete this update? There is NO undo!")) {
		var data='';
		kish_wp_showprogress(progDiv, '', loader);
		help('Trying to delete the comment ..');	
		data +='req=delcomments&comid=' + comid + '&siteid=' + thissiteid + '&y=xys';
		kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_displayMode, resultDiv, progDiv);
		help('Ohh you delted the comment ..');
	}
	else {
		help('Great you told No, Its always good to change your decision ..');
		kmp_show_msg('Great you told No, Its always good to change your decision ..', 2000);
	}
}
function kish_multi_wp_get_tags() {
	kmp_show_msg('Trying to get the site tags..', 2000);
	var data='';
	kish_wp_showprogress('kish_multi_wp_prog_1', 'Loading tags, please hold on..', loader);
	help('Trying to post status..');	
	data +='req=gettags&id=' + val('kish_multi_wp_id') + '&b=' + val('kish_multi_wp_blog_url') + '&u=' + val('kish_multi_wp_username') + '&p=' + val('kish_multi_wp_password') + '&y=xys';
	kmp_do(ktp_ajaxurl, data, kmp_show, 'kish_multi_wp_tags', 'kish_multi_wp_prog_1',loader3,'Ya got the Tags..');
	help('Trying to get the tags..');
}
function kish_multi_wp_get_blog_options() {
	var data='';
	kish_wp_showprogress('kish_multi_wp_prog_1', '', loader);
	help('Trying to blog settings..');	
	data +='req=getblogsettings&siteid=' + val('kish_multi_wp_id') + '&b=' + val('kish_multi_wp_blog_url') + '&u=' + val('kish_multi_wp_username') + '&p=' + val('kish_multi_wp_password') + '&y=xys';
	kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_wp_multi_displayMode, 'kish_multi_wp_bloginfo', 'kish_multi_wp_prog_1');
}
function kish_multi_wp_mouseover_show(div) {
	var x = document.getElementById(div).style;
	x.display="block";
}

function kish_multi_wp_tiny_init() {
	tinyMCE.init({
		theme : "simple",
		mode : "none"
	});
}

function kish_multi_wp_get_latest_post_titles(siteid,resultDiv, progressDiv) {
	kish_wp_showprogress(progressDiv, '', loader);
	var data ='req=gettitles&tags=' + val('kish_multi_wp_edit_tags') + '&category=' + arrCategories + '&siteid=' + thissiteid + '&title=' + val('kish_multi_wp_edit_title') + '&content=' + val('kish_multi_wp_edit_desc') + '&status=' + status + '&x=y';
	kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_multi_wp_after_new_post_save, resultDiv, progressDiv);
}

function kish_multi_wp_new_post_crossposting(postblogid,postid,resultDiv, progressDiv) {
	kish_wp_showprogress(progressDiv, '', loader);
	var data='';
	data +='req=crossposting&blogidtopublish=' + thissiteid + '&postid=' + postid + '&postblogid=' + postblogid + '&x=y';
	kish_multi_wp_postDataGetText(ktp_ajaxurl, data, kish_multi_wp_after_cross_posting, resultDiv, progressDiv);
}
function kish_multi_wp_after_cross_posting(text,resultDiv, progressDiv) {
	window.document.getElementById(progressDiv).innerHTML='';
	window.document.getElementById(resultDiv).innerHTML=text;
}

function kmp_insert_value_at_cursor_pose(ta, myValue) {
	x=document.getElementById(ta);
	if (x.selection) {
        x.focus();
        sel = x.selection.createRange();
        sel.text = myValue;
        x.focus();
  	}
    else if (x.selectionStart || x.selectionStart == '0') {
        var startPos = x.selectionStart;
        var endPos = x.selectionEnd;
        var scrollTop = x.scrollTop;
        x.value = x.value.substring(0, startPos)+myValue+x.value.substring(endPos,x.value.length);
        x.focus();
        x.selectionStart = startPos + myValue.length;
        x.selectionEnd = startPos + myValue.length;
        x.scrollTop = scrollTop;
     } 
     else {
        x.value += myValue;
        x.focus();
    }
}

function kish_multi_wp_set_post_ta(ta) {
	x=document.getElementById(ta);
	tastartPos = x.selectionStart;
}

function kish_multi_wp_mouseremove_hide(div) {
	var x = document.getElementById(div).style;
	x.display="none";
}
function kish_multi_wp_clearDiv(div) {
	jQuery("#"+div).slideUp();
	document.getElementById(div).innerHTML='';	
}
function kmp_do(ktp_ajaxurl, dataToSend, functionToCallBack, rdiv, pdiv, pimg, msg) {
	if(pimg==undefined) {
		pimg=loader;
	}
	if(pdiv.length>1){
		jQuery("#" + pdiv).html('<img src = "'+ pimg +'" align = "center">');
	}
	jQuery.post(ktp_ajaxurl,dataToSend,function(data) {
		functionToCallBack(data, rdiv, pdiv, msg);
	},"html");
}
function kmp_show(data, rdiv, pdiv, msg) {
	if(kmp_detectie()) {
		if(window.document.getElementById(pdiv)){  
			window.document.getElementById(pdiv).innerHTML = '';
		}
		window.document.getElementById('kish_multi_wp_prog_1').innerHTML = '';
		if(window.document.getElementById(rdiv)){  
			window.document.getElementById(rdiv).innerHTML = data;
			jQuery("#" + rdiv).slideDown("slow");
		}
	}
	else {
		jQuery("#kish_multi_wp_prog_1").html('');
		if(pdiv.length>1){
			jQuery("#" + pdiv).html('');
		}
		jQuery("#" + rdiv).slideUp("slow");
		jQuery("#" + rdiv).html(data);
		jQuery("#" + rdiv).slideDown("slow");
		
		if(msg==undefined || msg=='') {
		}
		else { 
			kmp_show_msg(msg, 3000);
		}
	}
	return false;
}
function kish_multi_wp_postDataGetText(urlToCall, dataToSend, functionToCallBack, resultDiv, progressDiv)
{ 
  var XMLHttpRequestObject = false;   
  if (window.XMLHttpRequest) {
    XMLHttpRequestObject = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    XMLHttpRequestObject = new 
     ActiveXObject("Microsoft.XMLHTTP");
  }

  if(XMLHttpRequestObject) {
    XMLHttpRequestObject.open("POST", urlToCall); 
    XMLHttpRequestObject.setRequestHeader('Content-Type', 
      'application/x-www-form-urlencoded'); 

    XMLHttpRequestObject.onreadystatechange = function() 
    { 
      if (XMLHttpRequestObject.readyState == 4 && 
        XMLHttpRequestObject.status == 200) {
          functionToCallBack(XMLHttpRequestObject.responseText, resultDiv, progressDiv); 
          delete XMLHttpRequestObject;
          XMLHttpRequestObject = null;
      } 
    }
    XMLHttpRequestObject.send(dataToSend); 	
  }
}
function kish_wp_showprogress(divID, message, imageurl) {
	if(document.getElementById(divID)) {
		document.getElementById(divID).innerHTML='<img src = "'+ imageurl +'" align = "center">' + message;
	}
}
function kish_wp_multi_displayMode(text, resultDiv, progressDiv) {      
	if(window.document.getElementById(progressDiv)){  
		window.document.getElementById(progressDiv).innerHTML = '';
	}
	if(window.document.getElementById(resultDiv)){  
		window.document.getElementById(resultDiv).style.display = 'none';
		window.document.getElementById(resultDiv).innerHTML = text;
		jQuery("#"+resultDiv).slideDown("slow");
	}
}

function kish_wp_getVar(v) {
	if (document.getElementById(v)) {
		var retval;
		retval = document.getElementById(v).value; 
		return retval;
	}
}
function kish_wp_multi_clear(x) {
	if (document.getElementById(x)) {	
		document.getElementById(x).innerHTML = '';
		document.getElementById(x).style.border = "none";
	}
}
function opacity(id, opacStart, opacEnd, millisec) { 
    //speed for each frame 
    var speed = Math.round(millisec / 100); 
    var timer = 0; 

    //determine the direction for the blending, if start and end are the same nothing happens 
    if(opacStart > opacEnd) { 
        for(i = opacStart; i >= opacEnd; i--) { 
            setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed)); 
            timer++; 
        } 
    } else if(opacStart < opacEnd) { 
        for(i = opacStart; i <= opacEnd; i++) 
            { 
            setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed)); 
            timer++; 
        } 
    } 
} 

//change the opacity for different browsers 
function changeOpac(opacity, id) { 
	if(document.getElementById(id)) {
	    var object = document.getElementById(id).style; 
	    object.opacity = (opacity / 100); 
	    object.MozOpacity = (opacity / 100); 
	    object.KhtmlOpacity = (opacity / 100); 
	    object.filter = "alpha(opacity=" + opacity + ")"; 
	}
}
function kish_wp_multi_setOpacity(testObj, value) {
	if (document.getElementById(testObj)) {
		testObj.style.opacity = value/10;
		testObj.style.filter = 'alpha(opacity=' + value*10 + ')';
	}
}
function kish_wp_getVarCheckBox(v) {
	if (document.getElementById(v)) {
		var retval;
		retval = document.getElementById(v).checked; 
		return retval;
	}
}
function kish_wp_setVar() {
	document.getElementById('tttwiter').value='Update your Status...'; 
}
function kish_multi_wp_setValue(element, text) {
	if (document.getElementById(element)) {
		//opacity(element,100, 0, 100);
		document.getElementById(element).innerHTML=text; 
		//opacity(element,0, 100, 1000);
	}
}
function kish_multi_show_twitter() {
	var data = 'req=showtwitterkishmulti';
	kish_wp_showprogress('kish_multi_wp_prog_1', '', loader);
	jQuery.post(ktp_ajaxurl,data,function(data) {
		jQuery("#kish_multi_wp_resultDiv_1").fadeOut("slideUp", function() {
			jQuery("#kish_multi_wp_resultDiv_1").html(data);
			jQuery("#kish_multi_wp_prog_1").html('');
			jQuery("#kish_multi_wp_resultDiv_1").fadeIn("slideDown", function() {
				kish_twit_pro_process_ajax('req=ktpfriendstimeline', 'ktp_cont', 'ktp_cont',ktp_ajax_loader); 
				kish_twit_pro_update_header_title('ktp_cont_top_data', 'My Friends Status', ktp_ajax_loader);
			});
		});
	},"html");
}
function explode( delimiter, string, limit ) {
    // http://kevin.vanzonneveld.net
    // +     original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     improved by: kenneth
    // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     improved by: d3x
    // +     bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: explode(' ', 'Kevin van Zonneveld');
    // *     returns 1: {0: 'Kevin', 1: 'van', 2: 'Zonneveld'}
    // *     example 2: explode('=', 'a=bc=d', 2);
    // *     returns 2: ['a', 'bc=d']
 
    var emptyArray = { 0: '' };
    
    // third argument is not required
    if ( arguments.length < 2 ||
        typeof arguments[0] == 'undefined' ||
        typeof arguments[1] == 'undefined' )
    {
        return null;
    }
 
    if ( delimiter === '' ||
        delimiter === false ||
        delimiter === null )
    {
        return false;
    }
 
    if ( typeof delimiter == 'function' ||
        typeof delimiter == 'object' ||
        typeof string == 'function' ||
        typeof string == 'object' )
    {
        return emptyArray;
    }
 
    if ( delimiter === true ) {
        delimiter = '1';
    }
    
    if (!limit) {
        return string.toString().split(delimiter.toString());
    } else {
        // support for limit argument
        var splitted = string.toString().split(delimiter.toString());
        var partA = splitted.splice(0, limit - 1);
        var partB = splitted.join(delimiter.toString());
        partA.push(partB);
        return partA;
    }
}
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return i;
    }
    return -1;
}

function ktpGetSelText() {
    var kmtxtpro = '';
	if (window.getSelection) {
        kmtxtpro = window.getSelection();
     }
    else if (document.getSelection) {
        kmtxtpro = document.getSelection();
    }
    else if (document.selection) {
        kmtxtpro = document.selection.createRange().text;
    }
	else if (window.document.selection) {
        kmtxtpro = window.document.selection.createRange().text;
    }
    return kmtxtpro;
}
function kmp_detectie() {
	if (navigator.appName == 'Microsoft Internet Explorer') {
		return true;
	}
	else{
		return false;
	}
}