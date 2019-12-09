<?php

declare(strict_types=1);

namespace GeekHub\RegistrationForm\Block\Widget;

/**
 * This class extend vendor class
 *
 * @inheritDoc
 */
class Fax extends \Magento\Customer\Block\Widget\Fax
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
        $this->setTemplate('GeekHub_RegistrationForm::widget/fax.phtml');
    }

}
