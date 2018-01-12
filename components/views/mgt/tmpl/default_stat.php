<?php echo "<p>", JText::_('COM_MGT_STAT_SYNC'), ":</p>"; ?>
<div class="mgt-stat">
	<?php echo JText::_('COM_MGT_STAT_SYNC_TIME'), ": ", $this->stat['lastTime']; ?><br>
	<?php echo JText::_('COM_MGT_STAT_SYNC_UNIQUEID'), ": ", $this->stat['lastID']; ?><br>
	<?php echo JText::_('COM_MGT_STAT_SYNC_TOTAL'), ": ", $this->stat['total']; ?>
</div>
