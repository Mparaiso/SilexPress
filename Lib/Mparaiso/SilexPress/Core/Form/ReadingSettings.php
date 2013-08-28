<?php

namespace Mparaiso\SilexPress\Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ReadingSettings extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "readingsettings";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add("front_page_display", "choice", array(
            "choices" => array(
                "latest_posts" => "Your latest posts",
                "static_page" => "A static page"
            )
        ))
            ->add("posts_per_page", "number")
            ->add("posts_per_feed", "number")
            ->add("post_summary", "choice", array(
                "choices" => array(
                    "full_text" => "Full text",
                    "summary" => "Summary",
                )
            ));
    }
}
