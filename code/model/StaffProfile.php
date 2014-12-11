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
		"SubjectLine" => "Varchar(255)",
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

	private static $field_labels = array(
		"SortNumber" => "Sort Index Number for Sorting (lower numbers first)",
		"Subjectline" => "Optional Subject Line"
	);

	private static $summary_fields = array("Name" => "Name", "Email" => "Email", "Title" => "Title");

	private static $singular_name = "Staff Profile";

	private static $plural_name = "Staff Profiles";

	private static $default_sort = "Sort ASC, Name ASC";

	private static $defaults = array(
		"Sort" => 100
	);

	/**
	 * replacement placeholders
	 * [xxx] => yyy
	 * where xxx is the string the CMS user types
	 * and yyy the replacement field / relation.
	 *
	 * @var array
	 */
	private static $subject_place_holders = array(
		"Name" => "Name",
		"Email" => "Email",
		"Position" => "Position",
		"PageTitle" => "Parent.Title",
		"PageLink" => "Parent.Link"
	);

	public function populateDefaults() {
		$this->Sort = 100;
		parent::populateDefaults();
	}

	public function fieldLabels($includeRelations = true) {
		$labels = parent::fieldLabels($includeRelations);
		$labels["SubjectLine"] .=
			_t("StaffProfile.PLACEHOLDER_EXPLANATION", "you can use the following placeholders: [").
			implode("], [", array_keys($this->Config()->get("subject_place_holders"))).
			"]";
		return $labels;

	}

	/**
	 * Obscure all email links in StringField.
	 * Matches mailto:user@example.com as well as user@example.com
	 *
	 * @return string | Null
	 */
	public function EncodedEmailLink() {
		if($email = $this->getBestEmail()) {
			$obj = $this->retrieveEmailObject();
			if($obj) {
				return $obj->MailTo;
			}
			else {
				return "mailto:".$email;
			}
		}
	}

	/**
	 * Obscure all email links in StringField.
	 * Matches mailto:user@example.com as well as user@example.com
	 *
	 * @return string
	 */
	public function EncodedEmailText() {
		if($email = $this->getBestEmail()) {
			$obj = $this->retrieveEmailObject();
			if($obj) {
				return $obj->Text;
			}
			else {
				return $email;
			}
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

	/**
	 * puts together a subject line with replacements
	 *
	 * @return String
	 */
	protected function SubjectLineCreator(){
		if($this->SubjectLine) {
			$str = $this->SubjectLine;
		}
		else {
			$str = $this->Parent()->SubjectLine;
		}
		if(!$str) {
			$str =  "Enquiry from [PageLink] for [Name]";
		}
		$replace = $this->Config()->get("subject_place_holders");
		foreach($replace as $findKey => $replaceField) {
			if(strpos($str, $findKey) !== null) {
				if(strpos($replaceField, ".")) {
					$replaceFieldParts = explode(".", $replaceField);
					$method1 = $replaceFieldParts[0];
					$method2 = $replaceFieldParts[1];
					$relationalObject = $this->$method1();
					if($relationalObject) {
						if($relationalObject->hasMethod($method2)) {
							$replaceValue = $relationalObject->$method2();
						}
						elseif($relationalObject->hasMethod("get".$method2)) {
							$method2 = "get".$method2;
							$replaceValue = $relationalObject->$method2();
						}
					}
				}
				else {
					$replaceValue = $this->$replaceField;
				}
				$str = str_ireplace("[".$findKey."]", $replaceValue, $str);
			}
		}
		return $str;
	}


	/**
	 * @var EmailObject
	 */
	protected $emailObject = null;

	/**
	 *
	 * @return EmailObject | NULL
	 */
	protected function retrieveEmailObject(){
		if(!$this->emailObject) {
			if(class_exists("HideMailto")) {
				if($email = $this->getBestEmail()) {
					$this->emailObject = HideMailto::convert_email($email, $this->SubjectLineCreator());
				}
			}
			else {
				user_error("This module requires Sunnysideup/hidemailto, but it can function without it", E_USER_NOTICE);
			}
		}
		return $this->emailObject;
	}

	/**
	 * finds the best email available.
	 *
	 * @return String
	 */
	protected function getBestEmail(){
		if($this->Email) {
			$email = $this->Email;
		}
		else {
			$email = $this->Parent()->DefaultEmail;
		}
		return $email;
	}


}
