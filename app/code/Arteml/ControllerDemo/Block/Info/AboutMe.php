<?php
declare(strict_types=1);


namespace Arteml\ControllerDemo\Block\AboutMe;

class AboutMe extends \Magento\Framework\View\Element\Template
{

    public function getFullName(): string
    {
        return $this->getRequest()->getParam('first_name') . ' ' . $this->getRequest()->getParam('last_name');
    }

    public function getRepository(): string
    {
        return $this->getRequest()->getParam('repository');
    }

}
