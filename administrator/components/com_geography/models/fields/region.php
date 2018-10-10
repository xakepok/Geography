<?php
defined('_JEXEC') or die;
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('groupedlist');

class JFormFieldRegion extends JFormFieldGroupedList
{
    protected $type = 'Region';

    protected function getGroups()
    {
        $db =& JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->select("`r`.`id`, `r`.`name`, `c`.`name` as `country`")
            ->from('`#__grph_regions` as `r`')
            ->leftJoin('`#__grph_countries` as `c` ON `c`.`id` = `r`.`country_id`')
            ->order("`r`.`name`");
        $result = $db->setQuery($query)->loadObjectList();
        $options = array();

        if ($result) {
            foreach ($result as $p) {
                if (!isset($options[$p->country])) {
                    $options[$p->country] = array();
                }
                $options[$p->country][] = JHtml::_('select.option', $p->id, $p->name);
            }
        }

        $options = array_merge(parent::getGroups(), $options);

        return $options;
    }
}