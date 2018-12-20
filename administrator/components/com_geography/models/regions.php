<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;

class GeographyModelRegions extends ListModel
{
    public function __construct(array $config)
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'name',
                'country',
                'state',
                'search',
            );
        }
        parent::__construct($config);
    }

    protected function _getListQuery()
    {
        $db =& $this->getDbo();
        $query = $db->getQuery(true);
        $query
            ->select('`r`.`id`, `r`.`name`, `c`.`name` as `country`, `c`.`id` as `countryID`, `r`.`state`')
            ->from("`#__grph_regions` as `r`")
            ->leftJoin("`#__grph_countries` as `c` ON `c`.`id` = `r`.`country_id`");

        /* Фильтр */
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->quote('%' . $db->escape($search, true) . '%', false);
            $query->where('`r`.`name` LIKE ' . $search);
        }
        // Фильтруем по состоянию.
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('`r`.`state` = ' . (int)$published);
        } elseif ($published === '') {
            $query->where('(`r`.`state` = 0 OR `r`.`state` = 1)');
        }
        // Фильтруем по стране.
        $country = $this->getState('filter.country');
        if (is_numeric($country)) {
            $query->where('`r`.`country_id` = ' . (int)$country);
        }

        /* Сортировка */
        $orderCol = $this->state->get('list.ordering', '`r`.`name`');
        $orderDirn = $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol . ' ' . $orderDirn));

        return $query;
    }

    public function getItems()
    {
        $items = parent::getItems();
        $result = array();
        $return = base64_encode(JUri::base() . "index.php?option=com_geography&amp;view=regions");
        foreach ($items as $item) {
            $arr['id'] = $item->id;
            $url = JRoute::_("index.php?option=com_geography&amp;task=region.edit&amp;id={$item->id}");
            $link = JHtml::link($url, $item->name);
            $arr['name'] = (!GeographyHelper::canDo('core.edit')) ? $item->name : $link;
            $url = JRoute::_("index.php?option=com_geography&amp;task=country.edit&amp;id={$item->countryID}&amp;return={$return}");
            $link = JHtml::link($url, $item->country);
            $arr['country'] = (!GeographyHelper::canDo('core.edit')) ? $item->country : $link;
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
        $country = $this->getUserStateFromRequest($this->context . '.filter.country', 'filter_country', '', 'string');
        $this->setState('filter.search', $search);
        $this->setState('filter.state', $published);
        $this->setState('filter.country', $country);
        parent::populateState('name', 'asc');
    }

    protected function getStoreId($id = '')
    {
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');
        $id .= ':' . $this->getState('filter.country');
        return parent::getStoreId($id);
    }
}