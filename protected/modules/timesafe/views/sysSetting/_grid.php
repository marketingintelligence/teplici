<?php $provider = $model->search(); ?>
<div class="inner" id="sys-setting-grid-inner">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'sys-setting-grid',
		'summaryText' => '{start} - {end} из {count}',
		'emptyText' => 'Ничего пока нет.',
		'updateSelector' => '#sys-setting-grid-actions .pagination a, #sys-setting-grid .table thead th a, .filter a',
		'afterAjaxUpdate' => "js:function(id, data){var id = '#' + id + '-actions'; \$(id).replaceWith(\$(id, '<div>' + data + '</div>'));$('.toggle-on-check').toggleit();}",
		'selectableRows' => 2,
		'showTableOnEmpty' => false,
		'dataProvider' => $provider,
		'cssFile' => false,
		'itemsCssClass' => 'table',
		'pagerCssClass' => 'pagination',
		'template' => '{items}',
		'columns' => array(
            array(
				'class' => 'CCheckBoxColumn',
			),
			'title',
			'name',
			'type',
			array(
				'class' => 'EButtonColumn',
				'deleteConfirmation' => 'Вы действительно хотите удалить эту запись?',
			),
		),
	)); ?>
	<div class="actions-bar wat-cf" id="sys-setting-grid-actions">
		<div class="actions">
			<button class="button action-create" type="button">
				<?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/create.png', 'Добавить'); ?> Добавить 
			</button>
            <button class="button action-many action-delete" type="button" rel=".block-delete">
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/delete.png', 'Удалить'); ?> Удалить 
			</button>
		</div>
		<?php $this->widget('application.components.widgets.ELinkPager', array(
			'cssFile' => false,
			'pages' => $provider->getPagination(),
		)); ?>
	</div>
</div>
