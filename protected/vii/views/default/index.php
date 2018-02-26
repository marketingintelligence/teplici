<h1>И так, приступим!</h1>

<p>
	Можешь выбрать один из доступных генераторов:
</p>
<ul>
	<?php foreach($this->module->controllerMap as $name=>$config): ?>
	<li><?php echo CHtml::link(ucwords('Генератор "<strong>'.ucfirst(CHtml::encode($name)).'</strong>"'),array('/vii/'.$name));?></li>
	<?php endforeach; ?>
</ul>

