<?php

namespace Mparaiso\SilexPress\Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GeneralSettings extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "generalsettings";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("site_title")
            ->add("tagline")
            ->add("wordpress_address")
            ->add("site_adress")
            ->add("email", "email")
            ->add("membership", "choice", array("label" => " ",
                "choices" => array("membership"), "expanded" => true, "multiple" => true,
            ))
            ->add("default_role", "choice", array("choices" => array(
                "ROLE_SUSCRIBER" => "suscriber",
                "ROLE_ADMINISTRATOR" => "administrator",
                "ROLE_EDITOR" => "editor",
                "ROLE_AUTHOR" => "author",
                "ROLE_CONTRIBUTOR" => "contributor"
            )
            ))
            ->add("date_format", "choice", array(
                "choices" => array(
                    "F d,Y" => date("F d,Y"),
                    "Y/m/d" => date("Y/m/d"),
                    "m/d/Y" => date("m/d/Y"),
                    "d/m/Y" => date("d/m/Y")
                ), "expanded" => true, "attr" => array("class" => "horizontal"),
            ))

            ->add("time_format", "choice", array(
                "choices" => array(
                    "h:i a" => date("h:i a"),
                    "h:i A" => date("h:i A"),
                    "H:i" => date("H:i"),
                ), "expanded" => true, "attr" => array("class" => "horizontal")
            ));

    }
}
