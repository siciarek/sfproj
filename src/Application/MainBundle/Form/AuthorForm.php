<?php

namespace Application\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuthorForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('firstName')
                ->add('lastName')
                ->add('dateOfBirth', 'date', [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('info', 'ckeditor')
                ->add('captcha', 'captcha', [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'common.captcha',
                    ]
                ])
                ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => md5(1234),
        ]);
    }

    public function getName() {
        return 'applicationmain_author_form';
    }

}
