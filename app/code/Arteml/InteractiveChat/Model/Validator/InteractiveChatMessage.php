<?php

declare(strict_types=1);

namespace Arteml\InteractiveChat\Model\Validator;

class InteractiveChatMessage extends \Arteml\InteractiveChat\Model\Validator\Factory
{
    /**
     * Create author_name validator
     *
     * @return \Magento\Framework\Validator
     */
    public function createAuthorNameValidator(): \Magento\Framework\Validator
    {
        $errorMessage = __(
            'Name must be longer than 3 characters, less than 20 characters and contains only A-z letter and space symbol'
        );

        $builder = $this->_validatorBuilderFactory->create(
            \Magento\Framework\Validator\Builder::class,
            [
                'constraints' => [
                    [
                        'alias' => 'Regex',
                        'type' => '',
                        'class' => \Magento\Framework\Validator\Regex::class,
                        'options' => [
                            'arguments' => [
                                'pattern' => '/^[a-z A-z]{3,20}$/'
                            ],
                            'methods' => [
                                [
                                    'method' => 'setMessages',
                                    'arguments' => [
                                        [
                                            \Magento\Framework\Validator\Regex::NOT_MATCH => $errorMessage,
                                            \Magento\Framework\Validator\Regex::INVALID => $errorMessage
                                        ]
                                    ],
                                ],
                            ],
                        ]
                    ]
                ]
            ]
        );
        return $builder->createValidator();
    }

    /**
     * Create message validator
     *
     * @return \Magento\Framework\Validator
     */
    public function createMessageValidator(): \Magento\Framework\Validator
    {
        $errorMessageStringShort = __(
            'Message length could not be less than 5 characters'
        );

        $errorMessageStringLong = __(
            'Message length could not be more than 255 characters'
        );

        $builder = $this->_validatorBuilderFactory->create(
            \Magento\Framework\Validator\Builder::class,
            [
                'constraints' => [
                    [
                        'alias' => 'StringLength',
                        'type' => '',
                        'class' => \Magento\Framework\Validator\StringLength::class,
                        'options' => [
                            'arguments' => [
                                'options' => [
                                    'min' => 5,
                                    'max' => 255
                                ]
                            ],
                            'methods' => [
                                [
                                    'method' => 'setMessages',
                                    'arguments' => [
                                        [
                                            \Magento\Framework\Validator\StringLength::TOO_SHORT => $errorMessageStringShort,
                                            \Magento\Framework\Validator\StringLength::TOO_LONG => $errorMessageStringLong
                                        ]
                                    ],
                                ],
                            ],
                        ]
                    ]
                ]
            ]
        );
        return $builder->createValidator();
    }
}