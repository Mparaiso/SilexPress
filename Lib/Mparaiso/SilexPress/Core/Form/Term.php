<?php

namespace Mparaiso\SilexPress\Core\Form;

use MongoId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class Term extends AbstractType
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "term";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    { // add a post_parent field
        parent::buildForm($builder, $options);
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $id = null;
            if (isset($data["_id"])) {
                $id = $data["_id"];
            }
            $event->getForm()->add("parent", "mongochoice", array("collection" => "terms",
                "key" => "name",
                "query" => array("taxonomy" => "category",
                    "_id" => array('$ne' => new MongoId($id)))));
        });
        $builder
            ->add("name")
            ->add("description", "textarea", array("required" => false));
    }
}
