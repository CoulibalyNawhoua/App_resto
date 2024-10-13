<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Http\Requests\StoreRoleRequest;

class RoleController extends Controller
{

    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository=$roleRepository;


        $this->middleware('permission:liste_role', ['only' => ['index']]);
        $this->middleware('permission:ajouter_role', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_role', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_role', ['only' => ['delete_role']]);

    }

    public function index(Request $request)
    {

        $roles  = $this->roleRepository->listeRoles();

        if ($request->ajax()) {
            return datatables()->of($roles)
            ->addColumn('action', 'pages.roles._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/roles/table.js');
        return view('pages.roles.index');
    }


    public function create()
    {

        $permissions = $this->roleRepository->liste_permission();

        addJavascriptFile('shop/roles/add.js');

        return view('pages.roles._create', compact('permissions'));
    }


    public function store(StoreRoleRequest $request)
    {

        $role = $this->roleRepository->role_store($request);

        return response()->json($role, 200);
    }


    public function edit($id)
    {
        $permissions = $this->roleRepository->liste_permission();

        $role = $this->roleRepository->edit($id);

        addJavascriptFile('shop/roles/update.js');

        return view('pages.roles._edit', compact('permissions', 'role'));
    }


    public function update(StoreRoleRequest $request, $id)
    {
        $role = $this->roleRepository->role_update($request, $id);
        return response()->json($role, 200);
    }


    public function delete_role(Request $request)
    {
        $role = $this->roleRepository->destroy($request->id);

        return response()->json($role, 200);
    }
}
