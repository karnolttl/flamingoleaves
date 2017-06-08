<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface ImgRepositoryInterface {

    public function saveImg(Request $request, $postId);

    public function destroyImgAndGetPostID($id);

}
