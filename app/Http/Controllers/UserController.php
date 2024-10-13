<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserDepotRequest;
use App\Http\Requests\StoreUserEmailChangeRequest;
use App\Http\Requests\StoreUserPasswordChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreUserRoleChangeRequest;
use App\Http\Requests\StoreUserUsernameChangeRequest;

class UserController extends Controller
{


    private $userRepository;
    public function __construct(UserRepository $userRepository )
    {
        $this->userRepository = $userRepository;


        $this->middleware('permission:liste_utilisateur', ['only' => ['users_index']]);
        $this->middleware('permission:ajouter_utilisateur', ['only' => ['users_create','users_store']]);
        // $this->middleware('permission:modifier_utilisateur', ['only' => ['users_edit']]);
        $this->middleware('permission:supprimer_utilisateur', ['only' => ['destroy']]);
        $this->middleware('permission:afficher_utilisateur', ['only' => ['users_edit']]);

        // $this->middleware('permission:liste_utilisateur|creer_utilisateur|modifier_utilisateur', ['only' => ['users_index','users_create','users_edit']]);

    }


    public function users_index(Request $request)
    {
        $users = $this->userRepository->listeUsers();



        if ($request->ajax()) {
            return datatables()->of($users)
            ->addColumn('action', 'pages.utilisateurs._action-menu')
            ->addColumn('role', function (User $user) {
                return $user->getRoleNames()[0]  ?? '' ;
            })
            ->rawColumns(['action','users'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/utilisateurs/table.js');

        return view('pages.utilisateurs.index');
    }



    public function users_store(StoreUserRequest $request)
    {

        $user = $this->userRepository->storeUser($request);

        return response()->json($user);

    }



    public function users_edit_password(StoreUserPasswordChangeRequest $request, $id)
    {
        $user = $this->userRepository->updatePassword($request, $id);

        return response()->json($user);
    }


    public function users_edit_email(StoreUserEmailChangeRequest $request, $id)
    {
        $user = $this->userRepository->updateEmail($request, $id);

        return response()->json($user);
    }


    public function users_edit_role(StoreUserRoleChangeRequest $request, $id)
    {
        $user = $this->userRepository->updateRole($request, $id);

        return response()->json($user);
    }


    public function users_edit_username(StoreUserUsernameChangeRequest $request,$id)
    {
        $user = $this->userRepository->updateUsername($request, $id);

        return response()->json($user);
    }




    public function users_edit($id)
    {


        $data = $this->userRepository->user_edit($id);

        $user = $data['user'];

        $userRoles = $data['userRole'];

        if (!empty($user->entite)) {
            $user_entrepot = $user->entite->name;
        } else {
            $user_entrepot = '';
        }

        if (!empty($userRoles)) {
            $userRole = $userRoles[0];
        }
        else
        {
            $userRole = '';
        }

        $roles = $data['roles'];

        $depots = $this->userRepository->selectDepots();


        // addJavascriptFile('shop/utilisateurs/upadte-username.js');
        addJavascriptFile('shop/utilisateurs/update-entite.js');
        addJavascriptFile('shop/utilisateurs/update-email.js');
        addJavascriptFile('shop/utilisateurs/update-password.js');
        addJavascriptFile('shop/utilisateurs/update-role.js');
        addJavascriptFile('shop/utilisateurs/update-status-compte.js');

        return view('pages.utilisateurs.edit', compact('user', 'userRole', 'roles', 'depots', 'user_entrepot'));
    }



    public function disabled_account(Request $request)
    {
        $user_id = $request->user_id;
        $user = $this->userRepository->disabledAccount($user_id);

        return response()->json($user);
    }


    public function activate_account(Request $request)
    {
        $user_id = $request->user_id;
        $user = $this->userRepository->activateAccount($user_id);

        return response()->json($user);
    }


    public function destroy_user(Request $request)
    {
        $user = User::find($request->id);

        $user->delete();


        return response()->json($user);

    }


    public function check_email_exist(Request $request)
    {
        $isAvailable = true;

        $reponse = User::where('email',$request->email)->first();

        if($reponse){
            $isAvailable = false;
          }else{
            $isAvailable = true;
          }

        return Response()->json(['valid' => $isAvailable]);
    }

    public function check_username_exist(Request $request)
    {
        $isAvailable = true;

        $reponse = User::where('user_name',$request->user_name)->first();

        if($reponse){
            $isAvailable = false;
          }else{
            $isAvailable = true;
          }

        return Response()->json(['valid' => $isAvailable]);
    }


    public function users_create(Request $request)
    {

        $roles = $this->userRepository->selectRole();

        $depots = $this->userRepository->selectDepots();

        addJavascriptFile('shop/utilisateurs/add.js');

        return view('pages.utilisateurs.create', compact('roles', 'depots'));
    }

    public function users_edit_entrepot(Request $request,$id)
    {
        $depot = $this->userRepository->updateUserEntrepot($request, $id);

        return response()->json($depot);
    }
}
