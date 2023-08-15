<?php

namespace OpenTechiz\PageBuilderExtend\Plugin\PageBuilder\Block;

class GoogleMapsApiPlugin
{
    public function aroundShouldIncludeGoogleMapsLibrary(\Magento\PageBuilder\Block\GoogleMapsApi $subject): bool
    {
        try {
            return boolval($subject->getApiKey());
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return false;
        }
    }
}
