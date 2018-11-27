<?php
/**
 * Created by PhpStorm.
 * User: mantas
 * Date: 18.11.27
 * Time: 00.10
 */

namespace App\Command\Service;


class ManagerService
{
    private $ageService;
    private $adultCheckService;

    /**
     * ManagerService constructor.
     * @param $ageService
     * @param $adultCheckService
     */
    public function __construct(AgeService $ageService, AdultCheckService $adultCheckService)
    {
        $this->ageService = $ageService;
        $this->adultCheckService = $adultCheckService;
    }

    public function printAge(string $birthDate): string
    {
        $age = $this->ageService->getAge($birthDate);

        return "I am $age years old";
    }

    public function checkIfAdult(string $birthDate): bool
    {
        $age = $this->ageService->getAge($birthDate);

        return $this->adultCheckService->isAdult($age);
    }
}