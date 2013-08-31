<?php

namespace Mparaiso\SilexPress\Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QuickPost extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "quick";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add("post_title")
            ->add("post_content", "textarea", array("attr" => array("rows" => 5)));
    }
}
