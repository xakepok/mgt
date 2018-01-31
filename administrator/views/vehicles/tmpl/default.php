<?php
defined('_JEXEC') or die;
$action = JRoute::_('index.php?option=com_mgt&view=vehicles');
JHtml::_('behavior.formvalidation');
?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
    <form action="<?php echo $action; ?>" method="post" name="adminForm" id="adminForm">
        <fieldset>
            <?php echo $this->loadTemplate('filter');?>
        </fieldset>
        <br>
        <div>
            <table class="table table-striped">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
            </table>
        </div>
        <div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $this->escape($this->state->get('list.ordering')); ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $this->escape($this->state->get('list.direction')); ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>
