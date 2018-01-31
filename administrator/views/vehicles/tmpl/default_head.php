<?php
defined('_JEXEC') or die;
$listOrder    = $this->escape($this->state->get('list.ordering'));
$listDirn    = $this->escape($this->state->get('list.direction'));
?>
<tr>
    <th width="1%" class="hidden-phone">
        <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
    </th>
    <th width="1%">
        <?php echo JHtml::_('grid.sort', 'COM_MGT_ID', 'id', $listDirn, $listOrder); ?>
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_MGT_UNIQUEID', 'uniqueid', $listDirn, $listOrder); ?>
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_MGT_SRV_ID', 'srv_id', $listDirn, $listOrder); ?>
    </th>
    <th>
        <?php echo JText::_('COM_MGT_TYPE'); ?>
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_MGT_BORT_NUM', 'bort', $listDirn, $listOrder); ?>
    </th>
</tr>