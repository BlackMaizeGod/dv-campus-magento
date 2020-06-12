<?php

declare(strict_types=1);

namespace Arteml\InteractiveChat\Model\Validator;

class Factory
{
    /**
     * @var \Magento\Framework\Validator\UniversalFactory
     */
    protected $_validatorBuilderFactory;

    /**
     * @param \Magento\Framework\Validator\UniversalFactory $validatorBuilderFactory
     */
    public function __construct(\Magento\Framework\Validator\UniversalFactory $validatorBuilderFactory)
    {
        $this->_validatorBuilderFactory = $validatorBuilderFactory;
    }
}