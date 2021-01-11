<?php
use Symfony\Component\Validator\Constraint;


class CodePostalConstraint extends Constraint
{

    private $Message = "Le code postal n'est pas valide.";
    const REGEX = "\d{2}[ ]?\d{3}";

    public function validate($value, Constraint $constraint)
    {
        $uppercase = trim(strtoupper(str_replace(' ', '', $value)));

        if(!preg_match(self::REGEX, $uppercase, $matches))
        {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

    public function validatedBy()
    {
        return static::class.'Validator';
    }

}