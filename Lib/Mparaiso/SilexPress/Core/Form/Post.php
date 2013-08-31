<?php

namespace Mparaiso\SilexPress\Core\Form;

use Mparaiso\SilexPress\Core\Constant\PostFormat;
use Mparaiso\SilexPress\Core\Form\Extension\MetaToObjectDataTransformer;
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
            ->add("post_excerpt", "textarea", array("required" => false))
            ->add("post_content", "textarea", array("attr" => array('rows' => 5)))
            ->add("post_name")
            ->add("post_author", null, array("required" => false))
            ->add("categories", "mongochoice", array(
                "key" => "name", "collection" => "terms", "query" => array("taxonomy" => "category"),
                "multiple" => true, "expanded" => true, "attr" => array("class" => "checkbox")
            ))
            ->add("tags", "array", array("required" => false))
            ->add("post_format", "choice", array("choices" => PostFormat::get()))
            ->add("post_meta", "collection", array('type' => 'meta',
                "allow_add" => true, "allow_delete" => true,
                "options" => array(
                    "label" => " ",
                ), "attr" => array("class" => "symfony-collection")
            ))->get("post_meta")->addModelTransformer(new MetaToObjectDataTransformer);
    }
}
