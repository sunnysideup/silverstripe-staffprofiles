<?php
/**
 * Staff profile page
 * 
 * @author Mattias Lindgren
 * @package staffprofiles
 */
class StaffProfilePage extends Page
{

    /**
     * Specify the default parent for staff profiles
     *
     * @var string
     */
    private static $default_parent = "StaffProfilesHolderPage";
    
    /**
     * Staff profiles cannot be in the root
     *
     * @var bool
     */
    private static $can_be_root = false;
    
    /**
     * Set custom icon for staff profiles
     * 
     * @var string
     */
    private static $icon = "blog/images/staff-profiles-page.png";

    /**
     * DB fields for staff profile
     * 
     * @var array 
     */
    private static $db = array(
        'Position' => 'Varchar(80)',
        'Email' => 'Varchar(80)',
        'Phone' => 'Varchar(50)'
    );

    /**
     * Has one relationships
     * 
     * @var array 
     */
    private static $has_one = array(
        'Thumbnail' => 'Image'
    );
    
    /**
     * Has many many relationship
     * 
     * @var array 
     */
    private static $many_many = array(
        'Categories' => 'StaffProfilePage_Category'
    );
    
    /**
     * Returns a FieldList with which to create the main editing form.
     *
     * @return FieldList The fields to be displayed in the CMS.
     */
    public function getCMSFields()
    {
        // Get the CMS fields
        $fields = parent::getCMSFields();
        
        // Update the existing fields with labels
        $nameField = $fields->dataFieldByName("Title");
        if ($nameField) {
            $nameField->setRightTitle("Staff members name (John Smith etc)");
        }
        
        // Add the fields to the CMS
        $fields->addFieldToTab("Root.Main", TextField::create("Position", _t("StaffProfilePage.PositionTitle", "Position")), "Content");
        $fields->addFieldToTab("Root.Main", EmailField::create("Email", _t("StaffProfilePage.EmailTitle", "Email address")), "Content");
        $fields->addFieldToTab("Root.Main", TextField::create("Phone", _t("StaffProfilePage.PhoneTitle", "Phone")), "Content");
        $fields->addFieldToTab("Root.Categories", GridField::create("Categories", _t("StaffProfilePage.CategoriesTitle", "Categories"), $this->Categories(), StaffProfilePage_Category::getGridFieldConfig()));
        
        // Add the thumbnail field
        $uploadField = UploadField::create("Thumbnail", _t("StaffProfilePage.ThumbnailTitle", "Thumbnail"));
        $uploadField->setFolderName('Staff');
        $uploadField->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));
        $sizeMB = 0.3; // MB
        $size = $sizeMB * 1024 * 1024; // Bytes
        $uploadField->getValidator()->setAllowedMaxFileSize($size);
        $fields->addFieldToTab("Root.Main", $uploadField, "Content");
        
        $this->extend('updateCMSFields', $fields);

        return $fields;
    }
    
    /**
     * Create a unique email link that is connected with the Contact Form
     * 
     * @return string get the link to the contact page
     */
    public function EmailLink()
    {
        if (!empty($this->Email)) {
            $page = ContactPage::get()->first();
            if ($page) {
                return $page->Link() . "staff/{$this->ID}";
            }
        }
        return false;
    }
}

/**
 * Staff profile page controller
 */
class StaffProfilePage_Controller extends Page_Controller
{
}

/**
 * Staff profile page category
 */
class StaffProfilePage_Category extends DataObject
{
    /**
     * DB fields
     * 
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(80)'
    );
    
    /**
     * Has many many relationships reverse
     * 
     * @var array
     */
    private static $belongs_many_many = array(
        'StaffProfilePages' => 'StaffProfilePage'
    );
    
    /**
     * Get the configuration for the Gridfield component
     * 
     * @return GridFieldConfig
     */
    public static function getGridFieldConfig()
    {
        $config = GridFieldConfig::create();
        $config->addComponent(new GridFieldButtonRow("before"));
        $config->addComponent(new GridFieldAddNewButton("buttons-before-left"));
        $config->addComponent(new GridFieldAddExistingAutocompleter("buttons-before-left"));
        $config->addComponent(new GridFieldToolbarHeader());
        $config->addComponent(new GridFieldDataColumns());
        $config->addComponent(new GridFieldEditButton());
        $config->addComponent(new GridFieldDeleteAction(true));
        $config->addComponent(new GridFieldPaginator(30));
        $config->addComponents(new GridFieldDetailForm());
        // $config->addComponent(new GridFieldSortableRows("Sort"));
        return $config;
    }
}
