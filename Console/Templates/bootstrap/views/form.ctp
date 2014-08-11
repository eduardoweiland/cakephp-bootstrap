<div class="<?php echo $pluralVar; ?> form">

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="actions">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo "<?php echo __('Actions') ?>" ?></div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
<?php if (strpos($action, 'add') === false): ?>
                            <li><?php echo "<?php echo \$this->Form->postLink(\$this->Html->icon('glyphicon-remove') . '&nbsp;&nbsp;' . __('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('escape' => false), __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))); ?>"; ?></li>
<?php endif; ?>
                            <li><?php echo "<?php echo \$this->Html->link(\$this->Html->icon('glyphicon-list') . '&nbsp;&nbsp;' . __('List " . $pluralHumanName . "'), array('action' => 'index'), array('escape' => false)); ?>"; ?></li>
<?php
    $done = array();
    foreach ($associations as $type => $data) {
        foreach ($data as $alias => $details) {
            if ($details['controller'] != $this->name && !in_array($details['controller'], $done)): ?>
                            <li><?php echo "<?php echo \$this->Html->link(\$this->Html->icon('glyphicon-list') . '&nbsp;&nbsp;' . __('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('escape' => false)); ?>" ?></li>
                            <li><?php echo "<?php echo \$this->Html->link(\$this->Html->icon('glyphicon-plus') . '&nbsp;&nbsp;' . __('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('escape' => false)); ?>" ?></li>
<?php
                $done[] = $details['controller'];
            endif;
        }
    }
?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?php echo "<?php echo \$this->Form->create('{$modelClass}', array('role' => 'form')); ?>\n\n";

            foreach ($fields as $field) {
                if (strpos($action, 'add') !== false && $field == $primaryKey) {
                    continue;
                }
                elseif (!in_array($field, array('created', 'modified', 'updated'))) {
                    echo "            <?php echo \$this->Form->input('{$field}'); ?>\n";
                }
            }
            if (!empty($associations['hasAndBelongsToMany'])) {
                foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
                    echo "            <?php echo \$this->Form->input('{$assocName}'); ?>\n";
                }
            }
            ?>

            <?php echo "<?php echo \$this->Form->end(__('Submit')) ?>\n"; ?>
        </div>
    </div>
</div>
