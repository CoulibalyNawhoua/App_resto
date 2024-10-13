<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PermissionRepository;
use App\Http\Requests\StorePermissionRequest;

class PermissionController extends Controller
{

    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository=$permissionRepository;

        // $this->middleware(['role:super-admin']);

        $this->middleware('permission:liste_permission', ['only' => ['index']]);
        $this->middleware('permission:ajouter_permission', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_permission', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_permission', ['only' => ['permission_delete']]);
    }

    public function index(Request $request)
    {

        $permissions = $this->permissionRepository->all();
        if ($request->ajax()) {
            return datatables()->of($permissions)
            ->addColumn('action', 'pages.permissions._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/permissions/table.js');

        return view('pages.permissions.index');
    }


    public function create()
    {

        addJavascriptFile('shop/permissions/add.js');

        return view('pages.permissions._create');
    }


    public function store(StorePermissionRequest $request)
    {

        $permission = $this->permissionRepository->create($request->all());

        return response()->json($permission, 200);
    }


    public function edit($id)
    {

        $permission = $this->permissionRepository->edit($id);

        addJavascriptFile('shop/permissions/update.js');

        return view('pages.permissions._edit', compact('permission'));


    }
    public function update(StorePermissionRequest $request, $id)
    {

        $permission = $this->permissionRepository->update($request->all(),$id);

        return response()->json($permission, 200);
    }


    public function permission_delete(Request $request)
    {
        $permission = $this->permissionRepository->destroy($request->id);

        return response()->json($permission, 200);
    }

    public function permission_user_edit($id)
    {

        $permissions = $this->permissionRepository->liste_permission();

        $user = $this->permissionRepository->getUser($id);

        return view('pages.utilisateurs._create-permission-user', compact('permissions', 'user'));
    }


    public function storeUserPermission(Request $request, $id)
    {
        $response = $this->permissionRepository->storeUserPermission($request, $id);

        return response()->json($response);

    }
}
