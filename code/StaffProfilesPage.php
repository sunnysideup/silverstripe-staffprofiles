<?php

/**
 *@author nicolaas[at]sunnysideup.co.nz
 *@description: displays a list of staff profiles
 *
 */
class StaffProfilesPage extends Page {

	private static $icon = "mysite/images/treeicons/StaffProfilesPage";

	private static $allowed_children = array("StaffProfilesOnePerson"); //can also be "none";

	private static $default_child = "StaffProfilesOnePerson";

	private static $has_many = array(
		"StaffProfiles" => "StaffProfile"
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab(
			"Root.Profiles",
			new GridField(
				"StaffProfiles",
				"Staff Profiles",
				StaffProfile::get(),
				GridFieldConfig_RelationEditor::create()
			)
		);
		return $fields;
	}

	function StaffProfilesAll() {
		return $this->StaffProfiles();
	}



}

class StaffProfilesPage_Controller extends Page_Controller {

	function init() {
		parent::init();
		Requirements::themedCSS("StaffProfilesPage", "staffprofiles");
	}


}

