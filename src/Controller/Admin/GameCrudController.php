<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('image'),
            IntegerField::new('playerMin'),
            IntegerField::new('playerMax'),
            IntegerField::new('ageMin'),
            IntegerField::new('duration'),
            IntegerField::new('yearOut'),
            AssociationField::new('author'),
            AssociationField::new('categories'),
            TextEditorField::new('description')->hideOnIndex(),
            TextField::new('illustrator')->hideOnIndex(),
            TextField::new('editor')->hideOnIndex(),
            TextField::new('distributor')->hideOnIndex(),
        ];
    }
}
