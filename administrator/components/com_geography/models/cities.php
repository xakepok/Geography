<?php
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Model\ListModel;

class GeographyModelCities extends ListModel
{
    public function __construct(array $config)
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                '`id`', '`id`',
                '`name`', '`c`.`name`',
                '`country`', '`country`',
                '`region`', '`region`',
                '`state`', '`state`',
            );
        }
        parent::__construct($config);
    }

    protected function _getListQuery()
    {
        $db =& $this->getDbo();
        $query = $db->getQuery(true);
        $query
            ->select('`c`.`id`, `c`.`name`, `r`.`name` as `region`, `c`.`name` as `country`, `c`.`state`')
            ->from("`#__grph_cities` as `c`")
            ->leftJoin("`#__grph_regions` as `r` ON `r`.`id` = `c`.`region_id`")
            ->leftJoin("`#__grph_countries` as `s` ON `s`.`id` = `r`.`country_id`");

        /* Фильтр */
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            $search = $db->quote('%' . $db->escape($search, true) . '%', false);
            $query->where('`c`.`name` LIKE ' . $search);
        }
        // Фильтруем по состоянию.
        $published = $this->getState('filter.state');
        if (is_numeric($published))
        {
            $query->where('`c`.`state` = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where('(`c`.`state` = 0 OR `c`.`state` = 1)');
        }

        // Фильтруем по региону.
        $region = $this->getState('filter.region');
        if (is_numeric($region))
        {
            $query->where('`c`.`region_id` = ' . (int) $region);
        }

        /* Сортировка */
        $orderCol  = $this->state->get('list.ordering', '`c`.`name`');
        $orderDirn = $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol . ' ' . $orderDirn));

        return $query;
    }

    public function getItems()
    {
        $items = parent::getItems();
        $result = array();
        foreach ($items as $item) {
            $arr['id'] = $item->id;
            $url = JRoute::_("index.php?option=com_geography&amp;view=city&amp;layout=edit&amp;id={$item->id}");
            $link = JHtml::link($url, $item->name);
            $arr['name'] = $link;
            $arr['region'] = $item->region;
            $arr['country'] = $item->country;
            $arr['state'] = $item->state;
            $result[] = $arr;
        }
        return $result;
    }

    /* Сортировка по умолчанию */
    protected function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $published = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string');
        $region = $this->getUserStateFromRequest($this->context . '.filter.region', 'filter_region', '', 'string');
        $this->setState('filter.search', $search);
        $this->setState('filter.state', $published);
        $this->setState('filter.region', $region);
        parent::populateState('`c`.`name`', 'asc');
    }

    protected function getStoreId($id = '')
    {
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');
        $id .= ':' . $this->getState('filter.region');
        return parent::getStoreId($id);
    }
}