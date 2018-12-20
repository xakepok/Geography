<?php
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Model\ListModel;

class GeographyModelCountries extends ListModel
{
    public function __construct(array $config)
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                '`id`', '`id`',
                '`name`', '`name`',
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
            ->select('*')
            ->from("`#__grph_countries`");

        /* Фильтр */
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            $search = $db->quote('%' . $db->escape($search, true) . '%', false);
            $query->where('`name` LIKE ' . $search);
        }
        // Фильтруем по состоянию.
        $published = $this->getState('filter.state');
        if (is_numeric($published))
        {
            $query->where('`state` = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where('(`state` = 0 OR `state` = 1)');
        }

        /* Сортировка */
        $orderCol  = $this->state->get('list.ordering', '`name`');
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
            $url = JRoute::_("index.php?option=com_geography&amp;task=country.edit&amp;id={$item->id}");
            $link = (!GeographyHelper::canDo('core.edit')) ? $item->name : JHtml::link($url, $item->name);
            $arr['name'] = $link;
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
        $this->setState('filter.search', $search);
        $this->setState('filter.state', $published);
        parent::populateState('`name`', 'asc');
    }

    protected function getStoreId($id = '')
    {
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');
        return parent::getStoreId($id);
    }
}