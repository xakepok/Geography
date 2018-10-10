<?php
defined('_JEXEC') or die;
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldCountry extends JFormFieldList  {
    protected  $type = 'Country';

    protected function getOptions()
    {
            $db =& JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                ->select("`id`, `name`")
                ->from('`#__grph_countries`')
                ->order("`name`");
            $result = $db->setQuery($query)->loadObjectList();

            $options = array();

            foreach ($result as $item)
            {
                $options[] = JHtml::_('select.option', $item->id, $item->name);
            }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}