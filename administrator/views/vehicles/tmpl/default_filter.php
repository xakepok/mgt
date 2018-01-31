<?php
defined('_JEXEC') or die;
?>
<div>
    <label for="filter_search"><?php echo JText::_('COM_MGT_BORT_NUM'); ?></label>
    <input type="text" autocomplete="off" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_MGT_BORT_NUM'); ?>" />
    <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
    <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
</div>
