<?php

declare(strict_types = 1);

namespace Arteml\InteractiveChat\Model;

/**
 * @method int getMessageId()
 * @method $this setMessageId(int $messageId)
 * @method string getAuthorType()
 * @method $this setAuthorType(string $authorType)
 * @method int getAuthorId()
 * @method $this setAuthorId(int $authorId)
 * @method string getAuthorName()
 * @method $this setAuthorName(string $authorName)
 * @method string getMessage()
 * @method $this setMessage(string $message)
 * @method int getWebsiteId()
 * @method $this setWebsiteId(int $websiteId)
 * @method string getChatHash()
 * @method $this setChatHash(string $chatHash)
 * @method string getCreatedAt()
 * @method $this setCreatedAt(string $date)
 */
class InteractiveChatMessage extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage::class);
    }

    /**
     * @return $this
     */
    public function beforeSave(): self
    {
        // @TODO: see the AbstractModel::validateBeforeSave() method and its' implementation for better implementation

        // Allow changing data before save
        parent::beforeSave();

        return $this;
    }
}
