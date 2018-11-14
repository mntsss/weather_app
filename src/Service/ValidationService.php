<?php
/**
 * Created by PhpStorm.
 * User: mantas
 * Date: 18.11.14
 * Time: 01.14
 */

namespace App\Service;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ValidationService
{
    private $validator;

    private $violationMessages = [
      'date' => "Neteisingas datos formatas!",
      'date_greater_or_equal' => "Nurodyta data negali buti ankstesne nei siandienos!",
      'date_less_or_equal' => "Nurodyta data negali buti tolimesne nei menesis nuo siandienos!",
    ];

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateDate(string $date)
    {
        /**
         * Subtracting a day from current date so that validation would work on different time zones
         *  for today's weather regardless of server timezone settings
         * */

        $currentDate = (new \DateTime("-1 day"))->format("Y-m-d");


        $dateConstraint = new Assert\Date();
        $greaterOrEqualConstraint = new Assert\GreaterThanOrEqual($currentDate);

        $lessThanOrEqualConstraint = new Assert\LessThanOrEqual(
            (new \DateTime($currentDate))
                ->add(\DateInterval::createFromDateString("+1 month"))
                ->format("Y-m-d")
        );

        $dateConstraint->message = $this->violationMessages['date'];
        $greaterOrEqualConstraint->message = $this->violationMessages['date_greater_or_equal'];
        $lessThanOrEqualConstraint->message = $this->violationMessages['date_less_or_equal'];

        $errors = $this->validator->validate($date,
            array(
                $dateConstraint,
                $lessThanOrEqualConstraint,
                $greaterOrEqualConstraint
            )
        );

        return $errors;
    }
}