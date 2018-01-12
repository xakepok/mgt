<?php
use Joomla\CMS\HTML\HTMLHelper;
defined('_JEXEC') or die;

HTMLHelper::_('script', 'com_mgt/script.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('stylesheet', 'com_mgt/style.css', array('version' => 'auto', 'relative' => true));
?>
<p>
	<?php if (!empty($this->text) && gettype($this->text) == 'array')
	{
	?>
    <table>
        <thead>
        <tr>
            <th>
				<?php echo JText::_('COM_MGT_ONLINE_VEHICLE'); ?>
            </th>
            <th>
				<?php echo JText::_('COM_MGT_ONLINE_ROUTE'); ?>
            </th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ($this->text as $uniqueid => $value): ?>
            <tr>
                <td>
					<?php echo MgtHelper::convertBort('view', $value['vehicle']); ?>
                </td>
                <td>
					<?php echo $value['route']; ?>
                </td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>
<?php
}
if (!empty($this->text) && gettype($this->text) == 'string') echo $this->text;
if (empty($this->text)) echo JText::_('COM_MGT_STAT_ERROR_EMPTY');
?>
</p>
