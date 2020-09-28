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
     * @var \Magento\Framework\Validator\DataObjectFactory $validatorComposite
     */
    private $validatorComposite;

    /**
     * @var \Arteml\InteractiveChat\Model\Validator\InteractiveChatMessage $validatorFactory
     */
    private $validatorFactory;

    /**
     * InteractiveChatMessage constructor.
     * @param \Magento\Framework\Validator\DataObjectFactory $validatorCompositeFactory
     * @param Validator\InteractiveChatMessage $validatorFactory
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Validator\DataObjectFactory $validatorCompositeFactory,
        \Arteml\InteractiveChat\Model\Validator\InteractiveChatMessage $validatorFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->validatorComposite = $validatorCompositeFactory->create();
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\Arteml\InteractiveChat\Model\ResourceModel\InteractiveChatMessage::class);
    }

    /**
     * @return \Zend_Validate_Interface|null
     */
    protected function _getValidationRulesBeforeSave(): ?\Zend_Validate_Interface
    {
        $this->validatorComposite->addRule(
            $this->validatorFactory->createAuthorNameValidator(),
            'author_name'
        )->addRule(
            $this->validatorFactory->createMessageValidator(),
            'message'
        );

        return $this->validatorComposite;
    }
}
