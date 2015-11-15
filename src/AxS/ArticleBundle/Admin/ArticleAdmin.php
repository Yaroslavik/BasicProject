<?php
/**
 * Created by PhpStorm.
 * User: alexsholk
 * Date: 15.11.15
 * Time: 18:15
 */

namespace AxS\ArticleBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'createdAt',
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Основное')
                ->with('Основное')
                    ->add('category')
                    ->add('title')
                    ->add('slug', null, ['required' => false])
                    ->add('description', null, ['attr' => ['class' => 'wysiwyg']])
                    ->add('content', null, ['attr' => ['class' => 'wysiwyg']])
                    ->add('visible', null, ['required' => false])
                    ->add('createdAt', null, [
                        'required' => false,
                        'widget' => 'single_text',
                        'attr' => ['readonly' => true]])
                    ->add('updatedAt', null, [
                        'required' => false,
                        'widget' => 'single_text',
                        'attr' => ['readonly' => true]])
                ->end()
            ->end()
            ->tab('SEO')
                ->with('SEO')
                    ->add('metaTitle')
                    ->add('metaDescription')
                    ->add('metaKeywords')
                ->end()
            ->end();

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('category')
            ->add('title')
            ->add('visible');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('createdAt')
            ->addIdentifier('title')
            ->add('visible')
            ->add('category')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }
}