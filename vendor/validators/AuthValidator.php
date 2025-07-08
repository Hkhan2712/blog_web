<?php 
class AuthValidator {
    public static function validate($email, $password) {
        if (empty($email) || empty($password)) {
            return ['message' => 'Email and passwrod can not be empty!'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['message' => 'Email is not valid'];
        }
        return true;
    }
    public static function validateRegister($data) {
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            return ['message' => 'All fields are required!'];
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['message' => 'Email is not valid!'];
        }
        if ($data['password'] !== $data['repeat_password']) {
            return ['message' => 'Passwords do not match!'];
        }
        return true;
    }
}