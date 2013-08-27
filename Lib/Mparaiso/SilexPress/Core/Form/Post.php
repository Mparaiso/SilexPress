<?php

namespace Mparaiso\SilexPress\Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Post extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "post";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add("post_title")
            ->add("post_excerpt", "textarea")
            ->add("post_content", "textarea")
            ->add("post_name")
            ->add("post_author")
            ->add("categories", "mongochoice", array(
                "key" => "name", "collection" => "terms", "query" => array("taxonomy" => "category"),
                "multiple" => true, "expanded" => true, "attr" => array("class" => "checkbox")
            ));
        /*->add("post_meta", "collection", array('type' => 'text',
            "allow_add" => true, "allow_delete" => true
        ));*/
    }
}
