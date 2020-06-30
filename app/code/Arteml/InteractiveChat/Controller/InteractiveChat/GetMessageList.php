<?php

declare(strict_types = 1);

namespace Arteml\InteractiveChat\Controller\InteractiveChat;

use Magento\Framework\App\Action\Context;

class GetMessageList extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\CollectionFactory $messagesCollectionFactory
     */
    private $messagesCollectionFactory;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * GetMessageList constructor.
     * @param \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\CollectionFactory $messagesCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param Context $context
     */
    public function __construct(
        \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\CollectionFactory $messagesCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        Context $context
    ) {
        $this->messagesCollectionFactory = $messagesCollectionFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * url: ajax-interactive-chat/interactiveChat/getMessageList
     */
    public function execute()
    {
        $request = $this->getRequest();

        if (!$request->isAjax()) {
            $norouteUrl = $this->_url->getUrl('noroute');
            return $this->_forward($norouteUrl);
        }

        $messageCount = (int) $request->getParam('message_count');

        $resultJson = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $response = $this->getMessages($messageCount);

        return $resultJson->setData(['messages' => $response]);
    }

    /**
     * @param int $count
     * @return array
     */
    private function getMessages(int $count): array
    {
        $orderByDate = new \Zend_Db_Expr('TIMESTAMP(created_at)');

        /**@var \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\Collection $collection */
        $collection = $this->messagesCollectionFactory->create();
        $collection->setOrder($orderByDate, 'DESC');
        if ($customerId = $this->customerSession->getCustomerId()) {
            $collection->addFieldToFilter('author_id', $customerId);
        } elseif ($chatHash = $this->customerSession->getData('customer_hash')) {
            $collection->addFieldToFilter('chat_hash', $chatHash);
        } else {
            return [];
        }
        $collection->setPageSize($count)
            ->load();

        return array_reverse($collection->getData());
    }
}
