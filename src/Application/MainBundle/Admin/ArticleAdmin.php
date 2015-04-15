<?php

namespace Application\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class ArticleAdmin extends Admin {

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('title')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('_action', 'actions', [
                    'actions' => [
                        'edit' => [],
                        'delete' => [],
                    ],
        ]);
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('article.name')
                ->add('authors', null, [
                    'label' => 'article.authors',
                ])
                ->add('translations', 'a2lix_translations', [
                    'label' => false,
                    'fields' => [
                        'title' => [
                            'label' => 'article.title',
                            'field_type' => 'text',
                        ],
                        'content' => [
                            'label' => 'article.content',
                            'attr' => [
                                'rows' => 16,
                            ]
                        ]
                    ]
                ])
                ->end()
        ;
    }

}
