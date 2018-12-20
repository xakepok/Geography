<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
foreach ($this->items as $i => $item) :
    $canChange = GeographyHelper::canDo('core.edit.state', 'com_geography.region.' . $item['id']);
    ?>
    <tr class="row0">
        <td class="center">
            <?php echo JHtml::_('grid.id', $i, $item['id']); ?>
        </td>
        <td>
            <?php echo JHtml::_('jgrid.published', $item['state'], $i, 'regions.', $canChange); ?>
        </td>
        <td>
            <?php echo $item['name'];?>
        </td>
        <td>
            <?php echo $item['country']; ?>
        </td>
    </tr>
<?php endforeach; ?>