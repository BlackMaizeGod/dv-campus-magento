<?php

declare(strict_types = 1);

namespace Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \Arteml\InteractiveChat\Model\InteractiveChatMessage::class,
            \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage::class
        );
    }
}
