<?php 
class PostRepository
{
    private static function assignCategories($postId, $jsonInput)
    {
        if (empty($jsonInput)) return;

        $categoriesJson = json_decode($jsonInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Invalid JSON in 'categories': " . json_last_error_msg());
            return;
        }

        if (!is_array($categoriesJson)) {
            error_log("Decoded 'categories' is not an array.");
            return;
        }

        $allCategories = CategoryModel::getInstance()->getRecords('*');
        $postCategoryModel = PostCategoryModel::getInstance();

        foreach ($categoriesJson as $item) {
            $catName = trim($item['value'] ?? '');
            if (!$catName) continue;

            $catId = null;
            foreach ($allCategories as $cat) {
                if (strcasecmp($cat['name'], $catName) === 0) {
                    $catId = $cat['id'];
                    break;
                }
            }

            if ($catId !== null) {
                $postCategoryModel->addPostToCategory($postId, $catId);
            } else {
                error_log("Category not found: " . $catName);
            }
        }
    }

    private static function handleTags($postId, $tagInput)
    {
        $tagsArray = [];
        $json = json_decode(trim($tagInput), true);

        if (!is_array($json)) return;

        foreach ($json as $tagItem) {
            if (!empty($tagItem['value'])) {
                $tagsArray[] = trim($tagItem['value']);
            }
        }

        if (empty($tagsArray)) return;

        $tagModel = TagModel::getInstance();
        $postTagModel = PostTagModel::getInstance();

        foreach ($tagsArray as $tagName) {
            $tag = $tagModel->getRecordByField('name', $tagName);
            $tagId = $tag ? $tag['id'] : $tagModel->addRecord(['name' => $tagName]);
            $postTagModel->addTagToPost($postId, $tagId);
        }
    }
    public static function view($id) {
        $data = PostModel::getInstance()->getRecordsAdvanced(
            'posts.*, users.username as author',
            ['posts.id' => $id],
            [
                'join' => ['users' => 'posts.user_id = users.id'], 
                'limit' => 1
            ]
        );

        if (empty($data)) {
            return null;
        }

        return ['post' => $data[0], 'user' => ['username' => $data[0]['author']]];
    }

    public static function save($postData, $fileData)
    {
        $title   = trim($postData['title'] ?? '');
        $status  = trim($postData['status'] ?? 'draft');
        $content = trim($postData['content'] ?? '');
        $image   = '';
        if (isset($fileData['image']) && $fileData['image']['error'] === UPLOAD_ERR_OK) {
            $image = ImageHelper::uploadMultipleSizesImg($fileData, 'image');
        }

        if (!$title || !$content) {
            return false;
        }

        $postModel = PostModel::getInstance();
        $postId = $postModel->addRecord([
            'title'     => $title,
            'status'    => $status,
            'content'   => $content,
            'image_url' => $image ?: 'default.png',
            'user_id'   => (int)($_SESSION['user']['id'] ?? 0),
        ]);

        // --- CATEGORIES ---
        if (!empty($postData['categories'])) {
            self::assignCategories($postId, $postData['categories']);
        }

        // --- TAGS ---
        if (!empty($postData['tags'])) {
            self::handleTags($postId, $postData['tags']);
        }

        return $postId;
    }

    public static function update($id, $postData, $fileData, $currentRecord)
    {
        $title = trim($postData['title'] ?? '');
        $content = trim($postData['content'] ?? '');
        $status = $postData['status'] ?? 'draft';
        $image = $currentRecord['image_url'];

        if (isset($fileData['image']) && $fileData['image']['error'] === UPLOAD_ERR_OK) {
            $image = ImageHelper::uploadMultipleSizesImg($fileData, 'image');
        }

        if (!$title || !$content) return false;

        PostModel::getInstance()->updateWhere([
            'title'     => $title,
            'content'   => $content,
            'image_url' => $image,
            'status'    => $status,
            'updated_at'=> date('Y-m-d H:i:s')
        ], "id = $id");

        $postCategoryModel = PostCategoryModel::getInstance();
        $postCategoryModel->deleteRecordsWhere("post_id = $id");

        if (!empty($postData['categories'])) {
            self::assignCategories($id, $postData['categories']);
        }


        $postTagModel = PostTagModel::getInstance();
        $postTagModel->deleteRecordsWhere("post_id = $id");

        if (!empty($postData['tags'])) {
            self::handleTags($id, $postData['tags']);
        }

        return true;
    }
    public static function delete($id)
    {
        $m = PostModel::getInstance();
        $record = $m->getRecord($id);

        if (!$record) return false;

        $m->delRecord($id);
        PostCategoryModel::getInstance()->deleteRecordsWhere("post_id = $id");
        PostTagModel::getInstance()->deleteRecordsWhere("post_id = $id");

        return true;
    }

    public static function getRecommendedPosts($postId, $limit = 3)
    {
        $posts = PostModel::getInstance()->getRecordsWhereNotId($postId, $limit);
        $data = [];
        foreach ($posts as $post) {
            $user = PURepository::getUserByPostId($post['id']);
            if ($user) {
                $post['user'] = $user;
                $data[] = $post;
            }
        }
        if (empty($data)) {
            header('HTTP/1.0 404 Not Found');
            exit('No recommended posts found or users missing.');
        }

        return $data;
    }
    public static function getOutstandingPost(){
        $data = PostModel::getInstance()->getRecordsAdvanced('*', [], [
            'order' => '(like_quantity + comment_quantity) DESC, created_at DESC',
            'limit' => 1
        ]);
        $data = $data[0];
        $data['user'] = PURepository::getUserByPostId($data['id']);
        if (!$data['user']) {
            header('HTTP/1.0 404 Not Found');
            exit('User not found for the outstanding post.');   
        }
        return $data;
    }
    public static function getNewestPosts($limit = 10)
    {
        $data = PostModel::getInstance()->getRecordsAdvanced('*', [], [
            'order' => 'created_at DESC',
            'limit' => $limit
        ]);
        foreach ($data as &$post) {
            $post['user'] = PURepository::getUserByPostId($post['id']);
            if (!$post['user']) {
                header('HTTP/1.0 404 Not Found');
                exit('User not found for one of the newest posts.');     
            }
        }
        return $data;
    }
    public static function getPaginatedPosts($limit = 10, $offset = 0)
    {
        $data = PostModel::getInstance()->getRecordsAdvanced(
            'posts.*, users.username as author',  
            [], 
            [
                'join' => ['users' => 'posts.user_id = users.id'], 
                'order' => 'posts.created_at DESC', 
                'limit' => $limit,  
                'offset' => $offset 
            ]
        );

        return $data;
    }
    public static function getPostListWithPagination($page = 1, $limit = 12)
    {
        $page = max(1, intval($page));
        $offset = ($page - 1) * $limit;

        $totalPosts = PostModel::getInstance()->getCountRecords();
        $totalPages = ceil($totalPosts / $limit);

        $posts = self::getPaginatedPosts($limit, $offset);

        return [
            'posts'       => $posts,
            'totalPages'  => $totalPages,
            'currentPage' => $page
        ];
    }

}