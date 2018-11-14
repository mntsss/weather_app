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

    /**
     * ViolationMessages array for validation error messages
     * */

    private $violationMessages = [
      'date' => "Neteisingas datos formatas!",
      'date_greater_or_equal' => "Nurodyta data negali buti ankstesne nei siandienos!"
    ];

    /**
     * TODO autowiring configuration, DI through constructor doesnt work with ValidatorInterface
     */
    public function __construct(/*ValidatorInterface $validator*/)
    {
        /*$this->validator = $validator;*/
    }

    public function validateDate(string $date)
    {
        /**
         * Subtracting a day from current date so that validation would work on different time zones
         *  for today's weather regardless of server timezone settings
         * */
        $validator = Validation::createValidator();

        $currentDate = (new \DateTime("-1 day"))->format("Y-m-d");

        //Constraints classes for validation

        $dateConstraint = new Assert\Date();
        $greaterOrEqualConstraint = new Assert\GreaterThanOrEqual($currentDate);

        // Customizing error messages
        $dateConstraint->message = $this->violationMessages['date'];
        $greaterOrEqualConstraint->message = $this->violationMessages['date_greater_or_equal'];

        $errors = $validator->validate($date,
            array(
                $dateConstraint,
                $greaterOrEqualConstraint
            )
        );

        return $errors;
    }
}