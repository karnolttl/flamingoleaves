<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Img;
use Auth;
use Session;
use Image;
use Storage;
use Illuminate\Support\Facades\Log;

class ImgRepository implements ImgRepositoryInterface {

    public function saveImg(Request $request, $postId = null) {

        if (!$request->hasFile('image')) {
            return;
        }

        $image = $request->image;
        $filename = uniqid(time()) . '.' . $image->getClientOriginalExtension();
        $location = public_path('img/' . $filename);
        Image::make($image)
            ->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();})
            ->save($location);

        if (!isset($postId)) {
            $user = Auth::user();
            $user->img = $filename;
            $user->save();
        } else {
            //remove existing featured image if updating
            $img = Img::where('post_id',$postId)->first();
            if (isset($img)) {
                Storage::delete($img->name);
                $img->delete();
            }

            Img::create([
                'name' => $filename,
                'owner_id' => Auth::id(),
                'post_id' => $postId,
            ]);
        }

    } //end saveImgs

    public function destroyImgAndGetPostID($id) {

        $img = Img::find($id);
        Storage::delete($img->name);
        $img->delete();

        Session::flash('success', 'The image was succesfully deleted.');

        return $img->post_id;


    }

}
