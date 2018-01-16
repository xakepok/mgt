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
			    <?php echo JText::_('COM_MGT_ONLINE_FILTER_PARK'); ?>
            </td>
            <td>
                <select name="park">
                    <option value="" <?php if ($this->park == '') echo ' selected';?>>Все</option>
                    <option value="01" <?php if ($this->park == '01') echo ' selected';?>>1</option>
                    <option value="03" <?php if ($this->park == '03') echo ' selected';?>>3</option>
                    <option value="04" <?php if ($this->park == '04') echo ' selected';?>>4</option>
                    <option value="08" <?php if ($this->park == '08') echo ' selected';?>>8</option>
                    <option value="14" <?php if ($this->park == '14') echo ' selected';?>>14</option>
                    <option value="15" <?php if ($this->park == '15') echo ' selected';?>>15</option>
                    <option value="16" <?php if ($this->park == '16') echo ' selected';?>>16</option>
                    <option value="17" <?php if ($this->park == '17') echo ' selected';?>>17</option>
                    <option value="19" <?php if ($this->park == '19') echo ' selected';?>>19</option>
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
            <td colspan="2">
                <input type="submit" value="<?php echo JText::_('COM_MGT_ONLINE_FILTER_APPLY'); ?>"><br>
                <div><span id="mgt-alert"></span></div>
            </td>
        </tr>
    </table>
</form>
<p><a href="<?php echo JRoute::_('index.php?option=com_mgt&view=mgt'); ?>">Сбросить</a></p>