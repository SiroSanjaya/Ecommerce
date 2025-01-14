<?php

namespace App\Controllers;

use Google\Client;
use Google_Service_Oauth2;
use App\Models\UserModel;

class AuthController extends BaseController
{
    private $googleClient;

    public function __construct()
    {
        // Inisialisasi Google Client
        $this->googleClient = new Client();
        $this->googleClient->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $this->googleClient->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $this->googleClient->setRedirectUri('http://localhost:8080/auth/callback');
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    /**
     * Redirect ke halaman login Google
     */
    public function login()
    {
        $googleLoginUrl = $this->googleClient->createAuthUrl();
        return redirect()->to($googleLoginUrl);
    }

    /**
     * Callback setelah autentikasi Google
     */
    public function callback()
    {
        $code = $this->request->getVar('code');
        if ($code) {
            try {
                // Ambil token dari Google
                $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
                
                // Pastikan token valid
                if (isset($token['access_token'])) {
                    $this->googleClient->setAccessToken($token['access_token']);

                    // Ambil informasi user dari Google
                    $googleService = new Google_Service_Oauth2($this->googleClient);
                    $userData = $googleService->userinfo->get();

                    // Validasi apakah data 'name' ada
                    if (empty($userData->name)) {
                        throw new \Exception('Name not found in Google user data');
                    }

                    // Cek atau simpan user ke database
                    $userModel = new UserModel();
                    $user = $userModel->where('google_id', $userData->id)->first();

                    if (!$user) {
                        // Jika user belum terdaftar, simpan ke database
                        $userModel->save([
                            'name' => $userData->name,
                            'email' => $userData->email,
                            'role' => 'user', // Default role
                            'profile_pic' => $userData->picture, // Menyimpan foto profil
                            'google_id' => $userData->id, // Simpan Google ID
                        ]);
                        $user = $userModel->where('google_id', $userData->id)->first();
                    }

                    // Simpan data user ke session
                    session()->set('isLoggedIn', true);
                    session()->set('user', [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'profile_pic' => $user['profile_pic'],
                    ]);

                    return redirect()->to('/admin/dashboard'); // Redirect ke dashboard
                } else {
                    throw new \Exception('Failed to get access token from Google');
                }
            } catch (\Exception $e) {
                return redirect()->to('/auth/login')->with('error', 'Login failed. Please try again: ' . $e->getMessage());
            }
        }

        return redirect()->to('/auth/login')->with('error', 'Authorization code not found.');
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
