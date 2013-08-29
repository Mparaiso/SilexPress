<?php

namespace Mparaiso\SilexPress\Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MediaSettings extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "mediasettings";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array("class" => "inline");
        $builder->add("thumbnail_size", "imagedimension", array("attr" => $attr))
            ->add("medium_size", "imagedimension")
            ->add("large_size", "imagedimension");

    }
}
