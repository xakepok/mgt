<?php
echo "<p>", JText::_('COM_MGT_MGT'), ":</p>";
?>

<table>
    <thead>
    <tr>
        <th><?php echo JText::_('COM_MGT_ONLINE_FILTER_VEHICLE'); ?></th>
        <th><?php echo JText::_('COM_MGT_ONLINE_FILTER_ROUTE'); ?></th>
        <?php if (!empty($this->items[0]['dat'])) :?>
            <th><?php echo JText::_('COM_MGT_ONLINE_TIME'); ?></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($this->items as $item) : ?>
        <tr>
            <td><?php echo $item['vehicle']; ?></td>
            <td><?php echo $item['route']; ?></td>
	        <?php if (!empty($item['dat'])) :?>
                <td><?php echo $item['dat']; ?></td>
	        <?php endif; ?>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>