<?php

namespace Mparaiso\SilexPress\Core\Form;

use MongoId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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


    }
}
