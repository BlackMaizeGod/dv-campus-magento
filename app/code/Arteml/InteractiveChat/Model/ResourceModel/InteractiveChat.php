<?php

declare(strict_types = 1);

namespace Arteml\InteractiveChat\Model\ResourceModel;

class InteractiveChat extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('m2_dv_interactive_chat_report', 'message_id');
    }
}
