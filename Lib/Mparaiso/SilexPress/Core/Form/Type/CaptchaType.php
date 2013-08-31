<?php
namespace Mparaiso\SilexPress\Core\Form\Type {

    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Form\AbstractType;

    class CaptchaType extends AbstractType
    {
        //@TODO à completer
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            /**
             * EN : @note @silex use a custom field type
             * FR : @note @silex utiliser un champ personalisé
             */
            $builder->add("image", new ImageType(), array("attr" => array("src" => "/img/image.png")));
            $builder->add("code", "text", array("label" => " "));
        }

        function getDefaultOptions(array $options)
        {
            return array();
        }

        function getName()
        {
            return "captcha";
        }

        function getParent()
        {
            return "form";
        }
    }
}