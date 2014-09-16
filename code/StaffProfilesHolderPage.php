<?php
/**
 * Staff profiles holder page
 * 
 * @author Mattias Lindgren
 * @package staffprofiles
 */
class StaffProfilesHolderPage extends Page {
	/**
	 * Specify the allowed child pages
	 * 
	 * @var array 
	 */
	private static $allowed_children = array(
		'StaffProfilePage'
	);
	
	/**
	 * Set custom icon for staff profiles
	 * 
	 * @var string
	 */
	private static $icon = "blog/images/staff-profiles-holder-page.png";
}

/**
 * Staff profiles holder page controller
 */
class StaffProfilesHolderPage_Controller extends Page_Controller {
	
	/**
	 * Current category
	 * 
	 * @var int 
	 */
	protected $categoryID = 0;
	
	/**
	 * Enable category request handler
	 * 
	 * @var array 
	 */
	private static $allowed_actions = array (
		"category"
	);	
	
	/**
	 * Handle category requests
	 */
	public function category() {
		// Get the requested category
		$category = SeoFriendlyDataObject::get_by_url_segement(
			"StaffProfilePage_Category",
			Convert::raw2sql($this->request->param("ID"))
		);
		
		// Set the current category
		if($category){
			$this->categoryID = $category->ID;
		}

		return $this;
	}
	
	/**
	 * Get a list of staff profiles based on selected category
	 * 
	 * @return SS_List StaffProfilePage
	 */
	public function StaffProfiles(){
		$results = StaffProfilePage::get()->filter(array(
				'ParentID' => $this->ID
			));

		if($this->categoryID > 0) {
			$results = $results
				->innerJoin("StaffProfilePage_Categories", "`StaffProfilePage_Categories`.`StaffProfilePageID` = `StaffProfilePage`.`ID`")
				->where("`StaffProfilePage_Categories`.`StaffProfilePage_CategoryID` = {$this->categoryID}");
		}
		
		return $results;
	}
	
	/**
	 * Get the current category ID
	 * 
	 * @return int
	 */
	public function CurrentCategoryID(){
		return $this->categoryID;
	}
	
	/**
	 * Get a list of categories related to this 
	 * staff profiles holder page.
	 * 
	 * @return SS_List StaffProfilePage_Category
	 */
	public function Categories(){
		// Create the output list
		$output = new ArrayList();
		
		// Get all the categories
		$categories = StaffProfilePage_Category::get();
		
		// Create the all category
		$allCategory = StaffProfilePage_Category::create();
		$allCategory->Title = "All";
		$allCategory->Selected = ($this->categoryID === 0) ? true : false;
		$output->add($allCategory);
		
		// Add all the categories
		foreach($categories as $category){
			$category->Selected = ($this->categoryID === $category->ID) ? true : false;
			$output->add($category);
		}

		return $output;
	}
}
