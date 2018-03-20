<?php

require_once 'Mobile_Detect.php';

class Detector extends Mobile_Detect
{
    
    public function isDesktop()
    {
        return (!self::isMobile() && !self::isTablet());
    }
    
}