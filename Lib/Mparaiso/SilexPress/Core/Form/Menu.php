<?php

namespace Mparaiso\SilexPress\Core\Form;

use Mparaiso\SilexPress\Core\Form\DataTransformer\StringToHashdDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Menu extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "menu";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add("post_meta", "hidden", array("required" => false))
            ->add("post_title", "text", array("label" => "Title"))
            ->add("post_content", "textarea", array("label" => "Description", "required" => false));

        $builder->get("post_meta")->addModelTransformer(new StringToHashdDataTransformer);
    }
}
