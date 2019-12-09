<?php

declare(strict_types=1);

namespace GeekHub\RegistrationForm\Block\Widget;

/**
 * This class extend vendor class
 *
 * @inheritDoc
 */
class Dob extends \Magento\Customer\Block\Widget\Dob
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
        $this->setTemplate('GeekHub_RegistrationForm::widget/dob.phtml');
    }
    /**
     * This method returns id
     *
     * @return string
     */
    public function getHtmlId(): string
    {
        return 'modal_dealer_dob';
    }

    /**
     * Create correct date field
     *
     * @return string
     */
    public function getFieldHtml()
    {
        $this->dateElement->setData(
            [
            'extra_params' => $this->getHtmlExtraParams(),
            'name' => 'dob',
            'id' => $this->getHtmlId(),
            'class' => $this->getHtmlClass(),
            'value' => $this->getValue(),
            'date_format' => $this->getDateFormat(),
            'image' => $this->getViewFileUrl('Magento_Theme::calendar.png'),
            'years_range' => '-120y:c+nn',
            'max_date' => '-1d',
            'change_month' => 'true',
            'change_year' => 'true',
            'show_on' => 'both',
            'first_day' => $this->getFirstDay()
            ]
        );
        return $this->dateElement->getHtml();
    }
}

