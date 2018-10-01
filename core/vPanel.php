<?php
	class vPanel {
	
		protected $dbhost;
		protected $dbuser;
		protected $dbpass;
		protected $db;
		protected $vpanelroot;
		protected $vpaneltheme;
		protected $vpanelversion;
		protected $vpanelorganization;
		protected $siteUrl;
		protected $vpanelmenu = array();
		
		function __construct(){
			if(file_exists('config.xml')){
				$vpanelconfig = simplexml_load_file('config.xml');
				$this->dbhost = $vpanelconfig->database->host;
				$this->dbuser = $vpanelconfig->database->username;
				$this->dbpass = $vpanelconfig->database->password;
				$this->db = $vpanelconfig->database->dbName;
				$this->vpanelroot = $vpanelconfig->root;
				$this->vpaneltheme = $vpanelconfig->theme;
				$this->vpanelversion = $vpanelconfig->version;
				$this->vpanelorganization = $vpanelconfig->organization;
				$this->siteUrl = $vpanelconfig->siteUrl;
			}else{
				exit('No configuration file found!');
			}
		}
		
		function getRoot(){
			return $this->vpanelroot;
		}
		
		function getTheme(){
			return $this->vpaneltheme;
		}
		
		function getVersion(){
			return $this->vpanelversion;
		}
		
		function getOrganization(){
			return $this->vpanelorganization;
		}
		
		function getSiteUrl(){
			return $this->siteUrl;
		}
		
		function getMenu(){
			return $this->vpanelmenu;
		}
	}
?>