<?php

namespace Mparaiso\SilexPress\Admin\Media\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Attachment extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add("post_title");
        $builder->add("post_excerpt");
        $builder->add("post_content", "textarea");
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "attachment";
    }
}
