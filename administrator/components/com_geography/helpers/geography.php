<?php
use Joomla\CMS\Language\Text;
defined('_JEXEC') or die;

class GeographyHelper
{
	public function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(Text::_('COM_GEOGRAPHY'), 'index.php?option=com_geography&view=geography', $vName == 'geography');
		JHtmlSidebar::addEntry(Text::_('COM_GEOGRAPHY_MENU_COUNTRUES'), 'index.php?option=com_geography&view=countries', $vName == 'countries');
		JHtmlSidebar::addEntry(Text::_('COM_GEOGRAPHY_MENU_REGIONS'), 'index.php?option=com_geography&view=regions', $vName == 'regions');
		JHtmlSidebar::addEntry(Text::_('COM_GEOGRAPHY_MENU_CITIES'), 'index.php?option=com_geography&view=cities', $vName == 'cities');
	}
}
