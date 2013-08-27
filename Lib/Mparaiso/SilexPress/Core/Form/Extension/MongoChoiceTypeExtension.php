<?php

namespace Mparaiso\SilexPress\Core\Form\Extension;

use MongoDB;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ServiceTypeExtension
 * @package Mparaiso\SilexPress\Core\Form\Extension
 * extend Choice Type , Query Database for a list of choices given a collection , and a query
 */
class MongoChoiceTypeExtension extends AbstractTypeExtension
{
    /**
     * @var MongoDB
     */
    protected $mongoDB;

    function __construct(\MongoDB $mongoDB)
    {
        $this->mongoDB = $mongoDB;
    }

    function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $mongoDB = $this->mongoDB;
        $resolver->setOptional(array("collection", "query", "key"));
        $resolver->setDefaults(array("choice_list" => function (Options $options) use ($mongoDB) {
                if ($options->has("collection") && $options->has("query")) {
                    $collection = $this->mongoDB->selectCollection($options["collection"]);
                    $query_result = $collection->find($options["query"]);
                    $choices = array();
                    $labels = array();
                    foreach ($query_result as $result) {
                        $choices[] = (string)$result["_id"];
                        $labels[] = (string)$result[$options["key"]];
                    }
                    return new ChoiceList($choices, $labels);
                }
            },)
               /* "data_transformer" => new MongoObjectIdDataTransformer())*/
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }


    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return "mongochoice";
    }


}

