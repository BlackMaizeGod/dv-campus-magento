<?php
declare(strict_types = 1);

namespace GeekHub\RegistrationForm\Controller\Render;

class Render extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @inheritDoc
     * https://artem-lohvynenko.local/dealer-additional-form/render/render
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Layout $response */
        $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        return $response;
    }
}
