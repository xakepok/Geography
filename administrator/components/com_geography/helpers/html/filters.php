<?php
defined('_JEXEC') or die;

abstract class GeographyHtmlFilters
{
    //Фильтр состояний
    public static function state($selected)
    {
        $options = array();

        $options[] = JHtml::_('select.option', '', 'JOPTION_SELECT_PUBLISHED');
        $options = array_merge($options, self::stateOptions());

        $attribs = 'class="inputbox" onchange="this.form.submit()"';

        return JHtml::_('select.genericlist', $options, 'filter_state', $attribs, 'value', 'text', $selected, null, true);
    }

    //Фильтр стран
    public static function country($selected)
    {
        $options = array();
        $options[] = JHtml::_('select.option', '', 'COM_GEOGRAPHY_FILTER_COUNTRY');
        $options = array_merge($options, self::countriesOptions());
        $attribs = 'onchange="this.form.submit()"';
        return JHtml::_('select.genericlist', $options, 'filter_country', $attribs, 'value', 'text', $selected, null, true);
    }


    //Список состояний модели
    public static function stateOptions()
    {
        $options = array();
        $options[] = JHtml::_('select.option', '1', 'JPUBLISHED');
        $options[] = JHtml::_('select.option', '0', 'JUNPUBLISHED');
        $options[] = JHtml::_('select.option', '2', 'JARCHIVED');
        $options[] = JHtml::_('select.option', '-2', 'JTRASHED');
        $options[] = JHtml::_('select.option', '*', 'JALL');

        return $options;
    }

    //Список стран
    protected function countriesOptions()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->select("`id`, `name`")
            ->from('#__grph_countries')
            ->order("`name`");
        $result = $db->setQuery($query)->loadObjectList();

        $options = array();

        foreach ($result as $item)
        {
            $options[] = JHtml::_('select.option', $item->id, $item->name);
        }

        return $options;
    }

}