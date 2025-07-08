<?php
class AccountService {
    public static function updateProfile($userId, $data, $file = null) {
        $um = UserModel::getInstance();

        $fields = [
            'firstname', 'lastname', 'username', 'email',
            'display_name', 'bio'
        ];

        // Duy trì key => value cho dữ liệu không rỗng
        $datas = [];
        foreach ($fields as $field) {
            $value = trim($data[$field] ?? '');
            if ($value !== '') {
                $datas[$field] = $value;
            }
        }
        // Kiểm tra username đã tồn tại
        if (isset($datas['username']) &&
            $um->getRecordWhere([
                'username' => $datas['username'],
                [['field' => 'id', 'comparisonOp' => '!=', 'value' => $userId]]
            ])) {
            return ['error' => "Username is already taken."];
        }

        // Kiểm tra email đã tồn tại
        if (isset($datas['email']) &&
            $um->getRecordWhere([
                'email' => $datas['email'],
                [['field' => 'id', 'comparisonOp' => '!=', 'value' => $userId]]
            ])) {
            return ['error' => "Email is already in use."];
        }

        // Xử lý upload ảnh đại diện
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $datas['avatar_url'] = UploadService::upload($file, ['folder' => 'users'], 'avatar');
        }

        // Cập nhật dữ liệu
        if (!empty($datas)) {
            $um->updateWhere($datas, "id = $userId");
            return ['success' => true];
        }

        return ['info' => "No changes were made."];
    }

    public static function changePassword($userId, $current, $new, $confirm) {
        $um = UserModel::getInstance();
        $user = $um->getUserById($userId);

        if (!$user || $user['password'] !== md5($current)) {
            return ['error' => "Current password is incorrect."];
        }

        if (strlen($new) < 6) {
            return ['error' => "New password must be at least 6 characters."];
        }

        if ($new !== $confirm) {
            return ['error' => "New passwords do not match."];
        }

        $um->updateWhere(['password' => md5($new)], "id = $userId");
        return ['success' => "Password changed successfully!"];
    }

    public static function checkExist($type, $value, $userId) {
        $um = UserModel::getInstance();
        $conditions = [
            $type => $value,
            [['field' => 'id', 'comparisonOp' => '!=', 'value' => $userId]]
        ];
        return (bool)$um->getRecordWhere($conditions);
    }
}
