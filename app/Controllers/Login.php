<?php 
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Login_model;

class Login extends BaseController {
    private $userModel=NULL;
	private $googleClient=NULL;
	function __construct(){
		require_once APPPATH. "libraries/vendor/autoload.php";
		$this->userModel = new Login_model();
		$this->googleClient = new \Google_Client();
		$this->googleClient->setClientId("782664793698-sbor5g5hcobbc8hdu16fue0qjpudlec0.apps.googleusercontent.com");
		$this->googleClient->setClientSecret("njFCcEhYDlTDiPZoby7aC66V");
		$this->googleClient->setRedirectUri("http://localhost/restapi_oauth/public/Login/loginWithGoogle");
		$this->googleClient->addScope("email");
		$this->googleClient->addScope("profile");

	}
    public function index() {
        
        $data['googleButton'] = '<a href="'.$this->googleClient->createAuthUrl().'" ><button class="btn btn-sm btn-primary">Login with gmail</button></a>';
		return view('login_view', $data);
    }

	public function sa(){
		return view('login_view', $data);
	}

	public function loginWithGoogle()
	{
		 $t = $this->request->getVar('code');
		$token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
		if(!isset($token['error'])){
			$this->googleClient->setAccessToken($token['access_token']);
			session()->set("AccessToken", $token['access_token']);

			$googleService = new \Google_Service_Oauth2($this->googleClient);
			$data = $googleService->userinfo->get();
			$currentDateTime = date("Y-m-d H:i:s");
			session()->set("LoggedUserData", $data['givenName']);
		}else{
			session()->setFlashData("Error", "Something went Wrong");
			return redirect()->to(base_url());
		}
		//Successfull Login
		return redirect()->to(base_url()."/profile");
	}
}