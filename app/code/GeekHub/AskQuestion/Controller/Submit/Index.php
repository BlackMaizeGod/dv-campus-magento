<?php

declare(strict_types=1);

namespace GeekHub\AskQuestion\Controller\Submit;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Index
 *
 * @package GeekHub\AskQuestion\Controller\Submit
 */
class Index extends \Magento\Framework\App\Action\Action
{
    private const STATUS_ERROR = 'Error';

    private const STATUS_SUCCESS = 'Success';

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \GeekHub\AskQuestion\Validator\UaPhone $phoneUaValidator
     */
    private $phoneUaValidator;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\Action\Context $context
     * @param \GeekHub\AskQuestion\Validator\UaPhone $phoneUaValidator
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\App\Action\Context $context,
        \GeekHub\AskQuestion\Validator\UaPhone $phoneUaValidator
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->phoneUaValidator = $phoneUaValidator;
    }

    /**
     * Execute method
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $request = $this->getRequest();
        $request->getParam('name');
        try {
            //Security form validation
            if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
                throw new LocalizedException(__('Something went wrong. Probably you were away for quite a long time already. Please, reload the page and try again.'));
            }
            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }
            //Form field validation
            $error = false;

            if (!\Zend_Validate::is(trim($request->getParam('name')), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($request->getParam('email')), 'EmailAddress')) {
                $error = true;
            }
            if (!$this->phoneUaValidator->isValid(trim($request->getParam('phone_number')))) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($request->getParam('question')), 'NotEmpty')) {
                $error = true;
            }
            if ($error) {
                throw new LocalizedException(__('Form field is incorrect, please check it and submit again'));
            }

            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => 'Your request was submitted.'
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }
        /**
         * Result controller
         *
         * @var \Magento\Framework\Controller\Result\Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $controllerResult->setData($data);
    }
}
