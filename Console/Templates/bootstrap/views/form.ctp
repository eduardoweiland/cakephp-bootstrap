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
                                <li><?php echo "<?php echo \$this->Form->postLink(__('<span class=\"glyphicon glyphicon-remove\"></span>&nbsp;&nbsp;Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('escape' => false), __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))); ?>"; ?></li>
                            <?php endif; ?>
                            <li><?php echo "<?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-list\"></span>&nbsp;&nbsp;List " . $pluralHumanName . "'), array('action' => 'index'), array('escape' => false)); ?>"; ?></li>
                            <?php
                            $done = array();
                            foreach ($associations as $type => $data) {
                                foreach ($data as $alias => $details) {
                                    if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                                        echo "        <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-list\"></span>&nbsp;&nbsp;List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('escape' => false)); ?> </li>\n";
                                        echo "        <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-plus\"></span>&nbsp;&nbsp;New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('escape' => false)); ?> </li>\n";
                                        $done[] = $details['controller'];
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?php echo "            <?php echo \$this->Form->create('{$modelClass}', array('role' => 'form')); ?>\n\n"; ?>
            <?php
            foreach ($fields as $field) {
                if (strpos($action, 'add') !== false && $field == $primaryKey) {
                    continue;
                }
                elseif (!in_array($field, array('created', 'modified', 'updated'))) {
                    echo "                <div class=\"form-group\">\n";
                    echo "                    <?php echo \$this->Form->input('{$field}', array('class' => 'form-control', 'placeholder' => '" . Inflector::humanize($field) . "'));?>\n";
                    echo "                </div>\n";
                }
            }
            if (!empty($associations['hasAndBelongsToMany'])) {
                foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
                    echo "                <div class=\"form-group\">\n";
                    echo "                    <?php echo \$this->Form->input('{$assocName}', array('class' => 'form-control', 'placeholder' => '" . Inflector::humanize($field) . "'));?>\n";
                    echo "                </div>\n";
                }
            }
            ?>
            <?php
            echo "                <div class=\"form-group\">\n";
            echo "                    <?php echo \$this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>\n";
            echo "                </div>\n\n";

            echo "            <?php echo \$this->Form->end() ?>\n\n";
            ?>
        </div>
    </div>
</div>
