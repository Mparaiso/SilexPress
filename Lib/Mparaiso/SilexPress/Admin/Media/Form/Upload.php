<?php

namespace Mparaiso\SilexPress\Admin\Media\Form;

use Symfony\Component\Form\FormBuilderInterface;

class Upload extends \Symfony\Component\Form\AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add("file", "file", array("required" => true));
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "upload";
    }
}
