<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
foreach ($this->items as $i => $item) :
    $canChange = JFactory::getUser()->authorise('core.edit.state', 'com_geography.city.' . $item['id']);
    ?>
    <tr class="row0">
        <td class="center">
            <?php echo JHtml::_('grid.id', $i, $item['id']); ?>
        </td>
        <td>
            <?php echo JHtml::_('jgrid.published', $item['state'], $i, 'cities.', $canChange); ?>
        </td>
        <td>
            <?php echo $item['name'];?>
        </td>
        <td>
            <?php echo $item['region'];?>
        </td>
        <td>
            <?php echo $item['country'];?>
        </td>
        <td>
            <?php echo $item['id']; ?>
        </td>
    </tr>
<?php endforeach; ?>