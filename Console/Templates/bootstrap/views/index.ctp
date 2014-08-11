<div class="<?php echo $pluralVar; ?> index">

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h1>
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
                            <li><?php echo "<?php echo \$this->Html->link(\$this->Html->icon('glyphicon-plus') . '&nbsp;&nbsp;' . __('New " . $singularHumanName . "'), array('action' => 'add'), array('escape' => false)); ?>"; ?></li>
<?php
                            $done = array();
                            foreach ($associations as $type => $data) {
                                foreach ($data as $alias => $details) {
                                    if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                                        echo "                            <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-list\"></span>&nbsp;&nbsp;List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('escape' => false)); ?> </li>\n";
                                        echo "                            <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-plus\"></span>&nbsp;&nbsp;New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('escape' => false)); ?> </li>\n";
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
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <thead>
                    <tr>
<?php foreach ($fields as $field): ?>
                        <th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
<?php endforeach; ?>
                        <th class="actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n"; ?>
                        <tr>
<?php
foreach ($fields as $field):
    $isKey = false;
    if (!empty($associations['belongsTo'])):
        foreach ($associations['belongsTo'] as $alias => $details):
            if ($field === $details['foreignKey']): ?>
                            <td>
                                <?php echo "<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n" ?>
                            </td>
<?php
                $isKey = true;
                break;
            endif;
        endforeach;
    endif;

    if ($isKey !== true): ?>
                            <td><?php echo "<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>" ?>&nbsp;</td>
<?php
    endif;
endforeach;
?>
                            <?php echo "<?php echo \$this->element('Bootstrap.index_actions', array (\n" ?>
                                <?php echo "'id'   => \${$singularVar}['{$modelClass}']['{$primaryKey}'],\n" ?>
                                <?php echo "'name' => \${$singularVar}['{$modelClass}']['{$displayField}']\n" ?>
                            <?php echo ")); ?>\n" ?>
                        </tr>
                    <?php echo "<?php endforeach; ?>\n"; ?>
                </tbody>
            </table>

            <?php echo "<?php echo \$this->element('Bootstrap.pagination'); ?>\n" ?>
        </div>
    </div>
</div>