<?php 
namespace App\Http\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{
    private static function getJWTKey()
    {
        $envKey = env('JWT_SECRET');

        if (!$envKey) {
            throw new Exception('JWT_SECRET is not set in .env');
        }

        return str_starts_with($envKey, 'base64:')
            ? base64_decode(substr($envKey, 7))
            : $envKey;
    }

    public static function CreateToken($userEmail, $userId)
    {
        $key = self::getJWTKey();

        $payload = [
            'iss' => 'Laravel_token',
            'iat' => time(),
            'exp' => time() + 60 * 24,
            'userEmail' => $userEmail,
            'userId' => $userId,
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token){
        try{
           if($token == null){
               return "unauthorize";
           }else{
                  
              $key = self::getJWTKey();
              $decoded = JWT::decode($token, new Key($key,'HS256'));

              return $decoded;
           }



        }catch(Exception $e){
            return "unauthorize";
        }
    }
}


?>