<?php

namespace Mparaiso\SilexPress\Core\Form;

use Mparaiso\SilexPress\Core\Constant\PostFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class WritingSettings extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "writingsettings";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("default_post_category", "mongochoice", array(
            "key" => "name", "collection" => "terms", "query" => array("taxonomy" => "category")
        ));

        $builder->add("default_post_format", "choice", array(
            "choices" => PostFormat::get()
        ));

    }
}
