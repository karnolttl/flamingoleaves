<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface PostRepositoryInterface {

    public function getLatestPostsbyCurrentUserPaginated();

    public function getAllTagsAndCategories();

    public function validatePost(Request $request, $id = null);

    public function SaveNewPostAndGetID(Request $request);

    public function UpdatePostAndReturn(Request $request, $id);

}
