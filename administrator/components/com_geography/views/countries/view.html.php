<?php
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

class GeographyViewCountries extends HtmlView
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
		$this->helper->addSubmenu('countries');
		$this->sidebar = JHtmlSidebar::render();

		// Display it all
		return parent::display($tpl);
	}

	private function toolbar()
	{
		JToolBarHelper::title(Text::_('COM_GEOGRAPHY_TITLE_COUNTRIES'), '');

        if (GeographyHelper::canDo('core.create'))
        {
            JToolbarHelper::addNew('country.add');
        }
        if (GeographyHelper::canDo('core.edit'))
        {
            JToolbarHelper::editList('country.edit');
        }
        if ($this->state->get('filter.state') == -2 && GeographyHelper::canDo('core.delete'))
        {
            JToolbarHelper::deleteList('', 'countries.delete');
        }
        if (GeographyHelper::canDo('core.edit.state'))
        {
            JToolbarHelper::divider();
            JToolbarHelper::publish('countries.publish', 'JTOOLBAR_PUBLISH', true);
            JToolbarHelper::unpublish('countries.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            JToolBarHelper::archiveList('countries.archive');
            JToolBarHelper::trash('countries.trash');
        }
		if (GeographyHelper::canDo('core.admin'))
		{
			JToolBarHelper::preferences('com_geography');
		}
	}
}
