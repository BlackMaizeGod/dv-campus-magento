<?php
declare(strict_types = 1);

namespace Arteml\ControllerDemo\Controller\Data;

class Data extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @inheritDoc
     * https://artem-lohvynenko.local/about-me/data/data
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Layout $response */
        $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        return $response;
    }
}
