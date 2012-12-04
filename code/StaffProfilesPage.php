<?php

/**
 *@author nicolaas[at]sunnysideup.co.nz
 *@description: displays a list of staff profiles
 *
 */
class StaffProfilesPage extends Page {

	protected static $use_child_pages_rather_than_dataobject = false;
		static function set_use_child_pages_rather_than_dataobject($v) {self::$use_child_pages_rather_than_dataobject = $v;}
		static function get_use_child_pages_rather_than_dataobject() {return self::$use_child_pages_rather_than_dataobject;}

	public static $icon = "mysite/images/treeicons/StaffProfilesPage";

	public static $allowed_children = array("StaffProfilesOnePerson"); //can also be "none";

	public static $default_child = "StaffProfilesOnePerson";

	public static $has_many = array(
		"StaffProfiles" => "StaffProfile"
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		if(!self::get_use_child_pages_rather_than_dataobject()) {
			$fields->addFieldToTab(
				"Root.Content.Profiles",
				new HasManyComplexTableField(
					$controller = $this,
					$name = "StaffProfiles",
					$sourceClass = "StaffProfile",
					StaffProfile::$summary_fields,
					$detailFormFields = null,
					$sourceFilter = "ParentID = ".$this->ID
				)
			);
		}
		return $fields;
	}

	function StaffProfilesAll() {
		if(StaffProfilesPage::get_use_child_pages_rather_than_dataobject()) {
			return DataObject::get("StaffProfilesOnePerson", "ParentID = ".$this->ID);
		}
		else {
			return $this->StaffProfiles();
		}
	}



}

class StaffProfilesPage_Controller extends Page_Controller {

	function init() {
		parent::init();
		Requirements::themedCSS("StaffProfilesPage");
	}


}

