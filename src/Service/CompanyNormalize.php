<?php

namespace App\Service;

use App\Entity\Company;
use Symfony\Component\HttpFoundation\UrlHelper;

class CompanyNormalize {
    private $urlHelper;

    public function __construct(UrlHelper $constructorDeURL)
    {
        $this->urlHelper = $constructorDeURL;
    }

    /**
     * Normalize a company     
     * 
     * @param Company $company
     * 
     * @return array|null
     */
    public function companyNormalize (Company $company): ?array {
          
        return [
            'name' => $company->getName(),
            'email' => $company->getEmail(),
            'phone' => $company->getPhone(),
            'sector' => [
                'id' => $company->getSector()->getId(),
                'name' => $company->getSector()->getName(),
            ],
        ];
    }
}