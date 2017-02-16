<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Img;
use Auth;
use Session;
use Image;
use Storage;

class ImgRepository implements ImgRepositoryInterface {

    public function saveImgs(Request $request, $postId) {

        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $filename = uniqid(time()) . '.' . $image->getClientOriginalExtension();
                $location = public_path('img/' . $filename);
                Image::make($image)
                    ->resize(null, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();})
                    ->save($location);

                Img::create([
                    'name' => $filename,
                    'owner_id' => Auth::user()->id,
                    'post_id' => $postId,
                ]);
            }
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
