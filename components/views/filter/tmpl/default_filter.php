<?php
echo "<p>", JText::_('COM_MGT_ONLINE_FILTER'), ":</p>";
?>
<form action="<?php echo JRoute::_('index.php?option=com_mgt&view=filter&Itemid=263'); ?>" id="adminForm" name="adminForm" enctype="application/x-www-form-urlencoded">
    <table>
        <tr>
            <td>
			    <?php echo JText::_('COM_MGT_FILTER_SELECT_TRANSPORT'); ?>
            </td>
            <td>
	            <?php echo MgtHtmlFilters::transport($this->state->get('filter.transport')); ?>
            </td>
        </tr>
        <tr>
            <td>
			    <?php echo JText::_('COM_MGT_ONLINE_DATE'); ?>
            </td>
            <td>
                <input type="date" autocomplete="off" name="filter_date1" id="filter_date1" value="<?php echo $this->escape($this->state->get('filter.date1')); ?>" /><br>
                <input type="date" autocomplete="off" name="filter_date2" id="filter_date2" value="<?php echo $this->escape($this->state->get('filter.date2')); ?>" />
            </td>
        </tr>
        <tr>
            <td>
			    <?php echo JText::_('COM_MGT_ONLINE_FILTER_VEHICLE'); ?>
            </td>
            <td>
                <input type="text" autocomplete="off" name="filter_bort" id="filter_bort" value="<?php echo $this->escape($this->state->get('filter.bort')); ?>" title="<?php echo JText::_('COM_MGT_ONLINE_FILTER_VEHICLE'); ?>" />
            </td>
        </tr>
        <tr>
            <td>
			    <?php echo JText::_('COM_MGT_ONLINE_FILTER_ROUTE'); ?>
            </td>
            <td>
                <input type="text" autocomplete="off" name="filter_marshrut" id="filter_marshrut" value="<?php echo $this->escape($this->state->get('filter.marshrut')); ?>" title="<?php echo JText::_('COM_MGT_ONLINE_FILTER_ROUTE'); ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
                <br>
                <a href="<?php echo JRoute::_('index.php?option=com_mgt&view=filter&Itemid=263');?>">Сбросить</a>
            </td>
        </tr>
    </table>
</form>