<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

class GeographyViewCities extends HtmlView
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
        $this->helper->addSubmenu('cities');
        $this->sidebar = JHtmlSidebar::render();

        // Display it all
        return parent::display($tpl);
    }

    private function toolbar()
    {
        JToolBarHelper::title(Text::_('COM_GEOGRAPHY_TITLE_CITIES'), '');

        if (Factory::getUser()->authorise('core.create', 'com_geography'))
        {
            JToolbarHelper::addNew('city.add');
        }
        if (Factory::getUser()->authorise('core.edit', 'com_geography'))
        {
            JToolbarHelper::editList('city.edit');
        }
        if ($this->state->get('filter.state') == -2 && Factory::getUser()->authorise('core.delete', 'com_geography'))
        {
            JToolbarHelper::deleteList('', 'cities.delete');
        }
        if (Factory::getUser()->authorise('core.edit.state', 'com_geography'))
        {
            JToolbarHelper::divider();
            JToolbarHelper::publish('cities.publish', 'JTOOLBAR_PUBLISH', true);
            JToolbarHelper::unpublish('cities.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            JToolBarHelper::archiveList('cities.archive');
            JToolBarHelper::trash('cities.trash');
        }
        if (Factory::getUser()->authorise('core.admin', 'com_geography'))
        {
            JToolBarHelper::preferences('com_geography');
        }
    }
}
