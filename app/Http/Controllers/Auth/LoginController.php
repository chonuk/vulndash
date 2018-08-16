<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Adldap\Laravel\Facades\Adldap;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username() {
        return config('adldap_auth.usernames.eloquent');
    }

    protected function validateLogin(Request $request) {
        $this->validate($request, [
            $this->username() => 'required|string|regex:/^\w+$/',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request) {
        $credentials = $request->only($this->username(), 'password','dominio');
        $username = $credentials[$this->username()];
        $dominio = $credentials['dominio'];
        $password = $credentials['password'];
        $nombre = '';

        switch($dominio)
        {
            case 1: 
                $dominio = env('ADLDAP_DOMAIN_1', '');
                $adServer = env('ADLDAP_SERVER_1', '');
                $base_dn = env('ADLDAP_BASE_DN_1', '');
                $grupo = env('ADLDAP_GROUP_1', '');
                $grupoAdmin = env('ADLDAP_GROUP_ADMIN_1', '');
                break;

            case 2:
                $dominio = env('ADLDAP_DOMAIN_2', '');
                $adServer = env('ADLDAP_SERVER_2', '');
                $base_dn = env('ADLDAP_BASE_DN_2', '');
                $grupo = env('ADLDAP_GROUP_2', '');
                $grupoAdmin = env('ADLDAP_GROUP_ADMIN_2', '');
                break;
        }

        $ldapconn = ldap_connect($adServer) or $this->msg = "Could not connect to LDAP server.";
        $ldaprdn = $dominio. "\\" . $username; 
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0);

        $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $password); 

        if ($ldapbind)
        {
            $filter = "(&(samaccountname=$username) (objectClass=user)(objectCategory=person) (memberOf=$grupo) )";
            //$fields = array("department","company","cn","mail"); 
            $sr = ldap_search($ldapconn, $base_dn, $filter/*,$fields*/); 
            $info = ldap_get_entries($ldapconn, $sr); 
            
            $nombre = $info[0]["displayname"][0];
            

            if (!$nombre=='')
            {
                $user = \App\User::where($this->username(), $username) -> first();
                if (!$user) {
                    // the user doesn't exist in the local database, so we have to create one
                    $user = new \App\User();
                    $user->username = $username;
                    $user->name = $nombre;
                    $user->password = '';
                    $user->role = 'USER';
                    for ($i=0; $i<$info[0]["memberof"]["count"]; $i++) 
                    {
                        if($info[0]["memberof"][$i] == $grupoAdmin)
                        {
                            $user->role = 'ADMIN';
                        }
                    } 
                }
                #dd($user);
                $this->guard()->login($user, true);
                return true;
            }
            else
            {
                return false;
            }    
        }
        else
        {
            return false;
        }
    }
    
    protected function retrieveSyncAttributes($username) {
        $ldapuser = Adldap::search()->where(env('ADLDAP_USER_ATTRIBUTE'), '=', $username)->first();
        if ( !$ldapuser ) {
            // log error
            return false;
        }
        // if you want to see the list of available attributes in your specific LDAP server:
        // var_dump($ldapuser->attributes); exit;
        
        // needed if any attribute is not directly accessible via a method call.
        // attributes in \Adldap\Models\User are protected, so we will need
        // to retrieve them using reflection.
        $ldapuser_attrs = null;
        
        $attrs = [];
        
        foreach (config('adldap_auth.sync_attributes') as $local_attr => $ldap_attr) {
            if ( $local_attr == 'username' ) {
                continue;
            }
            
            $method = 'get' . $ldap_attr;
            if (method_exists($ldapuser, $method)) {
                $attrs[$local_attr] = $ldapuser->$method();
                continue;
            }
            
            if ($ldapuser_attrs === null) {
                $ldapuser_attrs = self::accessProtected($ldapuser, 'attributes');
            }
            
            if (!isset($ldapuser_attrs[$ldap_attr])) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }
            
            if (!is_array($ldapuser_attrs[$ldap_attr])) {
                $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr];
            }
            
            if (count($ldapuser_attrs[$ldap_attr]) == 0) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }
            
            // now it returns the first item, but it could return
            // a comma-separated string or any other thing that suits you better
            $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr][0];
            //$attrs[$local_attr] = implode(',', $ldapuser_attrs[$ldap_attr]);
        }
        
        return $attrs;
    }
    
    protected static function accessProtected ($obj, $prop) {
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

    public function logout()
    {
        Auth::logout();
        return view('home');
    }
    
}
