<?php
    if (!isset($counter)) {
        $counter = array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        );
    } elseif (is_string($counter)) {
        $counter = array('format' => $counter);
    }
?>

<?php if ($counter): ?>
    <p><?php echo $this->Paginator->counter($counter); ?></p>
<?php endif; ?>

<ul class="pagination">
    <?php echo $this->Paginator->prev('< ' . __('Previous')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next(__('Next') . ' >'); ?>
</ul>