<?php


namespace App\Admin;


use App\Entity\Article;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

class ArticleAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        /** @var Article $object */
        return $object->getTitle();
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->tab('Tab 1')
//                ->with('Content', ['class' => 'col-md-8'])
                    ->add('title', TextType::class)
//                ->end()
//            ->end()
//            ->tab('Tab 2')
//                ->with('Content 2', ['class' => 'col-md-4'])
                    ->add('content')
                    ->add('description')
                    ->add('image')
                    ->add('categories', ModelAutocompleteType::class, [
                        'property' => 'title'
                    ])
                    ->add('createdAt', null, [
//                        'disabled' => true,
                    ])
//                ->end()
//            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('categories')
            ->add('createdAt')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title', null, [
                'editable' => true,
            ])
            ->add('categories', null, [
                'editable' => true,
            ])
            ->add('createdAt')
            ->add('_action', null, [
                'actions' => [
                    'delete' => [],
                    'edit' => [],
                ]
            ])
        ;
    }
}