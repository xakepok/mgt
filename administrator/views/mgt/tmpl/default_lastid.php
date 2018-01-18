<?php
defined('_JEXEC') or die;
?>
<form action="<?php echo JRoute::_('index.php'); ?>" method="get">
	<h3><?php echo JText::_('COM_MGT_SET_LAST_ID_AND_PARK');?></h3>
	<table>
		<tbody>
		<tr>
			<td>
				<?php echo JText::_('COM_MGT_SET_LAST_ID_LABEL'); ?>
			</td>
			<td>
				<input type="number" name="uniqueid" minlength="6" maxlength="7">
			</td>
		</tr>
		<tr>
			<td>
				<?php echo JText::_('COM_MGT_SET_LAST_PARK_LABEL'); ?>
			</td>
			<td>
				<input type="number" name="srv_id" minlength="2" maxlength="3">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="<?php echo JText::_('COM_MGT_BUTTON_SETUP_LABEL'); ?>">
                <?php
                echo JHtml::link(JRoute::_('index.php?option=com_mgt&task=mgt.truncateOnline'), JText::_('COM_MGT_BUTTON_CLEAR_LABEL'));
                ?>
			</td>
		</tr>
		</tbody>
	</table>
	<input type="hidden" name="option" value="com_mgt">
	<input type="hidden" name="task" value="mgt.setLastID">
</form>
