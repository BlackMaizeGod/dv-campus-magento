<?php

declare(strict_types=1);

namespace GeekHub\RegistrationForm\Block\Widget;

/**
 * This class extend vendor class
 *
 * @inheritDoc
 */
class Name extends \Magento\Customer\Block\Widget\Name
{
    /**
     * Sets the template
     *
     * @return void
     */
    public function _construct()
    {
        \Magento\Customer\Block\Widget\AbstractWidget::_construct();

        // default template location
        $this->setTemplate('GeekHub_RegistrationForm::widget/name.phtml');
    }
}
