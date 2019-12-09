<?php

declare(strict_types=1);

namespace GeekHub\RegistrationForm\Block;

/**
 * This class extend vendor class
 *
 * @inheritDoc
 */
class Data extends \Magento\Directory\Block\Data
{
    /**
     * Returns country id
     *
     * @inheritDoc
     * @return     string
     */
    public function getCountryId()
    {
        $countryId = $this->getData('modal_dealer_country');
        if ($countryId === null) {
            $countryId = $this->directoryHelper->getDefaultCountry();
        }
        return $countryId;
    }
}
