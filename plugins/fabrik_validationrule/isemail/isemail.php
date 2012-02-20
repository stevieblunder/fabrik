<?php
/**
* @package Joomla
* @subpackage Fabrik
* @copyright Copyright (C) 2005 Rob Clayburn. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

//require the abstract plugin class
require_once(COM_FABRIK_FRONTEND . '/models/plugin.php');
require_once(COM_FABRIK_FRONTEND . '/models/validation_rule.php');

class plgFabrik_ValidationruleIsEmail extends plgFabrik_Validationrule
{

	var $_pluginName = 'isemail';

	/** @param string classname used for formatting error messages generated by plugin */
	var $_className = 'notempty isemail';

	/** @var bool if true uses icon of same name as validation, otherwise uses png icon specified by $icon */
	protected $icon = 'isemail';

	/**
	 * validate the elements data against the rule
	 * @param string data to check
	 * @param object element
	 * @param int plugin sequence ref
	 * @return bol true if validation passes, false if fails
	 */

	function validate($email, &$element, $c)
	{
		//could be a dropdown with multivalues
		if (is_array($email)) {
			$email = implode('', $email);
		}
		//decode as it can be posted via ajax
		$email = urldecode($email);

 		$params = $this->getParams();
		$allow_empty = $params->get('isemail-allow_empty');
		$allow_empty = $allow_empty[$c];
		if ($allow_empty == '1' and empty($email)) {
			return true;
		}
		/* First, we check that there's one symbol, and that the lengths are right*/
		if (!preg_match("/[^@]{1,64}@[^@]{1,255}/", $email)) {
			/* Email invalid because wrong number of characters in one section, or wrong number of symbols.*/
			return false;
		}

		/* Split it into sections to make life easier*/
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[0])) {
				return false;
			}
		}
		/* Check if domain is IP. If not, it should be valid domain name */
		if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) {
			$domain_array = explode(".", $email_array[1]);
			if (sizeof( $domain_array ) < 2) {
				 /* Not enough parts to domain */
				return false;
			}
			for ($i = 0; $i < sizeof( $domain_array); $i++) {
				if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
					return false;
				}
			}
		}
		return true;
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
		$allow_empty = $params->get('isemail-allow_empty');
		$allow_empty = $allow_empty[$c];
		return $allow_empty == '1';
	}

}
?>