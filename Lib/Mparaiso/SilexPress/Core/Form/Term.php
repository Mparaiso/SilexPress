<?php

namespace Mparaiso\SilexPress\Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Term extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "term";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add("name")
            ->add("description", "textarea",array("required"=>false));
    }
}
