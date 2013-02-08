<?php if ( ! defined('EXT')) exit('Invalid file request');

// Get config file
require(PATH_THIRD.'dt_proform_select/config.php');


/**
* DT ProForm Select config file
*
* @version		1.0
* @package		dt_proform_select
* @author		Dreamtime ~ Jeff Claeson <jeff@bydreamtime.com>
* @copyright	Copyright 2011, Dreamtime
*/
class Dt_proform_select_ft extends EE_Fieldtype {

	/**
	* Info array
	*
	* @var	array
	*/
	var $info = array(
		'name'		=> DT_PF_NAME,
		'version'	=> DT_PF_VERSION
	);

	// --------------------------------------------------------------------

	/**
	* PHP4 Constructor
	*
	* @see	__construct()
	*/
	function Dt_proform_select_ft()
	{
		$this->__construct();
	}

	// --------------------------------------------------------------------

	/**
	* PHP5 Constructor
	*
	* @return	void
	*/
	function __construct()
	{
		parent::EE_Fieldtype();
	}

	// --------------------------------------------------------------------

	/**
	* Displays the field in publish form
	*
	* @param	string
	* @param	bool
	* @return	string
	*/
	function display_field($data, $cell = FALSE)
	{
		// Load helper
		$this->EE->load->helper('form');

		// Get fields from DB
		$query = $this->EE->db->query("SELECT form_label AS label, form_name AS name FROM exp_proform_forms ORDER BY name ASC");

		// Generate drop down
		$options = array('' => 'Please Select...');
		foreach ($query->result_array() AS $row)
		{
			$options[$row['name']] = $row['label'];
		}

		// Field name depending on Matrix cell or not
		$field_name = $cell ? $this->cell_name : $this->field_name;

		return form_dropdown($field_name, $options, $data);
	}

	// --------------------------------------------------------------------

	/**
	* Displays the field in matrix
	*
	* @param	string
	* @return	string
	*/
	function display_cell($cell_data)
	{	
		return $this->display_field($cell_data, TRUE);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Displays the field in Low Variables
	*
	* @param	string
	* @return	string
	*/
	function display_var_field($var_data)
	{
		return $this->display_field($var_data);
	}

	// --------------------------------------------------------------------

	/**
	* Displays the field in Content Elements (BACKEND)
	*
	* @param	mixed 	$elem_data 	data stored in the element
	* @return	string 				HTML markup
	*/
	function display_element($elem_data)
	{
		// Get fields from DB
		$query = $this->EE->db->query("SELECT form_label AS label, form_name AS name FROM exp_proform_forms ORDER BY name ASC");

		// Generate drop down
		$options = array('' => 'Please Select...');
		foreach ($query->result_array() AS $row)
		{
			$options[$row['name']] = $row['label'];
		}

		$field = array(
			'name'		=> $this->field_name,
			'value'		=> $elem_data,
		);

		$markup	= form_dropdown($field['name'], $options, $field['value']);

		return $markup;
	}
	
	// --------------------------------------------------------------------

	/**
	* Used to render the Content Elements data (contents) on the front-end.
	*
	* @param 	mixed 	$data 		data stored in the element
	* @param 	array 	$params 	params taken from the used tag
	* @param 	string 	$tagdata 	HTML markup replaced w/ output
	* @return 	string 				HTML output
	*/
	function replace_element_tag($elem_data, $params = array(), $tagdata)
	{
		$this->display_field($elem_data);
	}
	
	// --------------------------------------------------------------------

}

/* End of file ft.dt_proform_select.php */
