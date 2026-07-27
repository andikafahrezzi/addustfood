<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Pakai $_ENV (karena getenv() tidak jalan)
$config['server_key'] = $_ENV['MIDTRANS_SERVER_KEY'] ?? '';
$config['client_key'] = $_ENV['MIDTRANS_CLIENT_KEY'] ?? '';
$config['is_production'] = filter_var($_ENV['MIDTRANS_IS_PRODUCTION'] ?? false, FILTER_VALIDATE_BOOLEAN);
$config['is_sanitized'] = filter_var($_ENV['MIDTRANS_SANITIZATION'] ?? true, FILTER_VALIDATE_BOOLEAN);
$config['is_3ds'] = filter_var($_ENV['MIDTRANS_3DS'] ?? true, FILTER_VALIDATE_BOOLEAN);