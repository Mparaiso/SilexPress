<?php
namespace Mparaiso\SilexPress\Core\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class MongoChoiceType
 * @package Mparaiso\SilexPress\Core\Form\Type
 * A list of documents from the database
 * the value is an ObjectId
 */
class ImageDimensionType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array("class" => "input-small");
        parent::buildForm($builder, $options);
        $builder->add("width", "integer", array("attr" => $attr))
            ->add("height", "integer", array("attr" => $attr));
    }


    public function getName()
    {
        return "imagedimension";
    }

}
