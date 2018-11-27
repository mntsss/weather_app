<?php
/**
 * Created by PhpStorm.
 * User: mantas
 * Date: 18.11.27
 * Time: 00.11
 */

namespace App\Command\Service;


class AdultCheckService
{
    public function isAdult(int $age): bool
    {
        return $age >= 18;
    }
}