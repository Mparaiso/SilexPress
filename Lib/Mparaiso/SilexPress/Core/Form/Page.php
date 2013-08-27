<?php

namespace Mparaiso\SilexPress\Core\Form;

use MongoId;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class Page extends Post
{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "page";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add a post_parent field
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $id = null;
            if (isset($data["_id"])) {
                $id = $data["_id"];
            }
            $event->getForm()->add("post_parent", "mongochoice", array("collection" => "posts",
                "key" => "post_title",
                "query" => array("post_type" => "page",
                    "_id" => array('$ne' => new MongoId($id)))));
        });
        parent::buildForm($builder, $options);

    }
}
