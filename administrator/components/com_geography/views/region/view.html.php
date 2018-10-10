<?php
defined('_JEXEC') or die;
use Joomla\CMS\MVC\View\HtmlView;

class GeographyViewRegion extends HtmlView {
    protected $item, $form, $script, $id;

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
        $title = $this->item->name ?? JText::_('COM_GEOGRAPHY_TITLE_REGION_NEW');

        JToolbarHelper::title($title, '');
	    JToolBarHelper::apply('region.apply', 'JTOOLBAR_APPLY');
        JToolbarHelper::save('region.save', 'JTOOLBAR_SAVE');
        JToolbarHelper::cancel('region.cancel', 'JTOOLBAR_CLOSE');
    }

    protected function setDocument() {
        JHtml::_('jquery.framework');
        JHtml::_('bootstrap.framework');
        $document = JFactory::getDocument();
        $document->addScript(JURI::root() . $this->script);
    }
}