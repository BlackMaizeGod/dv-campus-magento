<?php

declare(strict_types=1);

namespace Arteml\InteractiveChat\Observer;

class BindCustomerIdToChat implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\CollectionFactory $collectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private $logger;

    /**
     * BindCustomerIdToChat constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\CollectionFactory $collectionFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\CollectionFactory $collectionFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $chatHash = $this->customerSession->getData('customer_hash');
        $event = $observer->getEvent();
        /** @var \Magento\Customer\Model\Data\Customer $customer */
        $customer = $event->getData('customer');
        $customerId = $customer->getId();

        if (!$chatHash || !$customerId) {
            return;
        }

        $messages = $this->getMessagesCollectionByChatHash($chatHash);

        /** @var \Arteml\InteractiveChat\Model\InteractiveChatMessage $message */
        foreach ($messages as $message) {
            $message->setAuthorId($customerId);
        }

        try {
            $messages->save();
        } catch (\RuntimeException $exception) {
            $this->logger->error('Customer Id didnt add to messages. ' . $exception->getMessage());
        }
    }

    /**
     * @param string $hash
     * @return \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\Collection
     */
    private function getMessagesCollectionByChatHash(
        string $hash
    ): \Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage\Collection {
        $messagesCollection = $this->collectionFactory->create();
        $messagesCollection->addFieldToFilter('chat_hash', $hash)
            ->addFieldToFilter('author_id', ['null' => true]);

        return $messagesCollection;
    }
}