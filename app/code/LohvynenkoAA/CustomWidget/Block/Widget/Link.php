<?php

declare(strict_types=1);

namespace LohvynenkoAA\CustomWidget\Block\Widget;

class Link extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'widget/link_to.phtml';

    public function getPathToPage()
    {
        return $this->getBaseUrl() . $this->getData('path_to_page');
    }
}
