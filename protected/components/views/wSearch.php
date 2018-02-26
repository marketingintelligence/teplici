<form name="authform" id="authform" action="<?=$this->controller->createUrl('search/index')?>" method="POST">
	<div class="cap-search">
		<input type="text" id="searchWord" name="searchWord" value="<?=$word?>" />
	</div>
	<div class="fl">
	    <button type="submit" class="lupa"><img src="/img/01_search-button.png" width="12" height="15" alt=""/></button>
	</div>
	<div class="clear">&nbsp;</div>
</form>
