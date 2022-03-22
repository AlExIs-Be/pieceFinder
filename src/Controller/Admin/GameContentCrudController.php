<?php

namespace App\Controller\Admin;

use App\Entity\GameContent;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GameContentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GameContent::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new("game"),
            TextField::new("name"),
            AssociationField::new("componentType"),
            AssociationField::new("component"),
            IntegerField::new('quantity'),
            TextField::new("material"),
            TextField::new("color"),
            Textfield::new("picture"),
            
        ];
    }
    
}
