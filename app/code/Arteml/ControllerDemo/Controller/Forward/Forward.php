<?php
declare(strict_types=1);

namespace Arteml\ControllerDemo\Controller\Forward;

class Forward extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @inheritDoc
     * https://artem-lohvynenko.local/about-me/forward/forward
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $forward */
        $forward = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_FORWARD);
        return $forward
            ->setModule('about-me')
            ->setController('data')
            ->setParams([
                'first_name' => 'Artem',
                'last_name' => 'Lohvynenko',
                'repository' => 'https://github.com/BlackMaizeGod/dv-campus-magento'
            ])
            ->forward('data');
    }
}
