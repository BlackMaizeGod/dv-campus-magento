<?php

namespace GeekHub\RegistrationForm\Block\Form;

/**
 * This class extend vendor class
 *
 * @inheritDoc
 */
class Register extends \Magento\Customer\Block\Form\Register
{
    /**
     * Retrieve form data
     *
     * @return mixed
     */
    public function getFormData()
    {
        $data = $this->getData('form_data');
        if ($data === null) {
            $formData = $this->_customerSession->getCustomerFormData(true);
            $data = new \Magento\Framework\DataObject();
            if ($formData) {
                $data->addData($formData);
                $data->setCustomerData(1);
            }
            if (isset($data['modal_dealer_region_id'])) {
                $data['modal_dealer_region_id'] = (int)$data['modal_dealer_region_id'];
            }
            $this->setData('form_data', $data);
        }
        return $data;
    }

    /**
     * Retrieve customer country identifier
     *
     * @return int
     */
    public function getCountryId()
    {
        $countryId = $this->getFormData()->getCountryId();
        if ($countryId) {
            return $countryId;
        }
        $countryId = $this->getData('modal_dealer_country');
        if ($countryId === null) {
            $countryId = $this->directoryHelper->getDefaultCountry();
        }
        return $countryId;
    }
}
