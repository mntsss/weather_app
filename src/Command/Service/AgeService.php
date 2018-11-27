<?php
/**
 * Created by PhpStorm.
 * User: mantas
 * Date: 18.11.27
 * Time: 00.10
 */

namespace App\Command\Service;


class AgeService
{
    public function getAge(string $birthDate): int
    {
        $age = (new \DateTime($birthDate))->diff(new \DateTime('now'))->format('%y');

        return $age;
    }
}