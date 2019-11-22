<?php
declare(strict_types=1);

namespace Arteml\ControllerDemo\Block\Info;

class AboutMe extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getRequest()->getParam('first_name') . ' ' . $this->getRequest()->getParam('last_name');
    }

    /**
     * @return string
     */
    public function getRepository(): string
    {
        return $this->getRequest()->getParam('repository');
    }

}
