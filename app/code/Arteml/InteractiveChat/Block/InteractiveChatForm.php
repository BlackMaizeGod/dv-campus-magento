<?php

declare(strict_types=1);

namespace Arteml\InteractiveChat\Block;

class InteractiveChatForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session $session
     */
    private $session;

    /**
     * InteractiveChatForm constructor.
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->session = $session;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isCustomerLoggedIn(): bool
    {
        return (bool)$this->session->getCustomerId();
    }
}