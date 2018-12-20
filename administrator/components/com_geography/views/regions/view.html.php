<?php

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

class GeographyViewRegions extends HtmlView
{
    protected $helper;
    protected $sidebar = '';
    public $items, $pagination, $uid, $state, $links, $filterForm, $activeFilters;

    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

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

        if (GeographyHelper::canDo('core.create')) {
            JToolbarHelper::addNew('region.add');
        }
        if (GeographyHelper::canDo('core.edit')) {
            JToolbarHelper::editList('region.edit');
        }
        if ($this->state->get('filter.state') == -2 && GeographyHelper::canDo('core.delete')) {
            JToolbarHelper::deleteList('', 'regions.delete');
        }
        if (GeographyHelper::canDo('core.edit.state')) {
            JToolbarHelper::divider();
            JToolbarHelper::publish('regions.publish', 'JTOOLBAR_PUBLISH', true);
            JToolbarHelper::unpublish('regions.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            JToolBarHelper::archiveList('regions.archive');
            JToolBarHelper::trash('regions.trash');
        }
        if (GeographyHelper::canDo('core.admin')) {
            JToolBarHelper::preferences('com_geography');
        }
    }
}
