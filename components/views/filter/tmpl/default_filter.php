<?php
echo "<p>", JText::_('COM_MGT_ONLINE_FILTER'), ":</p>";
?>
<form action="<?php echo JRoute::_('index.php?option=com_mgt&view=filter'); ?>" id="mgt-filter" method="get" enctype="application/x-www-form-urlencoded">
    <table>
        <tr>
            <td>
			    <?php echo JText::_('COM_MGT_FILTER_SELECT_TRANSPORT'); ?>
            </td>
            <td>
	            <?php echo MgtHtmlFilters::transport($this->state->get('filter.transport')); ?>
            </td>
        </tr>
    </table>
</form>
<p><a href="<?php echo JRoute::_('index.php?option=com_mgt&view=filter'); ?>">Сбросить</a></p>