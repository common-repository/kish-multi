<?php
/*
 * Author : Kishore Asokan (kishore@asokans.com)
 * For reuse permission, please contact me
 * http://www.asokans.com
 */
class kish_multi_wp {  	
   private $id, $url, $uname, $pw, $title, $desc, $xmlrpcurl, $blogurl, $version, $blogtitle, $blogdescription, $errHandler;
	// create a new object $test=new kish_multi_wp('url', 'uname', 'pass', 'title', 'desc' );
   	public function __construct() {   
		//error_reporting(0);		
   		define('KMW_ID', 'kish_multi_wp_id', TRUE);
    	define('KMW_URL', 'kish_multi_wp_blog_url', TRUE);
		define('KMW_UNAME', 'kish_multi_wp_username', TRUE);
		define('KMW_PW', 'kish_multi_wp_password', TRUE);
		define('KMW_TITLE', 'kish_multi_wp_blog_name', TRUE);
		define('KMW_DESC', 'kish_multi_blog_desc', TRUE);
		$args = func_get_args();
		if($args) {
			$this->url=$args[0];
			$this->uname=$args[1];
			$this->pw= $args[2];
			$this->title=$args[3];
			$this->desc=$args[4];
			$this->setXmlRpcUrl($url);		
		}
   	}
	public function getId() {return $this->id;}
	public function Id($id) {
		$this->id=$id;
		$this->getSiteFromDb($id);
	}
	public function setXmlRpcUrl(){
		$xmlrpcurl=$this->getUrl();
		substr($xmlrpcurl, -1)=='/' ? $xmlrpcurl .="xmlrpc.php" : $xmlrpcurl .="/xmlrpc.php";
		$this->xmlrpcurl= $xmlrpcurl;
	}
	public function getXmlRpcUrl(){return $this->xmlrpcurl;}
	public function getUrl() {return $this->url;}
	public function setUrl($url) {$this->url=$url;}
	public function getBlogUrl(){return $this->blogurl;}
	public function setBlogUrl(){$this->blogurl=$blogurl;}
	public function getBlogDescription(){return $this->blogdescriptions;}
	public function setBlogDescription(){$this->blogdescriptions=$blogdescriptions;}
	public function getVersion(){return $this->version;}
	public function setVersion(){$this->version=$version;}
	public function getUname() {return $this->uname;}
	public function setUname($uname) {$this->uname=$uname;}
	public function getPassWord() {return $this->pw;}
	public function setPassWord($pw) {
		$this->decodeURIComponent($pw);
	}
	public function getTitle() {return $this->title;}
	public function setTitle($title) {$this->title=$title;}
	public function getDesc() {	return $this->desc;}
	public function setDesc($desc) {$this->desc=$desc;}
	protected function checkNew($siteurl, $uname){
		global $wpdb;
		$sql = "SELECT kish_multi_wp_id FROM ".$wpdb->prefix."kish_multi_wp WHERE kish_multi_wp_blog_url = '".$siteurl."' AND kish_multi_wp_username = '{$uname}' LIMIT 1";
		$results=$wpdb->get_results($sql, OBJECT);
		if ($results){
			return true;	
		}
		else {return false;}
	}
	public function getIdFromUrl($siteurl){
		global $wpdb;
		$sql = "SELECT kish_multi_wp_id FROM ".$wpdb->prefix."kish_multi_wp WHERE kish_multi_wp_blog_url = '".$siteurl."' LIMIT 1";
		$results=$wpdb->get_results($sql, OBJECT);
		if ($results){
			return $results->kish_multi_wp_id;	
		}
		else {return false;}
	}
	public function load($id) {
		$this->id=$id;
		$this->getSiteDb();
		$this->setXmlRpcUrl();
	}
	public function update() {
		global $wpdb;
		if(!$this->id){echo "I am going out"; return;}
		//if(!$this->getSite($this->getId())) {echo "Sorry Wronge Site Id"; return;}
		$sql = "UPDATE ".$wpdb->prefix."kish_multi_wp SET ";
		if(strlen($this->url)) {$sql .= KMW_URL ."='".$this->url."', ";}
		if(strlen($this->uname)) {$sql .= KMW_UNAME ."='".$this->uname."', ";}
		if(strlen($this->pw)) {$sql .= KMW_PW ."='".trim($this->pw)."', ";}
		if(strlen($this->title)) {$sql .= KMW_TITLE ."='".mysql_escape_string(trim($this->title))."', ";}
		if(strlen($this->desc)) {$sql .= KMW_DESC ."='".mysql_escape_string(trim($this->desc))."', ";}
		$sql=substr(trim($sql), 0, -1);
		$sql .=" WHERE kish_multi_wp_id = ".$this->id." LIMIT 1";
		//echo $sql;
		if(mysql_query($sql, $wpdb->dbh)) {
			echo "Site Updated" ;
			return true;
		}
		else {
			echo "Error Updating site - ".$this->getTitle();
			return false;
		}
	}
	public function save() {
		$this->setPassWord($this->pw);
		if($this->getBlogInfoNew()) {
			global $wpdb;
			if($this->checkNew($this->url, $this->uname)) {echo "Site Already Entered, You can edit it "; return;}
			$sql = "INSERT INTO ".$wpdb->prefix."kish_multi_wp(".KMW_URL.", ".KMW_UNAME.",".KMW_PW.",".KMW_TITLE.",".KMW_DESC.")";
			$sql .="VALUES('".trim($this->url)."','".mysql_escape_string(trim($this->uname))."','".mysql_escape_string(trim($this->pw))."', '".mysql_escape_string(trim($this->title))."', '".mysql_escape_string(trim($this->desc))."')";
			echo $sql;
			if(mysql_query($sql, $wpdb->dbh)) {
				echo "Site Saved" ;
				return true;
			}
			else {
				echo "Error Saving site - ".$this->xmlrpcurl();
				return false;
			}
		}
	}
	public function getBlogInfo() {
		include_once('class-IXR.php');
		if(!$this->getId()){return;}
		if($kish_multi_wp_client = new IXR_Client($this->xmlrpcurl)) {
			if($kish_multi_wp_client->query('wp.getOptions', 0, $this->uname, $this->pw)) {
				$options = $kish_multi_wp_client->getResponse();
				$this->title=$options['blog_title']['value'];
				$this->desc=$options['blog_tagline']['value'];
				return true;
			}
			else{
				echo 'Error Code - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage(); 
				return false;
			}
		}
		else {echo "Error, the xmlrpc url is haveing some problem  - ".$this->getTitle(); return false;}	
	}
	public function getBlogOptions() {
		include_once('class-IXR.php');
		if(!$this->getId()){return;}
		if($kish_multi_wp_client = new IXR_Client($this->xmlrpcurl)) {
			if($kish_multi_wp_client->query('wp.getOptions', 0, $this->uname, $this->pw)) {
				$options = $kish_multi_wp_client->getResponse();
				return $options;
			}
			else{
				echo 'Error Code - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage(); 
				return false;
			}
		}
		else {echo "Error, the xmlrpc url is haveing some problem  - ".$this->getTitle(); return false;}	
	}
	public function getBlogInfoNew() {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->xmlrpcurl)) {
			if($kish_multi_wp_client->query('wp.getOptions', 0, $this->uname, $this->pw)) {
				$options = $kish_multi_wp_client->getResponse();
				$this->title=$options['blog_title']['value'];
				$this->desc=$options['blog_tagline']['value'];
				return true;
			}	
			else{
				echo 'Error Code - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage(); 
				return false;
			}
		}
		else {echo "Error, the xmlrpc url is haveing some problem  - ".$this->getTitle(); return false;}	
	}
	public function getLatestPosts($num) {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if($kish_multi_wp_client->query('metaWeblog.getRecentPosts', 0, $this->getUname(), $this->getPassword(), $num)) {
				return $kish_multi_wp_client->getResponse();
			}
			else{
				echo 'Getting Latest Posts - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage(); 
				return false;
			}
		}
		else {echo "Error, the xmlrpc url is haveing some problem  - ".$this->getTitle(); return false;}	
	}
	public function delPost($postId) {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('metaWeblog.deletePost','', $postId, $this->getUname(), $this->getPassword(), false)) {
				die('Error Deleting Post - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {echo "Post Deleted - ".$this->getTitle();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_get_post($postid){
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('metaWeblog.getPost', $postid, $this->getUname(), $this->getPassword())) {
				die('Error Getting Post - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return $kish_multi_wp_client->getResponse();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_get_recent_posts_titles($num){
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('mt.getRecentPostTitles', 0, $this->getUname(), $this->getPassword(), $num)) {
				die('Error Getting Recent Post Titles - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return $kish_multi_wp_client->getResponse();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_edit_post($postid, $editval){
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('metaWeblog.editPost', $postid, $this->getUname(), $this->getPassword(), $editval, false)) {
				 die('Error Editing Post - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return true;}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_new_post($postinfo){
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('metaWeblog.newPost', 0, $this->getUname(), $this->getPassword(), $postinfo, false)) {
				 die('Error Posting - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return $kish_multi_wp_client->getResponse();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_upload_image($imageinfo){
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('metaWeblog.newMediaObject', 0, $this->getUname(), $this->getPassword(), $imageinfo)) {
					 die('Error Uploading Image - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
				}
				else {return $kish_multi_wp_client->getResponse(); }
			}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_get_categories(){
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('mt.getCategoryList', 0, $this->getUname(), $this->getPassword())) {
				 die('Error Getting Categories - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return $kish_multi_wp_client->getResponse();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_get_comments($status="", $num=10, $offset=0) {
		$info=array('status'=>$status,'number'=>$num, 'offset'=>$offset);
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('wp.getComments', 0, $this->getUname(), $this->getPassword(), $info)) {
				die('Error getting the comments - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return $kish_multi_wp_client->getResponse();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_get_comment($comid) {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('wp.getComment', 0, $this->getUname(), $this->getPassword(), $comid)) {
				die('Error getting the comments - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return $kish_multi_wp_client->getResponse();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_get_comment_for_post($info) {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('wp.getComments', 0, $this->getUname(), $this->getPassword(), $info)) {
				die('Error getting the comments - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return $kish_multi_wp_client->getResponse();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_new_comment($postid, $cominfo) {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			//$comid=$kish_multi_wp_client->query('wp.newComment', 0, $this->getUname(), $this->getPassword(), $postid, $cominfo);
			if(!$kish_multi_wp_client->query('wp.newComment', 0, $this->getUname(), $this->getPassword(), $postid, $cominfo)) {
				die('Error posting comment - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return $kish_multi_wp_client->getResponse();}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_new_comment_anon($postid, $cominfo) {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('wp.newComment', 0, 'dd', 'adfsaf', $postid, $cominfo)) {
				die('Error posting comment - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return true;}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_delete_comment($comid) {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('wp.deleteComment', 0, $this->getUname(), $this->getPassword(), $comid)) {
				die('Error deleting comment - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return true;}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function wp_edit_comment($comid, $cominfo) {
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if(!$kish_multi_wp_client->query('wp.editComment', 0, $this->getUname(), $this->getPassword(), $comid, $cominfo)) {
				die('Error Editing Comment - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
			}
			else {return true;}
		}
		else {echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function get_tags() {
		include_once('class-IXR.php');
			if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
				if(!$kish_multi_wp_client->query('wp.getTags', 0, $this->getUname(), $this->getPassword())) {
					die('Error Getting Tags - '.$kish_multi_wp_client->getErrorCode().' : '.$kish_multi_wp_client->getErrorMessage());
				}
				else {return $kish_multi_wp_client->getResponse();}
			}
		else { echo "Error, the xmlrpc url is haveing some problem - ".$this->getTitle(); return false;}
	}
	public function getSavedSites() {
		global $wpdb;
		$sql = "SELECT * FROM ".$wpdb->prefix."kish_multi_wp";
		$results=$wpdb->get_results($sql, OBJECT);
		if($results) {
			return $results;
		}
		else return false;
	}
	public function getSiteFromDb($id) {
		global $wpdb;
		$sql = "SELECT * FROM ".$wpdb->prefix."kish_multi_wp WHERE kish_multi_wp_id = ".$id." LIMIT 1";
		$result=$wpdb->get_results($sql, OBJECT);
		if($result) {
			foreach($result as $results):
				$this->setUrl($results->kish_multi_wp_blog_url);
				$this->setUname($results->kish_multi_wp_username);
				$this->setPassword($results->kish_multi_wp_password);
				$this->setTitle($results->kish_multi_wp_blog_name);
				$this->setDesc($results->kish_multi_blog_desc);
			endforeach;	
			return $result;		
		}
		else return false;
	}
	private function getSiteDb() {
		$id=$this->getId();
		global $wpdb;
		$sql = "SELECT * FROM ".$wpdb->prefix."kish_multi_wp WHERE kish_multi_wp_id = ".$id." LIMIT 1";
		$result=$wpdb->get_results($sql, OBJECT);
		if($result) {
			foreach($result as $results):
				$this->setUrl($results->kish_multi_wp_blog_url);
				$this->setUname($results->kish_multi_wp_username);
				$this->setPassword($results->kish_multi_wp_password);
				$this->setTitle($results->kish_multi_wp_blog_name);
				$this->setDesc($results->kish_multi_blog_desc);
			endforeach;	
			return true;
		}
		else return false;
	}
	public function getSiteInfoFromUrl($url) {
		global $wpdb;
		$sql = "SELECT * FROM ".$wpdb->prefix."kish_multi_wp WHERE kish_multi_wp_blog_url = '".$url."' LIMIT 1";
		$result=$wpdb->get_results($sql, OBJECT);
		if($result) {
			foreach($result as $results):
				$this->id=$results->kish_multi_wp_id;
				$this->uname=$results->kish_multi_wp_username;
				$this->pw=$this->decodeURIComponent($results->kish_multi_wp_password);
				$this->title=$results->kish_multi_wp_blog_name;
				$this->desc=$results->kish_multi_blog_desc;
				$this->url=$results->kish_multi_wp_blog_url;
			endforeach;	
			return true;		
		}
		else return false;
	}
	public function deleteSite($id) {
		global $wpdb;	
		$sql = "DELETE FROM ".$wpdb->prefix."kish_multi_wp WHERE kish_multi_wp_id = ".$id." LIMIT 1";
		if(mysql_query($sql, $wpdb->dbh)) {
				echo "Site Deleted!!";
		}
		else {
			echo "Error Deleting Site";
		}
	}
	public function __tostring(){
		$siteinfo .="<p><img style=\"float:right\" src=\"http://images.websnapr.com/?size=s&url=".$this->getUrl()."\"><strong>Blog Name :</strong><a href=\"".$this->getUrl()."\">".$this->getTitle()."</a><br>";
		$siteinfo .="<strong>Blog Description :</strong>".$this->getDesc()."</p>";
		return $siteinfo;
	}
	public function setBlogOptions(){
		include_once('class-IXR.php');
		if($kish_multi_wp_client = new IXR_Client($this->getXmlRpcUrl())) {
			if($kish_multi_wp_client->query('wp.getOptions', 0, $this->uname, $this->pw)) {
				$options = $kish_multi_wp_client->getResponse();
				$this->blogurl=$options['blog_url']['value'];
				$this->blogtitle=$options['blog_title']['value'];
				$this->version=$options['software_version']['value'];
				$this->blogdescriptions=$options['blog_tagline']['value'];
			}
			else{echo "Error Login - Please check the username and passwordsss"; return false;}
		}
	}
	public function decodeURIComponent($pw) {
	   $result = "";
	   for ($i = 0; $i < strlen($pw); $i++) {
	       $decstr = "";
	       for ($p = 0; $p <= 8; $p++) {
	          $decstr .= $pw[$i+$p];
	       } 
	       list($decodedstr, $num) = $this->decodeURIComponentbycharacter($decstr);
	       $result .= urldecode($decodedstr);
	       $i += $num ;
	   }
	   $this->pw=$result;
	  	return  stripslashes($this->pw);
	}
	
	private function decodeURIComponentbycharacter($str) {
	
	   $char = $str;
	   
	   if ($char == "%E2%82%AC") { return array("%80", 8); }
	   if ($char == "%E2%80%9A") { return array("%82", 8); }
	   if ($char == "%E2%80%9E") { return array("%84", 8); }
	   if ($char == "%E2%80%A6") { return array("%85", 8); }
	   if ($char == "%E2%80%A0") { return array("%86", 8); }
	   if ($char == "%E2%80%A1") { return array("%87", 8); }
	   if ($char == "%E2%80%B0") { return array("%89", 8); }
	   if ($char == "%E2%80%B9") { return array("%8B", 8); }
	   if ($char == "%E2%80%98") { return array("%91", 8); }
	   if ($char == "%E2%80%99") { return array("%92", 8); }
	   if ($char == "%E2%80%9C") { return array("%93", 8); }
	   if ($char == "%E2%80%9D") { return array("%94", 8); }
	   if ($char == "%E2%80%A2") { return array("%95", 8); }
	   if ($char == "%E2%80%93") { return array("%96", 8); }
	   if ($char == "%E2%80%94") { return array("%97", 8); }
	   if ($char == "%E2%84%A2") { return array("%99", 8); }
	   if ($char == "%E2%80%BA") { return array("%9B", 8); }
	
	   $char = substr($str, 0, 6);
	
	   if ($char == "%C2%81") { return array("%81", 5); }
	   if ($char == "%C6%92") { return array("%83", 5); }
	   if ($char == "%CB%86") { return array("%88", 5); }
	   if ($char == "%C5%A0") { return array("%8A", 5); }
	   if ($char == "%C5%92") { return array("%8C", 5); }
	   if ($char == "%C2%8D") { return array("%8D", 5); }
	   if ($char == "%C5%BD") { return array("%8E", 5); }
	   if ($char == "%C2%8F") { return array("%8F", 5); }
	   if ($char == "%C2%90") { return array("%90", 5); }
	   if ($char == "%CB%9C") { return array("%98", 5); }
	   if ($char == "%C5%A1") { return array("%9A", 5); }
	   if ($char == "%C5%93") { return array("%9C", 5); }
	   if ($char == "%C2%9D") { return array("%9D", 5); }
	   if ($char == "%C5%BE") { return array("%9E", 5); }
	   if ($char == "%C5%B8") { return array("%9F", 5); }
	   if ($char == "%C2%A0") { return array("%A0", 5); }
	   if ($char == "%C2%A1") { return array("%A1", 5); }
	   if ($char == "%C2%A2") { return array("%A2", 5); }
	   if ($char == "%C2%A3") { return array("%A3", 5); }
	   if ($char == "%C2%A4") { return array("%A4", 5); }
	   if ($char == "%C2%A5") { return array("%A5", 5); }
	   if ($char == "%C2%A6") { return array("%A6", 5); }
	   if ($char == "%C2%A7") { return array("%A7", 5); }
	   if ($char == "%C2%A8") { return array("%A8", 5); }
	   if ($char == "%C2%A9") { return array("%A9", 5); }
	   if ($char == "%C2%AA") { return array("%AA", 5); }
	   if ($char == "%C2%AB") { return array("%AB", 5); }
	   if ($char == "%C2%AC") { return array("%AC", 5); }
	   if ($char == "%C2%AD") { return array("%AD", 5); }
	   if ($char == "%C2%AE") { return array("%AE", 5); }
	   if ($char == "%C2%AF") { return array("%AF", 5); }
	   if ($char == "%C2%B0") { return array("%B0", 5); }
	   if ($char == "%C2%B1") { return array("%B1", 5); }
	   if ($char == "%C2%B2") { return array("%B2", 5); }
	   if ($char == "%C2%B3") { return array("%B3", 5); }
	   if ($char == "%C2%B4") { return array("%B4", 5); }
	   if ($char == "%C2%B5") { return array("%B5", 5); }
	   if ($char == "%C2%B6") { return array("%B6", 5); }
	   if ($char == "%C2%B7") { return array("%B7", 5); }
	   if ($char == "%C2%B8") { return array("%B8", 5); }
	   if ($char == "%C2%B9") { return array("%B9", 5); }
	   if ($char == "%C2%BA") { return array("%BA", 5); }
	   if ($char == "%C2%BB") { return array("%BB", 5); }
	   if ($char == "%C2%BC") { return array("%BC", 5); }
	   if ($char == "%C2%BD") { return array("%BD", 5); }
	   if ($char == "%C2%BE") { return array("%BE", 5); }
	   if ($char == "%C2%BF") { return array("%BF", 5); }
	   if ($char == "%C3%80") { return array("%C0", 5); }
	   if ($char == "%C3%81") { return array("%C1", 5); }
	   if ($char == "%C3%82") { return array("%C2", 5); }
	   if ($char == "%C3%83") { return array("%C3", 5); }
	   if ($char == "%C3%84") { return array("%C4", 5); }
	   if ($char == "%C3%85") { return array("%C5", 5); }
	   if ($char == "%C3%86") { return array("%C6", 5); }
	   if ($char == "%C3%87") { return array("%C7", 5); }
	   if ($char == "%C3%88") { return array("%C8", 5); }
	   if ($char == "%C3%89") { return array("%C9", 5); }
	   if ($char == "%C3%8A") { return array("%CA", 5); }
	   if ($char == "%C3%8B") { return array("%CB", 5); }
	   if ($char == "%C3%8C") { return array("%CC", 5); }
	   if ($char == "%C3%8D") { return array("%CD", 5); }
	   if ($char == "%C3%8E") { return array("%CE", 5); }
	   if ($char == "%C3%8F") { return array("%CF", 5); }
	   if ($char == "%C3%90") { return array("%D0", 5); }
	   if ($char == "%C3%91") { return array("%D1", 5); }
	   if ($char == "%C3%92") { return array("%D2", 5); }
	   if ($char == "%C3%93") { return array("%D3", 5); }
	   if ($char == "%C3%94") { return array("%D4", 5); }
	   if ($char == "%C3%95") { return array("%D5", 5); }
	   if ($char == "%C3%96") { return array("%D6", 5); }
	   if ($char == "%C3%97") { return array("%D7", 5); }
	   if ($char == "%C3%98") { return array("%D8", 5); }
	   if ($char == "%C3%99") { return array("%D9", 5); }
	   if ($char == "%C3%9A") { return array("%DA", 5); }
	   if ($char == "%C3%9B") { return array("%DB", 5); }
	   if ($char == "%C3%9C") { return array("%DC", 5); }
	   if ($char == "%C3%9D") { return array("%DD", 5); }
	   if ($char == "%C3%9E") { return array("%DE", 5); }
	   if ($char == "%C3%9F") { return array("%DF", 5); }
	   if ($char == "%C3%A0") { return array("%E0", 5); }
	   if ($char == "%C3%A1") { return array("%E1", 5); }
	   if ($char == "%C3%A2") { return array("%E2", 5); }
	   if ($char == "%C3%A3") { return array("%E3", 5); }
	   if ($char == "%C3%A4") { return array("%E4", 5); }
	   if ($char == "%C3%A5") { return array("%E5", 5); }
	   if ($char == "%C3%A6") { return array("%E6", 5); }
	   if ($char == "%C3%A7") { return array("%E7", 5); }
	   if ($char == "%C3%A8") { return array("%E8", 5); }
	   if ($char == "%C3%A9") { return array("%E9", 5); }
	   if ($char == "%C3%AA") { return array("%EA", 5); }
	   if ($char == "%C3%AB") { return array("%EB", 5); }
	   if ($char == "%C3%AC") { return array("%EC", 5); }
	   if ($char == "%C3%AD") { return array("%ED", 5); }
	   if ($char == "%C3%AE") { return array("%EE", 5); }
	   if ($char == "%C3%AF") { return array("%EF", 5); }
	   if ($char == "%C3%B0") { return array("%F0", 5); }
	   if ($char == "%C3%B1") { return array("%F1", 5); }
	   if ($char == "%C3%B2") { return array("%F2", 5); }
	   if ($char == "%C3%B3") { return array("%F3", 5); }
	   if ($char == "%C3%B4") { return array("%F4", 5); }
	   if ($char == "%C3%B5") { return array("%F5", 5); }
	   if ($char == "%C3%B6") { return array("%F6", 5); }
	   if ($char == "%C3%B7") { return array("%F7", 5); }
	   if ($char == "%C3%B8") { return array("%F8", 5); }
	   if ($char == "%C3%B9") { return array("%F9", 5); }
	   if ($char == "%C3%BA") { return array("%FA", 5); }
	   if ($char == "%C3%BB") { return array("%FB", 5); }
	   if ($char == "%C3%BC") { return array("%FC", 5); }
	   if ($char == "%C3%BD") { return array("%FD", 5); }
	   if ($char == "%C3%BE") { return array("%FE", 5); }
	   if ($char == "%C3%BF") { return array("%FF", 5); }
	   
	   $char = substr($str, 0, 3);
	   if ($char == "%20") { return array("+", 2); }
	   
	   $char = substr($str, 0, 1);
	   
	   if ($char == "!") { return array("%21", 0); }
	   if ($char == "\"") { return array("%27", 0); }
	   if ($char == "(") { return array("%28", 0); }
	   if ($char == ")") { return array("%29", 0); }
	   if ($char == "*") { return array("%2A", 0); }
	   if ($char == "~") { return array("%7E", 0); }
	
	   if ($char == "%") {
	      return array(substr($str, 0, 3), 2);
	   } else {
	      return array($char, 0);
	   }
	}
}
class errorHandler {
	var $debug_level=0;
	function errors($debug_level=0) {
		$this->debug_level=$debug_level;
		set_error_handler(array($this, 'handle_error'));
	}
	function handle_error($type, $string, $file, $line, $vars) {
     // Decide which type of error it is, and handle appropriately
		switch ($type) {
	    	// Error type
	    	case FATAL:
		    // Select debug level
		    switch ($this->debug_level) {
	         	default:
	            case 0:
	            echo 'Error: '.$string.' in '.$file.' on line'. $line.'<br />';
	            print_r($var);
	            // Stop application
	            exit;
	            case 1:
	            echo 'There has been an error. Sorry for the inconvenience.';
	            // Stop application
	            exit;
	      	}
	        case ERROR:
	        echo '<pre><b>ERROR</b> ['.$type.'] '.$string.'<br />'."</pre>n";
	        break;
	        case WARNING:
	       	echo '<pre><b>WARNING</b> ['.$type.'] '.$string.'<br />'."</pre>n";
	        break;
	    }
	}
}
?>