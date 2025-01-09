<?php

// AES encryption function
function encrypt($data, $key) {
    $cipher = "aes-256-cbc"; // AES encryption with CBC mode
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher)); // Generate a random IV
    $encryptedData = openssl_encrypt($data, $cipher, $key, 0, $iv);
    return base64_encode($iv . $encryptedData); // Return Base64-encoded data with IV
}

// AES decryption function
function decrypt($data, $key) {
    $cipher = "aes-256-cbc"; // AES encryption with CBC mode
    $decodedData = base64_decode($data);
    $iv = substr($decodedData, 0, openssl_cipher_iv_length($cipher)); // Extract IV
    $encryptedData = substr($decodedData, openssl_cipher_iv_length($cipher)); // Extract encrypted data
    return openssl_decrypt($encryptedData, $cipher, $key, 0, $iv); // Decrypt the data
}

$key = "heitech-village-2"; // Use a secure key

?>