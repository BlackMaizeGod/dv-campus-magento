<?php
declare(strict_types=1);


namespace Arteml\ControllerDemo\Controller;

class Forward extends \Magento\Framework\App\Action\Action
{
    /**
     * @inheritDoc
     * https://artem-lohvynenko.local/forward/forward
     */
    public function execute()
    {
        throw new \RuntimeException('dasdasdasdas');
    }
}
