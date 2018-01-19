<?php
echo "<p>", JText::_('COM_MGT_ONLINE_FILTER'), ":</p>";
?>
<form action="<?php echo JRoute::_('index.php?option=com_mgt&view=mgt'); ?>" id="mgt-filter" method="get" enctype="application/x-www-form-urlencoded">
    <table>
        <tr>
            <td>
			    <?php echo JText::_('COM_MGT_ONLINE_DATE_BETWEEN'); ?>
            </td>
            <td>
                <input type="date" name="date_1" value="<?php echo MgtHelper::getDateFromUrl('date_1'); ?>" min="2017-12-12" max="<?php echo MgtHelper::getCurrentDate('Y-m-d');?>" autocomplete="off"/>
                <br>
                <span class="mgt-cur-date"><?php echo JText::_('COM_MGT_ONLINE_COPY_DATE'); ?></span>
                <br>
                <input type="date" name="date_2" value="<?php echo MgtHelper::getDateFromUrl('date_2'); ?>" min="2017-12-12" max="<?php echo MgtHelper::getCurrentDate('Y-m-d');?>" autocomplete="off"/>
            </td>
        </tr>
        <tr>
            <td>
			    <?php echo JText::_('COM_MGT_FILTER_TRANSPORT_TYPE'); ?>
            </td>
            <td>
                <select name="type">
                    <option value="0" <?php if ($this->type == '0') echo ' selected';?>><?php echo JText::_('COM_MGT_FILTER_TYPE_BUS'); ?></option>
                    <option value="2" <?php if ($this->type == '2') echo ' selected';?>><?php echo JText::_('COM_MGT_FILTER_TYPE_TRAM'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
				<?php echo JText::_('COM_MGT_ONLINE_FILTER_VEHICLE'); ?>
            </td>
            <td>
                <input type="text" class="mgt-filter-field" name="vehicle" value="<?php echo $this->vehicle; ?>" minlength="4" maxlength="6" autocomplete="off"/>
            </td>
        </tr>
        <tr>
            <td>
				<?php echo JText::_('COM_MGT_ONLINE_FILTER_ROUTE'); ?>
            </td>
            <td>
                <input type="text" class="mgt-filter-field" name="route" value="<?php echo $this->route; ?>" maxlength="5" autocomplete="off"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="mgt-filter-unique"><?php echo JText::_('COM_MGT_FILTER_UNIQUE'); ?></label>
            </td>
            <td>
                <input type="checkbox" name="unique" value="1" <?php if ($this->unique) echo 'checked'; ?> id="mgt-filter-unique">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="<?php echo JText::_('COM_MGT_ONLINE_FILTER_APPLY'); ?>"><br>
                <div><span id="mgt-alert"></span></div>
            </td>
        </tr>
    </table>
</form>
<p><a href="<?php echo JRoute::_('index.php?option=com_mgt&view=mgt'); ?>">Сбросить</a></p>