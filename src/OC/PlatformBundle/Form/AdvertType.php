<?php

namespace OC\PlatformBundle\Form;

use OC\PlatformBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $pattern = "%";

        $builder
                ->add('date', DateTimeType::class)
                ->add('title', TextType::class)
                ->add('author', TextType::class)
                ->add('email', TextType::class)
                ->add('content', TextareaType::class)
                ->add('published', CheckboxType::class, array('required' => false))
                ->add("image", ImageType::class, array('required' => false))
                ->add("categories", EntityType::class, array(
                    "class" => "OCPlatformBundle:Category",
                    "choice_label" => "name",
                    "multiple" => true,
                    "query_builder" => function(CategoryRepository $repository) use($pattern) {
                        return $repository->getLikeQueryBuilder($pattern);
                    }
                ))
                ->add('save', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Advert'
        ));
    }

}
