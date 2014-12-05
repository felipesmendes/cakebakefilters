<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
debug($modelClass);
echo "<?php \$this->Html->addCrumb('{$modelClass}', array('controller' => '{$modelClass}', 'action' => 'index'));?>\n";
echo "<?php echo \$this->Html->script('tablecolumnfilter');\n?>";
?>
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="search">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#filter" aria-expanded="false" aria-controls="filter">
          <?php echo __("Filter");?>
        </a>
      </h4>
    </div>
    <div id="filter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="search">
      <div class="panel-body">
<?php echo "<?php echo \$this->Form->create('{$modelClass}',array('class' => 'form-horizontal','role' => 'form')); ?>\n"; ?>
<?php foreach ($fields as $field):
if(isset($schema[$field]["key"]) && $schema[$field]["key"] == 'index'){
	if($schema[$field]['type'] == 'date' || $schema[$field]['type'] == 'datetime' || $schema[$field]['type'] == 'timestamp'){
	?>
		<div class="form-group">
			<label for="label<?php echo $field?>" class="col-sm-2 control-label"><?php echo Inflector::humanize(Inflector::underscore($field));?></label>
			<div class="col-xs-6 col-sm-2 col-md-2">
			<?php echo "<?php \t\techo \$this->Form->input('{$field}',array('type'=>'text','id'=>'label".$field."','class'=>'form-control','label'=>false));?>\n"; ?>
			to 
			<?php echo "<?php \t\techo \$this->Form->input('{$field}_final',array('type'=>'text','id'=>'label".$field."','class'=>'form-control','label'=>false));?>\n"; ?>
			</div>
		</div>
		<?php
			}else{
		?>
		<div class="form-group">
			<label for="label<?php echo $field?>" class="col-sm-2 control-label"><?php echo Inflector::humanize(Inflector::underscore($field));?></label>
			<div class="col-xs-6 col-sm-2 col-md-2">
			<?php echo "<?php \t\techo \$this->Form->input('{$field}',array('id'=>'label".$field."','class'=>'form-control','label'=>false));?>\n"; ?>
			</div>
		</div>
	<?php 
	}
}
	?>
<?php endforeach;?>
<?php echo "<?php echo \$this->Form->button(\$this->Html->tag('span','&nbsp;'.__('Search'),array('class'=>'glyphicon glyphicon-search')),array('class'=>'btn btn-success')); ?>\n";?>

<?php echo "<?php echo \$this->Form->end(); ?>\n";?>
 	</div>
  </div>
</div>
<div class="<?php echo $pluralVar; ?> index">
	<h2><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h2>
	<table class="table table-bordered table-condensed table-hover">
	<thead>
	<tr>
	<?php foreach ($fields as $field): ?>
		<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
	<?php endforeach; ?>
		<th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
	</tr>
	<tr>
	<?php foreach ($fields as $field): ?>
		<td>
				<?php echo "<?php \t\techo \$this->Form->input('{$field}',array('id'=>'label".$field."','class'=>'form-control col-xs-6 col-sm-2 col-md-2 table_column_filter','label'=>false,'type'=>'text'));?>\n"; ?>
		</td>
	<?php endforeach; ?>
	</tr>
	</thead>
	<tbody>
	<?php
	echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}

		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t<div class=\"btn-group\" role=\"group\" aria-label=\"actions\">\n";
		echo "\t\t\t<?php echo \$this->Html->link(\$this->Html->tag('span',null,array('class'=>'glyphicon glyphicon-eye-open')), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>'btn btn-default btn-sm','escape'=>false)); ?>\n";
		echo "\t\t\t<?php echo \$this->Html->link(\$this->Html->tag('span',null,array('class'=>'glyphicon glyphicon-edit')), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>'btn btn-default btn-sm','escape'=>false)); ?>\n";
		echo "\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span',null,array('class'=>'glyphicon glyphicon-remove')), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'btn btn-default btn-sm','escape'=>false), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t</div>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
	</tbody>
	</table>
	<p>
	<?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>"; ?>
	</p>
	<ul class="pagination">
		<?php
		 echo "\t\t<?php echo \$this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href=\"#\">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));?>\n";
		 echo "\t\t<?php echo \$this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));?>\n";
		 echo "\t\t<?php echo \$this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href=\"#\">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));?>\n";
		?>
	</ul>
</div>
<div class="actions">
	<h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
	<div class="btn-group" role="group" aria-label="actions">
		<?php echo "<?php echo \$this->Html->link(\$this->Html->tag('span','&nbsp;'.__('New " . $singularHumanName . "'),array('class'=>'glyphicon glyphicon-plus')), array('action' => 'add'),array('class'=>'btn btn-default','escape'=>false)); ?>"; ?>
<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				?>
				<?php
				echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('span','&nbsp;'.__('List " . Inflector::humanize($details['controller']) . "'),array('class'=>'glyphicon glyphicon-list-alt')), array('controller' => '{$details['controller']}', 'action' => 'index'),array('class'=>'btn btn-default','escape'=>false)); ?>\n";
				echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('span','&nbsp;'.__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'),array('class'=>'glyphicon glyphicon-list-alt')), array('controller' => '{$details['controller']}', 'action' => 'add'),array('class'=>'btn btn-default','escape'=>false)); ?>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
	</div>
</div>
