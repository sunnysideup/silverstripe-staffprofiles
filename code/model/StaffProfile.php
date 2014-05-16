<?php

/**
 *@author: nicolaas[at]sunnysideup.co.nz
 *@description: individual staff profile
 *
 **/

class StaffProfile extends DataObject {

	private static $db = array(
		"Name" => "Varchar(255)",
		"Position" => "Varchar(255)",
		"Description" => "Text",
		"Email" => "Varchar(255)",
		"Sort" => "Int"
	);

	private static $has_one = array(
		"ProfilePicture" => "Image",
		"Parent" => "StaffProfilesPage"
	);

	//database related settings
	private static $indexes = array(
		"Sort" => true
	);

	//formatting
	private static $searchable_fields = array("Name" => "PartialMatchFilter");

	private static $field_labels = array("Sort" => "Sort Index Number for Sorting (lower numbers first)");

	private static $summary_fields = array("Name" => "Name", "Email" => "Email", "Title" => "Title");

	private static $singular_name = "Staff Profile";

	private static $plural_name = "Staff Profiles";

	private static $default_sort = "Sort ASC, Name ASC";

	private static $defaults = array(
		"Sort" => 100
	);

	public function populateDefaults() {
		$this->Sort = 100;
		parent::populateDefaults();
	}


	protected $emailObject = null;

	protected function retrieveEmailObject(){
		if(!$this->emailObject) {
			if(class_exists("HideMailto")) {
				$this->emailObject = HideMailto::convert_email($this->Email, "Enquiry from ".Director::absoluteBaseURL());
			}
		}
		return $this->emailObject;
	}

	/**
	 * Obscure all email links in StringField.
	 * Matches mailto:user@example.com as well as user@example.com
	 *
	 * @return string
	 */
	public function EncodedEmailLink() {
		$obj = $this->retrieveEmailObject();
		if($obj) {
			$obj = HideMailto::convert_email($this->Email, "Enquiry from ".Director::absoluteBaseURL());
			return $obj->MailTo;
		}
		elseif($this->Email) {
			return "mailto:".$this->Email;
		}
	}

	/**
	 * Obscure all email links in StringField.
	 * Matches mailto:user@example.com as well as user@example.com
	 *
	 * @return string
	 */
	public function EncodedEmailText() {
		$obj = $this->retrieveEmailObject();
		if($obj) {
			$obj = HideMailto::convert_email($this->Email, "Enquiry from ".Director::absoluteBaseURL());
			return $obj->Text;
		}
		elseif($this->Email) {
			return $this->Email;
		}
	}

	function onBeforeWrite() {
		parent::onBeforeWrite();
		if(!$this->Sort) {
			$this->Sort = 100;
		}
		if(!$this->ParentID) {
			$page = StaffProfilesPage::get()->First();
			$this->ParentID = $page->ID;
		}
	}

}
