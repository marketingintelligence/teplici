<table width="100%">
    <tr>
        <td class="al">
            <div class="navigation">
                <a href="<?="<?"?>=$this->createUrl('create')?>" class="add">Добавить</a>
            </div>
        </td>
        <td class="ar">
            <div class="navigation">
                <a href="javascript:;" onclick="$('#_option').toggle()">Настройки</a>
            </div>
        </td>
    </tr>
</table>
<div id="_option" <?="<?"?>=$this->search!=null?'':'style="display:none;'?>">
    <table width="100%">
    <tr>
        <td class="al">
            <div class="navigation">
                <form action="" id="_search" method="post">
                Поиск:
                <input type="text" name="_search" id="_searchWord" value="<?="<?"?>=$this->search?>"/>
                <a href="javascript:;" onclick="$('#_search').submit()">Поиск</a>
                <?="<?"?> if($this->search!=null):?>
                <a href="javascript:;" onclick="$('#_searchWord').val('clear');$('#_search').submit()">Очистить</a>
                <?="<?"?> endif;?>
                </form>
            </div>
        </td>
        <td class="ar">
            <div class="navigation">
                Сортировка:
                <?="<?"?>=SHelper::sortLink('title','Название')?>
                <?="<?"?>=SHelper::sortLink('status','Статус')?>
                <?="<?"?>=SHelper::sortLink('created_at','Добавлен')?>
                <?="<?"?>=SHelper::sortLink('lastvisit_at','Визит')?>
            </div>
        </td>
    </tr>
</table>
</div>