<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

foreach ($this->items as $i => $item) : ?>
    <tr class="row0">
        <td class="center">
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
        <td>
            <?php echo $item->id; ?>
        </td>
        <td>
            <?php $link = JRoute::_('index.php?option=com_mgt&view=vehicle&layout=edit&id='.$item->id); ?>
            <?php echo JHtml::link($link, $item->uniqueid);?>
        </td>
        <td>
            <?php echo $item->srv_id; ?>
        </td>
        <td>
            <?php echo $item->type; ?>
        </td>
        <td>
            <?php echo $item->bort; ?>
        </td>
    </tr>
<?php endforeach; ?>