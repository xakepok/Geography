<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
defined('_JEXEC') or die;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_geography'))
{
	throw new InvalidArgumentException(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Require the helper
JLoader::register('GeographyHelper', dirname(__FILE__) . '/helpers/geography.php');
JLoader::register('GeographyHtmlFilters', dirname(__FILE__) . '/helpers/html/filters.php');

// Execute the task
$controller = BaseController::getInstance('geography');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
