<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

class GeographyViewRegions extends HtmlView
{
	protected $helper;
	protected $sidebar = '';
	public $items, $pagination, $uid, $state, $links;

	public function display($tpl = null)
	{
	    $this->items = $this->get('Items');
	    $this->pagination = $this->get('Pagination');
	    $this->state = $this->get('State');

		// Show the toolbar
		$this->toolbar();

		// Show the sidebar
		$this->helper = new GeographyHelper();
		$this->helper->addSubmenu('regions');
		$this->sidebar = JHtmlSidebar::render();

		// Display it all
		return parent::display($tpl);
	}

	private function toolbar()
	{
		JToolBarHelper::title(Text::_('COM_GEOGRAPHY_TITLE_COUNTRIES'), '');

        if (Factory::getUser()->authorise('core.create', 'com_geography'))
        {
            JToolbarHelper::addNew('country.add');
        }
        if (Factory::getUser()->authorise('core.edit', 'com_geography'))
        {
            JToolbarHelper::editList('country.edit');
        }
        if ($this->state->get('filter.state') == -2 && Factory::getUser()->authorise('core.delete', 'com_geography'))
        {
            JToolbarHelper::deleteList('', 'countries.delete');
        }
        if (Factory::getUser()->authorise('core.edit.state', 'com_geography'))
        {
            JToolbarHelper::divider();
            JToolbarHelper::publish('countries.publish', 'JTOOLBAR_PUBLISH', true);
            JToolbarHelper::unpublish('countries.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            JToolBarHelper::archiveList('countries.archive');
            JToolBarHelper::trash('countries.trash');
        }
		if (Factory::getUser()->authorise('core.admin', 'com_geography'))
		{
			JToolBarHelper::preferences('com_geography');
		}
	}
}
