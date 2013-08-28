<?php

namespace Mparaiso\SilexPress\Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PermalinkSettings extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "permalinksettings";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


    }
}
