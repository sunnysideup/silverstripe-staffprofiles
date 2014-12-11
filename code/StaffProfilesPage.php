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

	private static $db = array(
		"SubjectLine" => "Varchar(255)"
	);

	private static $has_many = array(
		"StaffProfiles" => "StaffProfile"
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Profiles",
			new TextField(
				"SubjectLine",
				_t("StaffProfilesPage.SUBJECT_LINE_EXPLANATION", "Subject line for email, you can use [").
				implode("], [", array_keys(Config::inst()->get("StaffProfile", "subject_place_holders"))).
			"]" . " as placeholders"
			)
		);
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

