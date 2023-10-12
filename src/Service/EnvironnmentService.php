<?php

namespace App\Service;

use Symfony\Component\HttpKernel\KernelInterface;

class EnvironnmentService
{
    private $environnment;
    
    public function __construct(KernelInterface $kernelInterface){
        $this->environnment = $kernelInterface->getEnvironment();
    }

    /**
     * Get the value of environnment
     */ 
    public function getEnvironnment()
    {
        return $this->environnment;
    }
}
