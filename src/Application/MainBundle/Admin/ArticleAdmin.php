<?php

namespace Application\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class ArticleAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit'   => array(),
                    'delete' => array(),
                ),
            ));
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->with('article.name')
//            ->add('authors', null, [
//                'label' => 'article.authors',
//            ])
            ->add('title', 'translatable_field', array(
                'field'                => 'title',
                'personal_translation' => 'Application\MainBundle\Entity\ArticleTranslation',
                'property_path'        => 'translations',
            ))
//            ->add('translations', 'a2lix_translations', [
//                'label'  => false,
//                'fields' => [
//                    'title'   => [
//                        'label'      => 'article.title',
//                        'field_type' => 'text',
//                    ],
//                    'content' => [
//                        'label'      => 'article.content',
//                        'field_type' => 'textarea',
//                    ]
//                ]
//            ])
//            ->end()
                ;

    }
}