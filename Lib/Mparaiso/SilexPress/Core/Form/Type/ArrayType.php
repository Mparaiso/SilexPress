<?php
namespace Mparaiso\SilexPress\Core\Form\Type;
use Mparaiso\SilexPress\Core\Form\Extension\MongoObjectIdDataTransformer;
use Mparaiso\SilexPress\Core\Form\Extension\StringToArraydDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class MongoChoiceType
 * @package Mparaiso\SilexPress\Core\Form\Type
 * A list of documents from the database
 * the value is an ObjectId
 */
class ArrayType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder->addModelTransformer(new StringToArraydDataTransformer());
    }

    function getParent()
    {
        return "text";
    }

    public function getName()
    {
        return "array";
    }

}