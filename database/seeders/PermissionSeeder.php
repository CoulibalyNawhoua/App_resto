<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {

        $permissions = [

            'liste_fournisseur',
            'ajouter_fournisseur',
            'modifier_fournisseur',
            'supprimer_fournisseur',

            'liste_permission',
            'ajouter_permission',
            'modifier_permission',
            'supprimer_permission',


            'liste_utilisateur',
            'ajouter_utilisateur',
            'modifier_utilisateur',
            'supprimer_utilisateur',
            'afficher_utilisateur',

            'liste_role',
            'ajouter_role',
            'modifier_role',
            'supprimer_role',

            'liste_famille',
            'ajouter_famille',
            'modifier_famille',
            'supprimer_famille',

            'liste_sous_famille',
            'ajouter_sous_famille',
            'modifier_sous_famille',
            'supprimer_sous_famille',

            'liste_produit',
            'ajouter_produit',
            'modifier_produit',
            'supprimer_produit',
            'afficher_produit',

            'liste_client',
            'ajouter_client',
            'modifier_client',
            'supprimer_client',


            'liste_categorie_produit',
            'ajouter_categorie_produit',
            'modifier_categorie_produit',
            'supprimer_categorie_produit',

            'liste_procurement',
            'ajouter_procurement',
            'modifier_procurement',
            'supprimer_procurement',
            'detail_procurement',

            'liste_vente',
            'ajouter_vente',
            'modifier_vente',
            'supprimer_vente',
            'detail_vente',

            'liste_inventaire',
            'ajouter_inventaire',
            'modifier_inventaire',
            'supprimer_inventaire',
            'detail_inventaire',


            'afficher_tableau_bord',

        ];

        foreach ($permissions as $permission) {

            Permission::create([
                'name' => $permission,
            ]);
        }


    }


}
