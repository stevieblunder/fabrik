<?php
/**
* @package Joomla
* @subpackage Fabrik
* @copyright Copyright (C) 2005 Rob Clayburn. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_ADMINISTRATOR . '/components/com_fabrik/tables/fabtable.php');

/**
 * @package		Joomla
 * @subpackage	Fabrik
 */
class FabrikTableFormGroup extends FabTable
{

 	/*
 	 *
 	 */

	function __construct(&$_db)
	{
		parent::__construct('#__{package}_formgroup', 'id', $_db);
	}

	/**
	 *  overloaded check function
	 */

	function check() {
		return true;
	}
}
?>
