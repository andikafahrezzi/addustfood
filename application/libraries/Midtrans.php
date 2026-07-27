<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Midtrans\Config;

class Midtrans
{
    public function __construct()
    {
        $CI =& get_instance();
        
        // Load config midtrans
        $CI->config->load('midtrans');
        
        // Ambil config dengan validasi
        $config = $CI->config->item('midtrans');

        // Cek apakah file config benar-benar ada
        if (!file_exists(APPPATH . 'config/midtrans.php')) {
            log_message('error', 'Midtrans config file is missing!');
            // Fallback ke .env otomatis
        }
        
        // CEK: Apakah config terbaca?
        if (empty($config) || !is_array($config)) {
            // Jika config kosong, set default dari .env langsung
            $config = [
                'server_key' => $_ENV['MIDTRANS_SERVER_KEY'] ?? '',
                'client_key' => $_ENV['MIDTRANS_CLIENT_KEY'] ?? '',
                'is_production' => filter_var($_ENV['MIDTRANS_IS_PRODUCTION'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'is_sanitized' => filter_var($_ENV['MIDTRANS_SANITIZATION'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'is_3ds' => filter_var($_ENV['MIDTRANS_3DS'] ?? true, FILTER_VALIDATE_BOOLEAN),
            ];
        }
        
        // Set Midtrans Config
        Config::$serverKey = $config['server_key'] ?? '';
        Config::$clientKey = $config['client_key'] ?? '';
        Config::$isProduction = $config['is_production'] ?? false;
        Config::$isSanitized = $config['is_sanitized'] ?? true;
        Config::$is3ds = $config['is_3ds'] ?? true;
        
        // DEBUG: Cek apakah key terisi
        if (empty(Config::$serverKey)) {
            log_message('error', 'Midtrans Server Key is empty!');
            show_error('Midtrans Server Key is not configured properly.');
        }
    }
}