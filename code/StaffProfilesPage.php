<?php

/**
 *@author nicolaas[at]sunnysideup.co.nz
 *@description: displays a list of staff profiles
 *
 */
class StaffProfilesPage extends Page {

	private static $use_child_pages_rather_than_dataobjects = false;

	private static $icon = "mysite/images/treeicons/StaffProfilesPage";

	private static $allowed_children = array("StaffProfilesOnePerson"); //can also be "none";

	private static $default_child = "StaffProfilesOnePerson";

	private static $has_many = array(
		"StaffProfiles" => "StaffProfile"
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		if(!$this->Config()->get("use_child_pages_rather_than_dataobjects")) {
			$fields->addFieldToTab(
				"Root.Profiles",
				new GridField(
					"StaffProfiles",
					"Staff Profiles",
					StaffProfile::get(),
					GridFieldConfig_RelationEditor::create()
				)
			);
		}
		return $fields;
	}

	function StaffProfilesAll() {
		if(Config::inst()->get("StaffProfilesPage", "use_child_pages_rather_than_dataobjects")) {
			return StaffProfilesOnePerson::get()->filter(array("ParentID" => $this->ID));
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

