<?php

namespace App\Repositories;

use App\Core\Traits\GeneratedCodeTrait;
use App\Models\FicheTechnique;
use App\Models\Operation;
use App\Models\StockProduit;
use Carbon\Carbon;
use App\Models\User;
use App\Core\Traits\Ip;
use App\Core\Traits\ImageTrait;
use App\Models\Categorie;
use App\Models\Departement;
use App\Models\Entite;
use App\Models\Famille;
use App\Models\Fournisseur;
use App\Models\ProductUnit;
use App\Models\Produit;
use App\Models\Sous_famille;
use App\Models\Unite;
use App\Models\UnitGroup;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Repository implements RepositoryInterface
{
    use Ip, ImageTrait, GeneratedCodeTrait;
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {

        $param = $data;
        $param["added_by"] = Auth::user()->id;
        $param["add_ip"] = $this->getIp();
        return $this->model->create($param);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $param = $data;
        $record = $this->model->find($id);
        $param["edited_by"] = Auth::user()->id;
        $param["edit_ip"] = $this->getIp();
        $param["edit_date"] = Carbon::now();
        return $record->update($param);
    }

    // remove record from the database
    public function delete($id)
    {
        $_data = $this->model->find($id);

        $_data->is_deleted = 1;
        $_data->deleted_by = Auth::user()->id;
        $_data->delete_ip = $this->getIp();
        $_data->delete_date = Carbon::now();
        $_data->save();

        return $_data;
    }

    // show the record with the given id
    public function edit($id)
    {
        return $this->model->findOrFail($id);
    }

        // show the record with the given id  display view
        public function view($id)
        {
            return $this->model->findOrFail($id);
        }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    //get record not delete
    public function getModelNotDelete()
    {
        return $this->model->where('is_deleted',0)->orderBy('id', 'ASC')->get();
    }


    public function listRoles()
    {
        // return Role::whereNotIn('name', ['super-admin'])->get();

        return Role::all();
    }


    public function listUsers()
    {
       return User::whereHas('roles', function($q)
            {
                $q->where([
                    ['name','<>','super-admin']
                ]);
            })
            ->get();
    }


    public function selectFamille()
    {
        return Famille::where('is_deleted',0)->select('name','id')->get();
    }


    public function selectSousFamille()
    {
        return Sous_famille::where('is_deleted',0)->select('name','id')->get();
    }


    public function selectUnit()
    {
        return Unite::where('is_deleted',0)->select('name','id')->get();
    }

    public function selectUnitGroup()
    {
        return UnitGroup::where('is_deleted',0)->select('name','id')->get();
    }

    public function selectCategorie()
    {
        return Categorie::where('is_deleted',0)->select('nom_categorie','id')->get();
    }

    public function selectFournisseur()
    {
        return Fournisseur::where('is_deleted',0)->selectRaw('CONCAT(fournisseurs.nom," ",fournisseurs.prenom) AS nom_complet, id')->get();
    }

    public function selectProduct()
    {
        return Produit::where('produits.is_deleted',0)
            ->leftJoin('unites','unites.id','=','produits.unites_id')
            ->selectRaw('produits.nom_produit, produits.id, unites.name')->get();
    }

    public function selectDepartement()
    {
        return Departement::where('is_deleted',0)->select('nom_departement','id')->get();
    }

    public function get_single_product($id)
    {
        return Produit::where('produits.id', $id)
                ->leftJoin('unites','unites.id','=','produits.unites_id')
                ->selectRaw('produits.nom_produit, produits.prix_achat, produits.id, unites.name')
                ->first();
    }

    public function liste_permission()
    {
        return Permission::all();
    }


    public function getUser($id)
    {
        return User::find($id);
    }


    public function listeRoles()
    {
        // return Role::whereNotIn('name', ['super-admin'])->get();

        return Role::all();
    }


    public function listeUsers()
    {
       return User::whereHas('roles', function($q)
            {
                $q->where([
                    // ['name','<>','admin'],
                    ['name','<>','super-admin']
                ]);
            })
            ->with('roles')
            ->select('id','first_name','last_name','active','created_at')->get();
    }


    public function selectDepots()
    {
        return Entite::where('entites.is_deleted',0)
                ->leftJoin('departements','departements.id','=','entites.departement_id')->selectRaw('entites.id, entites.name, departements.code_depart')->get();
    }


    public function selectDepotPrincipal()
    {

        return Entite::where([
            ['entites.is_deleted','=',0],
            ['entites.use_depot_principal','=',1],
        ])
        ->leftJoin('departements','departements.id','=','entites.departement_id')
        ->selectRaw('entites.id, entites.name, departements.code_depart')->get();


    }


    public function selectDepartementProductionentral()
    {
        return Entite::leftJoin('departements','departements.id','=','entites.departement_id')
                        ->where([
                            ['entites.is_deleted', '=' ,0],
                            ['departements.code_depart', '=' ,'DP-002'],
                        ])
                        ->selectRaw('entites.id, entites.name')->get();
    }

    public function selectDepartementCentralAchat() {

        return Entite::leftJoin('departements','departements.id','=','entites.departement_id')
            ->where([
                ['entites.is_deleted','=',0],
                ['departements.code_depart','=','DP-001']
            ])->selectRaw('entites.name, entites.id')
            ->get();
    }


    public function modelByReference($reference) {

        return $this->model->where('reference',$reference)->firstOrFail();
    }


    public  function selectMatierePremiere()
    {
        return Produit::selectRaw('produits.id, produits.nom_produit')
                        ->leftJoin('categories','categories.id','=','produits.categories_id')
                        ->where([
                            ['categories.code_categorie','=','001'],
                            ['produits.is_deleted','=', 0]
                        ])->get();
    }


    public  function selectProduitFini()
    {
        return Produit::selectRaw('produits.id, produits.nom_produit')
            ->leftJoin('categories','categories.id','=','produits.categories_id')
            ->where([
                ['categories.code_categorie','=','003'],
                ['produits.is_deleted','=', 0]
            ])->get();
    }

    public  function selectProduitSemiFini()
    {
        return Produit::selectRaw('produits.id, produits.nom_produit')
            ->leftJoin('categories','categories.id','=','produits.categories_id')
            ->where([
                ['categories.code_categorie','=','002'],
                ['produits.is_deleted','=', 0]
            ])->get();
    }

    public function getStockDepotStockage($entite_id)
    {
        $data = StockProduit::selectRaw('produits.id AS product_id, produits.nom_produit, stock_products.id AS stock_product_id')
                            ->leftJoin('produits','produits.id','=','stock_products.produit_id')
                            ->leftJoin('entites','entites.id','=','stock_products.entite_id')
                            ->where('stock_products.entite_id', $entite_id);

        return $data;
    }

    public function getProductUnit($product_id)
    {
        return ProductUnit::where('produits_unites.produit_id', $product_id)
                            ->where('produits_unites.is_deleted', 0)
                            ->leftJoin('unites','unites.id','=','produits_unites.unite_id')
                            ->selectRaw('produits_unites.id, unites.name, produits_unites.pcb, produits_unites.price')
                            ->get();
    }

    public function singleProductDepot($produit_id)
    {
        $depot_id = Auth::user()->entite_id;

        return StockProduit::selectRaw('produits.id, produits.nom_produit, unites.name as unite_gestion, stock_products.quantite, stock_products.id AS stock_id')
            ->leftJoin('produits','produits.id','=','stock_products.produit_id')
            ->leftJoin('unites','unites.id','=','produits.unites_id')
            ->where([
                ['stock_products.produit_id', '=', $produit_id],
                ['stock_products.entite_id', '=',  $depot_id],
            ])->first();
    }

    public function selectionnerMotifGaspillage()
    {
        return DB::table('gaspillages_motifs')
            ->where('gaspillages_motifs.is_deleted','=', 0)
            ->selectRaw('gaspillages_motifs.id, gaspillages_motifs.libelle')
            ->get();
    }

    public function ficheItemDelete($id)
    {
        return FicheTechnique::find($id)->delete();
    }







}
