<?php namespace App\Http\Controllers\Administrador;


use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Models\Cats\CatConsulate;
use App\Http\Models\Cats\CatProfile;
use App\Http\Models\Transaction;
use App\User;
use DB;

use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->wantsJson()) {
                $data = $request->all();

                $users = User::with('profile', 'consulate')
                    ->search($data['search'])
                    ->where('isActive', true)
                    ->where('id', '!=', 1)
                    ->where('id', '!=', 2)
                    ->orderBy('cat_profile_id', 'DESC')
                    ->paginate($data['perPage']);

                return response()->json([
                    'users' => $users,
                    'success' => true
                ]);
            } else {
                return response()->view('errors.404', [], 404);
            }

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            if ($request->wantsJson()) {

                $user = User::find(decrypt($id));
                $profiles = CatProfile::where('isActive', 1)->get(['id', 'name']);
                $consulates = CatConsulate::where('isActive', 1)->get(['id', 'name']);
                $userConsulates = DB::table('user_consulates')
                    ->where('user_id', $user->id)
                    ->pluck('cat_consulates_id');

                $userform = [
                    'cat_profile_id' => $user->cat_profile_id,
                    'cat_consulate_id' => $userConsulates,
                    'name' => $user->name,
                    'firstName' => $user->firstName,
                    'secondName' => $user->secondName
                ];

                return response()->json([
                    'profiles' => $profiles,
                    'consulates' => $consulates,
                    'userForm' => $userform,
                    'success' => true
                ]);

            } else {
                return response()->view('errors.404', [], 404);
            }

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            if ($request->wantsJson()) {

                $user = User::find(decrypt($id));
                $data = $request->all();
                $user->fill($data);
                $user->save();
                $consulates =  $data['cat_consulate_id'];
                if(count($consulates) > 0){
                    DB::table('user_consulates')->where('user_id',$user->id)->delete();
                    foreach ($consulates as $consulate){
                        DB::table('user_consulates')->insert([
                           'user_id' => $user->id,
                           'cat_consulates_id'  => $consulate
                        ]);
                    }
                }

                GeneralController::saveTransactionLog(3, 'Edita al usuario: ' . $user->username);
                DB::commit();
                return response()->json([
                    'success' => true
                ], 200);

            } else {
                return response()->view('errors.404', [], 404);
            }

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
