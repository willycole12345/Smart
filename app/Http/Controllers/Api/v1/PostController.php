<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\PostRecordNotification;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\AutobotResources;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function create($id){
        // $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        // $post = collect($response->json())->random();

        $request_param = "";
        $req = "GET";
        $server = "https://jsonplaceholder.typicode.com/posts/$id";

       $response = (new AutobotsController)->sendAPIPOSTRequest($request_param, $req, $server, $payload = '', $custom_hdr = array());
        $post = json_decode($response);
      //  dd($posts->userId);
        $post_title_check = Post::where('title', $post->title)->get();
        if($post_title_check){
            $record =  Post::create([
                "userid"=> ((empty($id))? "no record" :$id),
                "title"=>  fake()->sentence(3) ,
                "body"=> ((empty($post->body))?fake()->words(rand(5, 15), true) : $post->body),
                    //    return $record->id;
           ]);

        } else {
            $record =  Post::create([
                "userid"=> ((empty($id))? "no record" :$id),
                "title"=> ((empty($post->title))? fake()->sentence(3) : $post->title),
                "body"=> ((empty($post->body))?fake()->words(rand(5, 15), true) : $post->body),
                    //    return $record->id;
           ]);
        }
        $users = Post::count();
        event(new PostRecordNotification($users));
        return $record->id;
    }


    public function view(){
        $response = array();
        $displayrecords = Post::paginate(10);

        if(empty($displayrecords)){
            $response['massage'] = "Record is empty";
            $response['status'] = "failed";
        }else{

            $response['massage'] = $displayrecords;
            $response['status'] = "success";
        }

        return new AutobotResources($response);
    }

    public function view_with_id($id){
        $response = array();
        $displayrecords = Post::where('userid',$id)->paginate(10);

        if(empty($displayrecords)){
            $response['massage'] = "Record is empty";
            $response['status'] = "failed";
        }else{

            $response['massage'] = $displayrecords;
            $response['status'] = "success";
        }

        return new AutobotResources($response);
    }
}
