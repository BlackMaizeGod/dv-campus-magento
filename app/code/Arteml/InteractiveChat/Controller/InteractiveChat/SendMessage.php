<?php

declare(strict_types=1);

namespace Arteml\InteractiveChat\Controller\InteractiveChat;

class SendMessage extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \Arteml\InteractiveChat\Model\InteractiveChatMessageFactory $chatMessageFactory
     */
    private $chatMessageFactory;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface $encryptor
     */
    private $encryptor;

    /**
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Arteml\InteractiveChat\Model\InteractiveChatMessageFactory $chatMessageFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Arteml\InteractiveChat\Model\InteractiveChatMessageFactory $chatMessageFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->chatMessageFactory = $chatMessageFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->encryptor = $encryptor;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     * @return \Magento\Framework\App\ResponseInterface|void
     * url: ajax-interactive-chat/interactiveChat/sendMessage
     */
    public function execute()
    {
        $request = $this->getRequest();

        if (!$request->isAjax()) {
            $norouteUrl = $this->_url->getUrl('noroute');
            return $this->_forward($norouteUrl);
        }

        $resultJson = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $response = 'Your question has been sent to the administrator successfully';

        $canSave = true;

        if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
            $response = 'Something went wrong, try again later, please';
            $resultJson->setHttpResponseCode(\Magento\Framework\Webapi\Exception::HTTP_BAD_REQUEST);
            $canSave = false;
        }

        if ($canSave) {
            try {
                /**@var \Arteml\InteractiveChat\Model\InteractiveChatMessage $message */
                $chatMessage = $this->chatMessageFactory->create();
                $currentCustomer = $this->customerSession->getCustomer();
                $customerName = count($currentCustomer->getData())
                    ? $currentCustomer->getName()
                    : $request->getParam('customer_name');

                $this->customerSession->getData('customer_hash')
                ?? $this->customerSession->setData(
                    'customer_hash',
                    $this->encryptor->encrypt($this->customerSession->getSessionId())
                );

                $chatMessage->setAuthorType('customer')
                    ->setAuthorId($currentCustomer !== null ? $currentCustomer->getId() : null)
                    ->setAuthorName($customerName)
                    ->setMessage($request->getParam('message'))
                    ->setWebsiteId($this->storeManager->getWebsite()->getId())
                    ->setChatHash($this->customerSession->getData('customer_hash'))
                    ->setCreatedAt($request->getParam('datetime'));
                $chatMessage->save();
            } catch (\Exception $e) {
                $response = $e->getMessage();
                $resultJson->setHttpResponseCode(\Magento\Framework\Webapi\Exception::HTTP_BAD_REQUEST);
            }
        }

        return $resultJson->setData($response);
    }
}
