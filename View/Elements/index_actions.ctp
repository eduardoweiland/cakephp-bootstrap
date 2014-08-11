<td class="actions">
    <div class="pull-right">
        <?php
            echo $this->Html->link($this->Html->icon('glyphicon-search') . '&nbsp;' . __('View'),
                array('action' => 'view',   $id), array('escape' => false, 'class' => 'btn btn-success btn-xs'));

            echo '&nbsp;' . $this->Html->link($this->Html->icon('glyphicon-edit') . '&nbsp;' . __('Edit'),
                array('action' => 'edit',   $id), array('escape' => false, 'class' => 'btn btn-primary btn-xs'));

            echo '&nbsp;' . $this->Form->postLink($this->Html->icon('glyphicon-remove') . '&nbsp;' . __('Delete'),
                array('action' => 'delete', $id), array('escape' => false, 'class' => 'btn btn-danger btn-xs'),
                __('Are you sure you want to delete %s?', $name));
        ?>
    </div>
</td>
