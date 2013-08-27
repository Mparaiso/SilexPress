<?php
namespace Mparaiso\SilexPress\Core\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Class MetaType
 * @package Mparaiso\SilexPress\Core\Form\Type
 * A post_meta form
 */
class MetaType extends AbstractType
{
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "meta";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add("name", "text",
                array("label" => " Name : ", "constraints" => array(new Regex('/\S+/'))))
            ->add("value", "text",
                array("label" => " Value :", "constraints" => array(new NotNull())));
    }
}