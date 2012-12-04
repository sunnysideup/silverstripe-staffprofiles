<?php

/**
 *@author nicolaas[at]sunnysideup.co.nz
 *@description: displays a list of staff profiles
 *
 */
class StaffProfilesOnePerson extends Page {

	static $icon = "mysite/images/treeicons/StaffProfilesOnePerson";

	static $allowed_children = "none"; //can also be "none";

	static $default_parent = "StaffProfilesPage"; // *URLSegment* of default parent node.

	static $can_be_root = false; //default is true
	//parents and children in classes

	static $db = array(
		"Email" => "Varchar(100)",
		"Position" => "Varchar(100)"
	);

	static $has_one = array(
		"ProfilePicture" => "Image"
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->replaceField("Title", new TextField("Title", "Name"));
		$fields->replaceField("MenuTitle", new TextField("MenuTitle", "Name for use in menus"));
		$fields->addFieldToTab("Root.Content.PersonalDetails", new TextField("Email", "Email"));
		$fields->addFieldToTab("Root.Content.PersonalDetails", new TextField("Position", "Position"));
		$fields->addFieldToTab("Root.Content.PersonalDetails", new ImageField("ProfilePicture", "ProfilePicture"));
		return $fields;
	}

	function Description() {
		return $this->Content;
	}

	function Name() {
		return $this->Title;
	}


  public function EmailObfuscatorName() {
		$obj = HideEmail::convert_email($this->Email);
		if($obj) {
			return $obj->text;
		}
	}

	public function EmailObfuscatorLink() {
		$obj = HideEmail::convert_email($this->Email);
		if($obj) {
			return $obj->mailto;
		}
	}


}

class StaffProfilesOnePerson_Controller extends Page_Controller {

	function init() {
		parent::init();
		Requirements::themedCSS("StaffProfilesOnePerson");
	}

}

