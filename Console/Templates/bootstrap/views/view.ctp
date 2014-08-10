<div class="<?php echo $pluralVar ?> view">

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?php echo "<?php echo __('{$singularHumanName}'); ?>" ?></h1>
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
                            <?php
                                echo "        <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-edit\"></span>&nbsp&nbsp;Edit $singularHumanName'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape' => false)); ?> </li>\n";
                                echo "        <li><?php echo \$this->Form->postLink(__('<span class=\"glyphicon glyphicon-remove\"></span>&nbsp;&nbsp;Delete $singularHumanName'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape' => false), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?> </li>\n";
                                echo "        <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-list\"></span>&nbsp&nbsp;List $pluralHumanName'), array('action' => 'index'), array('escape' => false)); ?> </li>\n";
                                echo "        <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-plus\"></span>&nbsp&nbsp;New $singularHumanName'), array('action' => 'add'), array('escape' => false)); ?> </li>\n";

                                $done = array();
                                foreach ($associations as $type => $data) {
                                    foreach ($data as $alias => $details) {
                                        if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                                            echo "        <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-list\"></span>&nbsp&nbsp;List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('escape' => false)); ?> </li>\n";
                                            echo "        <li><?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-plus\"></span>&nbsp&nbsp;New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('escape' => false)); ?> </li>\n";
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
                <tbody>
                    <?php
                    foreach ($fields as $field) {
                        echo "<tr>\n";
                        $isKey = false;
                        if (!empty($associations['belongsTo'])) {
                            foreach ($associations['belongsTo'] as $alias => $details) {
                                if ($field === $details['foreignKey']) {
                                    $isKey = true;
                                    echo "        <th><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></th>\n";
                                    echo "        <td>\n            <?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n            &nbsp;\n        </td>\n";
                                    break;
                                }
                            }
                        }
                        if ($isKey !== true) {
                            echo "        <th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
                            echo "        <td>\n            <?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n            &nbsp;\n        </td>\n";
                        }
                        echo "</tr>\n";
                    }
                    ?>
                </tbody>
            </table>

        </div>

    </div>
</div>

<?php
if (!empty($associations['hasOne'])) :
    foreach ($associations['hasOne'] as $alias => $details):
        ?>
        <div class="row related">
            <div class="col-md-12">
                <h3><?php echo "<?php echo __('Related " . Inflector::humanize($details['controller']) . "'); ?>"; ?></h3>
                <table class="table table-striped">
                    <tbody>
                        <?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
                        <tr>
                            <?php
                            foreach ($details['fields'] as $field) {
                                echo "        <th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
                                echo "        <td>\n    <?php echo \${$singularVar}['{$alias}']['{$field}']; ?>\n&nbsp;</td>\n";
                            }
                            ?>
                        </tr>
                        <?php echo "<?php endif; ?>\n"; ?>
                    </tbody>
                </table>
                <div class="actions">
                    <?php echo "<?php echo \$this->Html->link(__('Edit " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('escape' => false, 'class' => 'btn btn-default')); ?>\n"; ?>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
if (empty($associations['hasMany'])) {
    $associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
    $associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize($details['controller']);
    ?>
    <div class="related row">
        <div class="col-md-12">
            <h3><?php echo "<?php echo __('Related " . $otherPluralHumanName . "'); ?>"; ?></h3>
            <?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
            <table cellpadding = "0" cellspacing = "0" class="table table-striped">
                <thead>
                    <tr>
                        <?php
                        foreach ($details['fields'] as $field) {
                            echo "        <th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
                        }
                        ?>
                        <th class="actions"></th>
                    </tr>
                <thead>
                <tbody>
                    <?php
                    echo "    <?php foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
                    echo "        <tr>\n";
                    foreach ($details['fields'] as $field) {
                        echo "            <td><?php echo \${$otherSingularVar}['{$field}']; ?></td>\n";
                    }

                    echo "            <td class=\"actions\">\n";
                    echo "                <?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-search\"></span>'), array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape' => false)); ?>\n";
                    echo "                <?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-edit\"></span>'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape' => false)); ?>\n";
                    echo "                <?php echo \$this->Form->postLink(__('<span class=\"glyphicon glyphicon-remove\"></span>'), array('controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape' => false), __('Are you sure you want to delete # %s?', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
                    echo "            </td>\n";
                    echo "        </tr>\n";

                    echo "    <?php endforeach; ?>\n";
                    ?>
                </tbody>
            </table>
            <?php echo "<?php endif; ?>\n\n"; ?>
            <div class="actions">
                <?php echo "<?php echo \$this->Html->link(__('<span class=\"glyphicon glyphicon-plus\"></span>&nbsp;&nbsp;New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?>"; ?>
            </div>
        </div>
    </div>
<?php endforeach;
