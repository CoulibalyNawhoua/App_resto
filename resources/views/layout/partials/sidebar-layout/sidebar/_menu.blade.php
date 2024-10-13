<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<!--begin::Menu-->
		<div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ Request::is( '/' ) ?  'active' : '' }}" href="/">
                    <span class="menu-icon">{!! getIcon('home', 'fs-2') !!}</span>
                    <span class="menu-title">Acceuil</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->

            @can('afficher_tableau_bord')
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Route::currentRouteNamed( 'admin' ) ?  'active' : '' }}" href="{{ route('admin') }}">
                        <span class="menu-icon">{!! getIcon('code', 'fs-2') !!}</span>
                        <span class="menu-title">Tableau de bord </span>
                    </a>
                    <!--end:Menu link-->
                </div>
			    <!--end:Menu item-->
            @endcan

            @can('section_fournisseur')
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Request::is( 'fournisseurs' ) ?  'active' : '' }}" href="{{ route('fournisseurs.index') }}" href="/">
                        <span class="menu-icon">{!! getIcon('people', 'fs-2') !!}</span>
                        <span class="menu-title">Fournisseurs</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
            @endcan

            @can('section_departement')
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Request::is( 'departements' ) ?  'active' : '' }}" href="{{ route('departements.index') }}">
                        <span class="menu-icon">{!! getIcon('abstract-30', 'fs-2') !!}</span>
                        <span class="menu-title">Departements</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
            @endcan

            @can('afficher_depot_stockage')
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Request::is( 'entites' ) ?  'active' : '' }}" href="{{ route('entites.index') }}">
                        <span class="menu-icon">{!! getIcon('row-vertical', 'fs-2') !!}</span>
                        <span class="menu-title">Sites</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
            @endcan

            @can('section_produit')
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('produits') || Request::is( 'familles' ) || Request::is( 'sous-familles' ) || Request::is( 'categories' ) || Request::is( 'unites' ) || Request::is('units-groups') ? 'here show':'' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('abstract-26', 'fs-2') !!}</span>
                        <span class="menu-title">Gestion produits</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        @can('liste_produit')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('produits') ?  'active' : '' }}" href="{{ route('produits.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Liste produits</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        {{--  @can('liste_famille')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('familles') ?  'active' : '' }}" href="{{ route('familles.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Familles</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan  --}}

                        {{--  @can('liste_sous_famille')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('sous-familles') ?  'active' : '' }}" href="{{ route('sous-familles.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Sous familles</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan  --}}

                        @can('liste_categorie_produit')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('categories') ?  'active' : '' }}" href="{{ route('categories.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Catégories</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        @hasanyrole('super-admin')
                            @can('liste_unite')
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ Request::is('unites') ?  'active' : '' }}" href="{{ route('unites.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Unités</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endcan

                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('units-groups') ?  'active' : '' }}" href="{{ route('unit-group-index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Groupe unités</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endhasanyrole
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan



            @can('section_recette')
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Request::is( 'recettes' ) ?  'active' : '' }}" href="{{ route('index-recette') }}">
                        <span class="menu-icon">{!! getIcon('test-tubes', 'fs-2') !!}</span>
                        <span class="menu-title">Recettes</span>
                    </a>
                    <!--end:Menu link-->
                </div>
            @endcan


            @can('section_achat')
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('purchases/providers') || Request::is( 'purchases/providers/create' ) || Request::is( 'purchases/providers/receipt' )   ? 'here show':'' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
                        <span class="menu-title">Achats fournisseurs</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        @can('ajouter_achat')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is( 'purchases/providers/create' ) ?  'active' : '' }}" href="{{ route('procurments.providers.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Nouvelle commande</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        @can('liste_achat')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('purchases/providers') ?  'active' : '' }}" href="{{ route('procurments.providers.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Commandes</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        @can('liste_reception_achat')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('purchases/providers/receipt') ?  'active' : '' }}" href="{{ route('procurments.providers.receipt') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Réceptions</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan

            {{--  consultation des bon de commande central et cuisine   --}}
            @can('section_commande_depot_stockage')
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('orders/deposit') || Request::is('orders/deposit/delivery') ? 'here show':'' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('element-equal', 'fs-2') !!}</span>
                        <span class="menu-title">Commandes des dépôts</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        @can('liste_commande_depot_stockage')
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('orders/deposit') ?  'active' : '' }}" href="{{ route('orders.deposit.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Liste commandes</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan


                        @can('liste_bon_livraison_commande')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is('orders/deposit/delivery') ?  'active' : '' }}" href="{{ route('orders.deposit.delivery') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Livraisons</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan

            {{--  fin  --}}

            @can('section_authentification')
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('permissions') || Request::is( 'permissions/create' ) || Request::is( 'roles' ) || Request::is( 'roles/create' ) || Request::is('users') || Request::is( 'users/create' ) ? 'here show':'' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('user', 'fs-2') !!}</span>
                        <span class="menu-title">Gestion utilisateurs</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        @can('section_utilisateur')
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item  {{ Request::is('users') || Request::is( 'users/create' )  ? 'here show':'' }} menu-accordion mb-1">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Utilisateurs</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">

                                    @can('liste_utilisateur')
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ Request::is('users') ?  'active' : '' }}" href="{{ route('users.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Liste utilisateurs</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endcan

                                    @can('ajouter_utilisateur')
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ Request::is('users/create') ?  'active' : '' }}" href="{{ route('users.create') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Nouveau utilisateur</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endcan

                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endcan

                        @can('section_role')
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('roles') || Request::is( 'roles/create' )  ? 'here show':'' }} menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Roles</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">

                                    @can('liste_role')
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ Request::is('roles') ?  'active' : '' }}" href="{{ route('roles.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Liste rôles</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endcan

                                    @can('ajouter_role')
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ Request::is('roles/create') ?  'active' : '' }}" href="{{ route('roles.create') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Nouveau rôle</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endcan

                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endcan

                        @can('section_permission')
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('permissions') || Request::is( 'permissions/create' )  ? 'here show':'' }} menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Permissions</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">

                                    @can('liste_permission')
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ Request::is('permissions') ?  'active' : '' }}" href="{{ route('permissions.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Liste permissions</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endcan

                                    @can('ajouter_permission')
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ Request::is('permissions/create') ?  'active' : '' }}" href="{{ route('permissions.create') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Nouvelle permission</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endcan

                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endcan
                        {{--  permission menu  --}}


                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan


                <!--begin:Menu item-->
            @can('section_commande')
                <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('orders/production/create') || Request::is( 'orders/central/create' ) ||  Request::is( 'orders' ) || Request::is( 'orders/receipt' ) ? 'here show':'' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
                        <span class="menu-title">Gestion commande</span>
                        <span class="menu-arrow"></span>
                    </span>

                    @can('liste_commande')
                        <div class="menu-sub menu-sub-accordion">

                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is( 'orders' ) ?  'active' : '' }}" href="{{ route('orders.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Liste commandes</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                    @endcan

                    @can('liste_reception_commande')
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is( 'orders/receipt' ) ?  'active' : '' }}" href="{{ route('orders.receipt') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Réception</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                    @endcan


                    @can('ajouter_commande')
                        <div class="menu-sub menu-sub-accordion">
                            <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('orders/production/create') || Request::is( 'orders/central/create' ) ? 'here show':'' }} menu-accordion mb-1">

                            <span class="menu-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Nouvelle commande</span>
                                <span class="menu-arrow"></span>
                            </span>

                                <div class="menu-sub menu-sub-accordion">
                                    @can('commande_departement_production')
                                        <div class="menu-item">
                                            <a class="menu-link  {{ Request::is('orders/production/create') ?  'active' : '' }}" href="{{ route('orders.production.create') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Production</span>
                                            </a>
                                        </div>
                                    @endcan

                                    @can('commande_departement_central')
                                        <div class="menu-item">
                                            <a class="menu-link {{ Request::is('orders/central/create') ?  'active' : '' }}" href="{{ route('orders.central.create') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Central</span>
                                            </a>
                                        </div>
                                    @endcan

                                </div>

                            </div>
                        </div>
                    @endcan

                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
           {{-- @endhasallroles--}}
            @endcan


            @can('section_ajustement')
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('products/stock-adjustment') || Request::is( 'products/stock-adjustment/create' ) || Request::is( 'products/stock-adjustment/stock-initialization' )  || Request::is( 'products/stock-adjustment/output/create' ) ? 'here show':'' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
					<span class="menu-icon">{!! getIcon('arrow-right-left', 'fs-2') !!}</span>
					<span class="menu-title">Ajustement des stocks</span>
					<span class="menu-arrow"></span>
				</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        @can('ajouter_ajustement')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is( 'products/stock-adjustment/create' ) ?  'active' : '' }}" href="{{ route('products.ajustement.create') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                    <span class="menu-title">Nouveau ajustement</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        @can('ajouter_ajustement')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is( 'products/stock-adjustment/stock-initialization' ) ?  'active' : '' }}" href="{{ route('stock-initialization') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                    <span class="menu-title">Initialisation stock</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        @can('liste_ajustement')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is( 'products/stock-adjustment' ) ?  'active' : '' }}" href="{{ route('products.ajustement.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                    <span class="menu-title">Ajustements stock</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan


            @can('section_gaspillage')
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('squandering') || Request::is( 'squandering/create' ) ? 'here show':'' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
					<span class="menu-icon">{!! getIcon('abstract-29', 'fs-2') !!}</span>
					<span class="menu-title">Gaspillages</span>
					<span class="menu-arrow"></span>
				</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->


                        @can('ajouter_gaspillage')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is( 'squandering/create' ) ?  'active' : '' }}" href="{{ route('squandering.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Nouveau</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        @can('liste_gaspillage')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Request::is( 'squandering' ) ?  'active' : '' }}" href="{{ route('squandering.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                    <span class="menu-title">Gaspillages</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan

            @can('section_motif_gaspillage')
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Request::is( 'motifs-gaspillages' ) ?  'active' : '' }}" href="{{ route('motif-gaspillage.index') }}">
                        <span class="menu-icon">{!! getIcon('burger-menu-4', 'fs-2') !!}</span>
                        <span class="menu-title">Motifs gaspillages</span>
                    </a>
                    <!--end:Menu link-->
                </div>
            @endcan

            @can('consultation_stock_depot_stockage')
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Request::is( 'products/stock-status' ) ?  'active' : '' }}" href="{{ route('products-stock-status') }}">
                        <span class="menu-icon">{!! getIcon('burger-menu-4', 'fs-2') !!}</span>
                        <span class="menu-title">Stock produit </span>
                    </a>
                    <!--end:Menu link-->
                </div>
            @endcan

            @can('section_bilan')
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item {{ Request::is('bilan-produit-recette/create') || Request::is('bilan-produit-recette') ? 'here show':'' }} menu-accordion">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('element-equal', 'fs-2') !!}</span>
                    <span class="menu-title">Bilans</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">

                    @can('ajouter_bilan')
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Request::is('bilan-produit-recette/create') ?  'active' : '' }}" href="{{ route('bilan-produit-recette-create') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Nouveau bilan recettes produits</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    @endcan


                    @can('liste_bilan')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Request::is('bilan-produit-recette') ?  'active' : '' }}" href="{{ route('bilan-produit-recette') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Liste bilans recettes produits</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    @endcan
                </div>
                <!--end:Menu sub-->
            </div>
            <!--end:Menu item-->
            @endcan


            @hasanyrole('super-admin')
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Request::is('conversions') ?  'active' : '' }}" href="{{ route('conversion.index') }}">
                        <span class="menu-icon">{!! getIcon('test-tubes', 'fs-2') !!}</span>
                        <span class="menu-title">Conversions</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
            @endhasanyrole


		</div>
		<!--end::Menu-->
	</div>
	<!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
