<?php

namespace App\Controller\Admin;

use App\Entity\ComponentType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ComponentTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ComponentType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('type'),
        ];
    }

}
