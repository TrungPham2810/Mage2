<?php



namespace OpenTechiz\AdminNote\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;

class CustomSection implements SectionSourceInterface
{
    public function getSectionData()
    {
        return [
            'okdiem' =>'test section for customer need login acc to test',
        ];
    }
}
