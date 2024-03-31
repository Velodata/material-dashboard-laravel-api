<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
   // refer to article by https://medium.com/@mark.tabletpc/implementing-oauth2-single-sign-on-sso-in-a-laravel-step-by-step-guide-ab910e26c22a

   // public function redirectToGoogle()
   // {
   //    return Socialite::driver('google')->redirect();
   // }
   
   // public function handleGoogleCallback()
   // {
   //    $user = Socialite::driver('google')->user();
   //    // Check if the user exists in your system based on their email or other unique identifier.
   //    // If not, create a new user account.
   //    // Log in the user using JWT or other authentication method.
   // }


   public function redirectToAuth(): JsonResponse
   {
       return response()->json([
           'url' => Socialite::driver('google')
                        ->stateless()
                        ->redirect()
                        ->getTargetUrl(),
       ]);
   }

   public function handleAuthCallback(): JsonResponse
   {
       try {
           /** @var SocialiteUser $socialiteUser */
           $socialiteUser = Socialite::driver('google')->stateless()->user();
       } catch (ClientException $e) {
           return response()->json(['error' => 'XX Invalid credentials provided.'], 422);
       }
       /** @var User $user */
       $user = User::query()
           ->firstOrCreate(
               [
                   'email' => $socialiteUser->getEmail(),
               ],
               [
                   'email_verified_at' => now(),
                   'name' => $socialiteUser->getName(),
                   'google_id' => $socialiteUser->getId(),
                   'password' => $socialiteUser->getId(),
                   'avatar' => $socialiteUser->getAvatar(),
                   'profile_image' => $socialiteUser->getAvatar(),
               ]
           );
       $token = $user->createToken('google-token');
      //  $plainToken = $token->plainTextToken;
       return response()->json([
           'user' => $user,
         //   'access_token' => $user->createToken('google-token')->plainTextToken,
           'access_token' => $token,
           'token_type' => 'Bearer',
       ]);
   }
}

