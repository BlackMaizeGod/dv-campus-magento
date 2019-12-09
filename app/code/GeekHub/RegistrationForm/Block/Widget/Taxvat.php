<?php

declare(strict_types=1);

namespace GeekHub\RegistrationForm\Block\Widget;

/**
 * This class extend vendor class
 *
 * @inheritDoc
 */
class Taxvat extends \Magento\Customer\Block\Widget\Taxvat
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
        $this->setTemplate('GeekHub_RegistrationForm::widget/taxvat.phtml');
    }
}
