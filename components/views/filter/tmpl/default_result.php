<?php
echo "<p>", JText::_('COM_MGT_MGT'), ":</p>";
?>
<table>
    <thead>
    <tr>
        <th><?php echo JText::_('COM_MGT_ONLINE_FILTER_VEHICLE'); ?></th>
        <th><?php echo JText::_('COM_MGT_ONLINE_FILTER_ROUTE'); ?></th>
        <th><?php echo JText::_('COM_MGT_ONLINE_TIME'); ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($this->items as $item) : ?>
        <tr>
            <td><?php echo $item->bort; ?></td>
            <td><?php echo $item->route; ?></td>
            <td><?php echo $item->dat; ?></td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>