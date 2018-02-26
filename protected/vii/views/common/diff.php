<?php if($diff===false): ?>
	<div class="error">Diff недоступен для этого типа файла.</div>
<?php elseif(empty($diff)): ?>
	<div class="error">Нет изменений.</div>
<?php else: ?>
	<div class="content">
		<pre class="diff"><?php echo $diff; ?></pre>
	</div>
<?php endif; ?>
