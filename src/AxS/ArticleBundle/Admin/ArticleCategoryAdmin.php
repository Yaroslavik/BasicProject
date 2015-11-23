<?php
/**
 * Created by PhpStorm.
 * User: alexsholk
 * Date: 15.11.15
 * Time: 18:20
 */

namespace AxS\ArticleBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Pix\SortableBehaviorBundle\Services\PositionHandler;
use Sonata\AdminBundle\Route\RouteCollection;

class ArticleCategoryAdmin extends Admin
{
    public $last_position = 0;

    private $positionService;

    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'order',
    );

    public function setPositionService(PositionHandler $positionHandler)
    {
        $this->positionService = $positionHandler;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $dateFormat = $this->getConfigurationPool()->getContainer()->getParameter('axs_article.date_format');

        $formMapper
            ->tab('Основное')
                ->with('Основное')
                    ->add('title')
                    ->add('slug', null, ['required' => false])
                    ->add('description', null, ['attr' => ['class' => 'wysiwyg']])
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
        $datagridMapper
            ->add('title')
            ->add('visible');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('visible', null, ['editable' => true])
            ->add('order')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                    'move' => [
                        'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig'
                    ],
                ]
            ]);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('move', $this->getRouterIdParameter() . '/move/{position}');
    }
}