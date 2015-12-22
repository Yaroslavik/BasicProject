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
        $object = $this->getSubject();

        $dateFormat = $this->getConfigurationPool()->getContainer()->getParameter('axs_article.date_format');

        $formMapper
            ->tab('Основное')
            ->with('Основное');

        if ($this->getConfigurationPool()->getContainer()->getParameter('axs_article.use_categories')) {
            $formMapper->add('category');
        }

        $formMapper
            ->add('title')
            ->add('slug', null, ['required' => false])
            ->add('file', 'file', [
                'required' => !$object->getWebPath(),
                'help' => $object->getWebPath() ? sprintf('<img src="%s" class="form-preview">', $object->getWebPath()) : '',
            ])
            ->add('description', 'textarea')
            ->add('content', null, ['attr' => ['class' => 'wysiwyg']])
            ->add('visible', null, ['required' => false])
            ->add('createdAt', 'datetime', [
                'required' => false,
                'format' => $dateFormat,
                'widget' => 'single_text',
                'disabled' => true,
                'read_only' => true,
            ])
            ->add('updatedAt', 'datetime', [
                'required' => false,
                'format' => $dateFormat,
                'widget' => 'single_text',
                'disabled' => true,
                'read_only' => true,
            ])
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
        if ($this->getConfigurationPool()->getContainer()->getParameter('axs_article.use_categories')) {
            $datagridMapper->add('category');
        }

        $datagridMapper
            ->add('title')
            ->add('visible');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('file', null, ['template' => 'AxSArticleBundle:Admin:list_field_image.html.twig'])
            ->add('createdAt')
            ->addIdentifier('title')
            ->add('visible', null, ['editable' => true]);

        if ($this->getConfigurationPool()->getContainer()->getParameter('axs_article.use_categories')) {
            $listMapper->add('category');
        }
        
        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }
}