<?php namespace App\Http\Controllers\Administrador;


use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Models\Cats\CatAdministrativeUnit;
use App\Http\Models\Cats\CatConsulate;
use App\Http\Models\Cats\CatDeterminant;
use App\Http\Models\Cats\CatProfile;
use App\Http\Models\Transaction;
use App\Http\Requests\UpdateUser;
use App\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->wantsJson()) {
                $data = $request->all();

                $users = User::with('profile', 'unit', 'determinant')
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
                $determinants = CatAdministrativeUnit::where('isActive', 1)->whereDeterminant(false)->get(['id', 'determinant']);
                $units = CatAdministrativeUnit::where('isActive', 1)->get(['id', 'name']);
                $userConsulates = DB::table('user_units')
                    ->where('user_id', $user->id)
                    ->pluck('cat_administrative_unit_id');

                $userform = [
                    'cat_profile_id' => $user->cat_profile_id,
                    'cat_determinant_id' => $user->cat_determinant_id,
                    'cat_unit_id'  => $user->cat_unit_id,
                    'cat_administrative_unit_id' => $userConsulates,
                    'name' => $user->name,
                    'firstName' => $user->firstName,
                    'secondName' => $user->secondName
                ];

                return response()->json([
                    'profiles' => $profiles,
                    'determinants' => $determinants,
                    'units' => $units,
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

    public function update(UpdateUser $request, $id)
    {
        try {
            DB::beginTransaction();
            if ($request->wantsJson()) {

                $user = User::find(decrypt($id));
                $data = $request->all();
                $user->fill($data);
                $user->save();
                $units =  $data['cat_administrative_unit_id'];
                if(count($units) > 0){
                    DB::table('user_units')->where('user_id',$user->id)->delete();
                    foreach ($units as $unit){
                        DB::table('user_units')->insert([
                           'user_id' => $user->id,
                           'cat_administrative_unit_id'  => $unit
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
