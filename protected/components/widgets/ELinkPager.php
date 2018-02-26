<?php
class ELinkPager extends CLinkPager
{
    public function run()
    {
        $this->registerClientScript();
        $buttons = $this->createPageButtons();
        if (empty($buttons)) {
            return;
        }
        $this->htmlOptions['class'] = trim($this->htmlOptions['class'] . ' pagination');
        echo CHtml::tag('div', $this->htmlOptions, implode("\n", $buttons));
    }

    protected function createPageCountButtons()
    {
        if (($pageCount = $this->getPageCount()) <= 1)
            return array();
        $buttons[] = $this->createPageCountButton(10, 10, self::CSS_INTERNAL_PAGE, false, $i == $currentPage);
    }

    protected function createPageCountButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden) {
            return false;
        }
        $class = str_replace(self::CSS_INTERNAL_PAGE, '', $class);
        $class .= ' ' . ($selected ? 'current active' : '');
        $class = trim($class);
        return $selected ? CHtml::tag('span', array('class' => $class), $label) : CHtml::link($label, $this->createPageUrl($page), array('class' => $class));
    }

    protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden) {
            return false;
        }
        $class = str_replace(self::CSS_INTERNAL_PAGE, '', $class);
        $class .= ' ' . ($selected ? 'current active' : '');
        $class = trim($class);
        return $selected ? CHtml::tag('span', array('class' => $class), $label) : CHtml::link($label, $this->createPageUrl($page), array('class' => $class));
    }
}
