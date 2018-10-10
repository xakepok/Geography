<?php
defined('_JEXEC') or die;
use Joomla\CMS\MVC\View\HtmlView;

class GeographyViewCity extends HtmlView {
    protected $item, $form, $script;

    public function display($tmp = null) {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->script = $this->get('Script');

        $this->addToolbar();
        $this->setDocument();

        parent::display($tpl);
    }

    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        $title = $this->item->name ?? JText::_('COM_GEOGRAPHY_TITLE_CITY_NEW');

        JToolbarHelper::title($title, '');
	    JToolBarHelper::apply('city.apply', 'JTOOLBAR_APPLY');
        JToolbarHelper::save('city.save', 'JTOOLBAR_SAVE');
        JToolbarHelper::cancel('city.cancel', 'JTOOLBAR_CLOSE');
    }

    protected function setDocument() {
        JHtml::_('jquery.framework');
        JHtml::_('bootstrap.framework');
        $document = JFactory::getDocument();
        $document->addScript(JURI::root() . $this->script);
    }
}