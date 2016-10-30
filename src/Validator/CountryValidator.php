<?php

namespace Polifonic\Addressable\Validator;

use Polifonic\Addressable\Model\AddressableInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints\Country as BaseCountry;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CountryValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($addressable, Constraint $constraint)
    {
    	if (!$addressable instanceof AddressableInterface) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Country');
    	}

        if (!$constraint instanceof Country) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Country');
        }

        $context = $this->context;

		$validator = $context->getValidator()->inContext($context);

		$validator
			->atPath('addressable.country_id')
			->validate(
				$addressable->getCountryId(),
				$this->getContraints()
			);
    }

    protected function getValidator()
    {
    	return $this->validator;
    }

    protected function getContraints()
    {
    	return array(
    		new NotBlank(),
    		new BaseCountry(),
		);
    }
}
