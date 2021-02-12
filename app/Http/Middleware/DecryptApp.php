<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

use Symfony\Component\HttpFoundation\ParameterBag;
class DecryptApp
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */

	/**
	 * @var App
	 */
	private $app;
	protected $secret;
	private static $_encrypt = true;
	protected $except = [
		//'/api/file/showFile/*',
		//'/api/file/get-hash-file/*'
		'/api/v1/menu/get-pdf/*',
		//'/api/login',
		//'/api/outh/logout'
	];


	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->secret = 'ef93be283631ae59456994273215fa5b';
		static::$_encrypt = config('config_encrypt.encrypt');
	}

	public static function getLibrary()
	{
		$plugins = array(
			app_path('lib/aes/aes/Legierski/AES/AES.php'),
		);
		foreach ($plugins AS $plugin) {
			if (!is_file($plugin)) {
				die("NO FILE: " . $plugin);
			}
			require_once $plugin;
		}
		return true;
	}


	public function handle($request, Closure $next)
	{

		$newRequest = $request;

        //dd($newRequest);

		if($request->ajax() &&
			self::$_encrypt === true &&
			 !$this->inExceptArray($request)) {

			if(!isset(getallheaders()['Accept-C']) ||
				(isset(getallheaders()['Accept-C']) && getallheaders()['Accept-C'] !="true" )){
				return new JsonResponse(['error' => 'Invalid data encoding payload.'], 500);
			}

			if ($request->has('encrypt') || $request->has('encryptParams')) {
				$params = $request->query->all();
				$content = $request->getContent();

				if($request->has('encrypt')){
					$content =  json_decode($request->getContent(), true);
					$content = self::myDecrypt($content['encrypt']);
				}

				if($request->has('encryptParams')){
					$params = json_decode(self::myDecrypt($params['encryptParams']), true);
				}


				$baseRequest = new SymfonyRequest();
				$baseRequest->initialize(
					$params,
					$request->request->all(),
					$request->attributes->all(),
					$request->cookies->all(),
					$request->files->all(),
					$request->server->all(),
					$content
				);
				$newRequest = Request::createFromBase($baseRequest);
				$this->app->instance(Request::class, $newRequest);
			}

			$response = $next($newRequest);


			return self::myEncrypted($response);

		}else{
			$response = $next($newRequest);
		}
		return $response;
	}


	public  function myDecrypt($value)
	{
		self::getLibrary();
		$aes = new \Legierski\AES\AES();
		$hash = $this->secret;

		$decode = $aes->decrypt($value, $hash);
		if ($decode === false) {
			return new JsonResponse(['error' => 'Invalid data encoding.'], 415);
		}
		return $decode;
	}


	public function myEncrypted($response)
	{

		if($response->getContent()){
			$content = $response->content();
			$response->headers->set('Content-Length', strlen($content));

			self::getLibrary();
			$aes = new \Legierski\AES\AES();
			$hash = $this->secret;

			$encryptor = $aes->encrypt($content, $hash);
			if ($encryptor === false) {
				return new JsonResponse(['error' => 'Invalid data encoding.'], 415);
			}
			$response->setContent($encryptor);
			$response->headers->set('Content-Type', 'application/json');
			$response->headers->set('Content-Length', strlen($encryptor));
		}

		return $response;
	}

	protected function inExceptArray(Request $request)
	{
		foreach ($this->except as $except) {
			if ($except !== '/') {
				$except = trim($except, '/');
			}
			if ($request->fullUrlIs($except) || $request->is($except)) {
				return true;
			}
		}
		return false;
	}

}
