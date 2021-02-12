<?php namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Legierski\AES\AES;
//Legierski\AES

class LoginController extends Controller
{
    public function callAPI($method, $url, $data, $headers = false)
    {

        $curl = curl_init();

        switch ( $method ) {
            case 'POST':
                curl_setopt( $curl, CURLOPT_POST, 1 );
                if ( $data )
                    curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
                break;
            case 'PUT':
                curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PUT" );
                if ( $data )
                    curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
                break;
            default:
                if ( $data )
                    $url = sprintf( "%s?%s", $url, http_build_query( $data ) );
        }

        // OPTIONS:
        curl_setopt( $curl, CURLOPT_URL, $url );
        if ( !$headers ) {
            curl_setopt( $curl, CURLOPT_HTTPHEADER, [
                'APIKEY: 111111111111111111111',
                'Content-Type: application/json',
            ] );
        }
        else {
            curl_setopt( $curl, CURLOPT_HTTPHEADER, [
                'APIKEY: 111111111111111111111',
                'Content-Type: application/json',
                $headers
            ] );
        }

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

        // EXECUTE:
        $result = curl_exec( $curl );
        if ( !$result ) {
            die('Connection Failure');
        }
        curl_close( $curl );
        return $result;

    }

    public function decrypt($data, $password)
    {
        $data = base64_decode($data);
        $salt = substr($data, 8, 8);
        $ciphertext = substr($data, 16);

        $rounds = 3;
        $data00 = $password.$salt;
        $md5Hash = array();
        $md5Hash[0] = md5($data00, true);
        $result = $md5Hash[0];

        for ($i = 1; $i < $rounds; $i++) {

            $md5Hash[$i] = md5($md5Hash[$i - 1].$data00, true);
            $result .= $md5Hash[$i];
        }

        $key = substr($result, 0, 32);
        $iv  = substr($result, 32, 16);

        return openssl_decrypt($ciphertext, 'aes-256-cbc', $key, true, $iv);
    }

    public function login(Request $request)
    {
        try {

            //dd($request);
            // $data = $request->all();
            // dd($data);
            //$data = json_encode($data);
            // $var = app_path('lib\aes\aes\Legierski\AES\AES.php');
            // dd($var);
            // $decrypted = $this->decrypt($data['encrypt'], 'encrypt');
            // dd($decrypted);

//            if (trim($request->key) != '' && trim($request->token) != '') {
            if ( true ) {

//                $data      = ["key" => $request->key, "token" => $request->token];
//                $make_call = $this->callAPI('POST', 'https://intgraqa.sre.gob.mx/api/checkKey', json_encode($data));
//                $response  = json_decode($make_call, true);

//                if (isset($response) && isset($response['authenticated']) && $response['authenticated'] === true) {
                if ( true ) {

                    $data = $request->all();
                    $userName = $data['data']['user'];
                    //dd($data);
                    auth()->loginUsingId( User::where( 'username', $userName )->first()->id );

                    $user = auth()->user();
                    \DB::table('oauth_access_tokens')->where('user_id', $user->id)
                        ->update(['revoked' => true]);
                    $token = $user->createToken( 'SICAR_session' )->accessToken;

                    if ( $token ) {
                        //GeneralController::saveTransactionLog(1,
                          //  'El usuario ' . $user->username . ' ingreso al sistema');

                        return response()->json( [
                            'authenticated'             => true,
                            'SICAR_session'            => $token,
                            'SICAR_hash'               => $user->hash,
                            'user'                      => static::getSessionInfo( $user->id ),
                            'SICAR_session_expiration' => date( 'D M d Y H:i:s', strtotime( "+8 hours" ) ),
                        ], 200 );
                    }
                    else {
                        return response()->json( [
                            'authenticated' => false,
                        ], 200 );
                    }
                }
                else {
                    return response()->json( [
                        'authenticated' => false,
                    ], 200 );
                }
            }
            else {
                return response()->json( [
                    'authenticated' => false,
                ], 200 );
            }
        }
        catch ( \Exception $e ) {
            return response()->json( [
                'success' => false,
                'message' => $e->getMessage()
            ] );
        }
    }

    public function user($id)
    {
        try {
            return response()->json( [
                'user' => static::getSessionInfo( decrypt( $id ) )
            ], 200 );

        }
        catch ( \Exception $e ) {
            return response()->json( [
                'success' => false,
                'message' => $e->getMessage()
            ] );
        }
    }

    public function logout()
    {

        $authenticated = true;
        auth()->logout();

        if ( !auth()->check() ) {
            $authenticated = false;
        }

        return response()->json( [
            'authenticated' => $authenticated
        ], 200 );
    }

    public static function getSessionInfo($id)
    {
        $user = User::find( $id );
        $nameUnit = null;
        if (!is_null($user->admin)) {
            $nameUnit = $user->admin->name;
        }
        return (object)[
            'hash_id'    => $user->hash,
            'fullname'   => $user->full_name,
            'name'       => $user->name,
            'firstName'  => $user->firstName,
            'secondName' => $user->secondName,
            'profile'    => $user->cat_profile_id,
            'cat_unit_id' => $user->cat_unit_id,
            'name_unit' => $nameUnit
        ];
    }
}
