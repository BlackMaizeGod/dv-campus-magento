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
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->formKeyValidator = $formKeyValidator;
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

        $message = $request->getParam('message');

        $resultJson = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $response = 'Your question has been sent to the administrator successfully';

        if ($this->validateForm($request, $message)) {
            $response = $this->validateForm($request, $message);
            $resultJson->setHttpResponseCode(\Magento\Framework\Webapi\Exception::HTTP_BAD_REQUEST);
        }

        return $resultJson->setData($response);
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param string $message
     * @return string
     */
    private function validateForm($request, $message): string
    {
        $validationText = '';

        if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
            $validationText = 'Something went wrong. Probably you were away for quite a long time already. Please, reload the page and try again.';
        }

        if (strlen($message) < 10) {
            $validationText = 'Message length could not be less than 10 characters';
        }

        if (strlen($message) > 255) {
            $validationText = 'Message length could not be more than 255 characters';
        }

        return $validationText;
    }

}
