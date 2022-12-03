<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;


class ApiRequestListener{

    private $jwtManager;
    private $tokenStorageInterface;

    public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    public function onKernelRequest(RequestEvent $event){

        $requestToken = $this->tokenStorageInterface->getToken();
        $request = $event->getRequest();

       
        /** If it is an API Request */
        if(preg_match("/\/api\/v1\/*/",$request->getPathInfo())){        
            
            /** $requestToken object has a getUser method which allows to 
                 * get the logged user.
                 */
            if($requestToken){
                
                /** $decodedJwtToken is an object (Array) which has the information
                 * contained in the token, such as: username, exp, iat, etc.
                 */
                $decodedJwtToken = $this->jwtManager->decode($requestToken);
               
               /** The intend of this method, yet to be implemented is to check whether the token is in
                * a blocklist and, if so, reject the request.
                */
                error_log('Token exists. ');
            }else{
               /** If the token doesn't exist at all, should reject the request. */
                error_log('Token doesn\'t exist.');
               return new RedirectResponse('api_login');
            }

        }
        
                
                

    }
}
