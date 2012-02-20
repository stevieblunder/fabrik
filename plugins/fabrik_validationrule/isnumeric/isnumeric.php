<?php
/**
* @package Joomla
* @subpackage Fabrik
* @copyright Copyright (C) 2005 Rob Clayburn. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

//require the abstract plugin classes
require_once(COM_FABRIK_FRONTEND . '/models/plugin.php');
require_once(COM_FABRIK_FRONTEND . '/models/validation_rule.php');

class plgFabrik_ValidationruleIsNumeric extends plgFabrik_Validationrule
{

	var $_pluginName = 'isnumeric';

	/** @param string classname used for formatting error messages generated by plugin */
	var $_className = 'notempty isnumeric';

	/** @var bool if true uses icon of same name as validation, otherwise uses png icon specified by $icon */
	protected $icon = 'isnumeric';

	/**
	 * validate the elements data against the rule
	 * @param string data to check
	 * @param object element
	 * @param int plugin sequence ref
	 * @return bol true if validation passes, false if fails
	 */

	function validate($data, &$element, $c)
	{
		//could be a dropdown with multivalues
		if (is_array($data)) {
			$data = implode('', $data);
		}
 		$params = $this->getParams();
		$allow_empty = $params->get('isnumeric-allow_empty');
		$allow_empty = $allow_empty[$c];
		if ($allow_empty == '1' and empty( $data)) {
			return true;
		}
		return is_numeric($data);
	}

	/**
	* does the validation allow empty value?
	* Default is false, can be overrideen on per-validation basis (such as isnumeric)
	* @param object element model
	* @param int repeat group counter
	* @return bool
	*/

	protected function allowEmpty($elementModel, $c)
	{
 		$params = $this->getParams();
		$allow_empty = $params->get('isnumeric-allow_empty');
		$allow_empty = $allow_empty[$c];
		return $allow_empty == '1';
	}
}
?>