<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\CommentRecordNotification;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\AutobotResources;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Faker\Generator as Faker;

class CommentController extends Controller
{
    public function create($id){
        //$response = Http::get('https://jsonplaceholder.typicode.com/comments');
       // $comments = collect($response->json())->random();
       // dd( $comments);

        //  $post = (new PostController)->create($creatingbot);

        $request_param = "";
        $req = "GET";
        $server = "https://jsonplaceholder.typicode.com/comments/$id";
       // $server = "https://jsonplaceholder.typicode.com/comments";

         $response = (new AutobotsController)->sendAPIPOSTRequest($request_param, $req, $server, $payload = '', $custom_hdr = array());
        $comments = json_decode($response);
       // dd($comments[0]);
        foreach ($comments as $comment) {
            $record = Comment::create([
                'postId' => ((empty($id)) ? "no record" : $id),
                'name' => ((empty($comment->name)) ? fake()->name() : $comment->name),
                'email' => ((empty($comment->email)) ? fake()->unique()->safeEmail() : $comment->email),
                'body' => ((empty($comment->body)) ? fake()->words(rand(5, 15), true) : $comment->body),
            ]);


            $users = Comment::count();
            event(new CommentRecordNotification($users));
            return $record->id;
        }
    
    }

    public function view(){
        $response = array();
        $displayrecords = Comment::paginate(10);

        if(empty($displayrecords)){
            $response['massage'] = "Record is empty";
            $response['status'] = "failed";
        }else{

            $response['massage'] = $displayrecords;
            $response['status'] = "success";
        }

        return new AutobotResources($response);
    }

    public function view_by_commentid($id){
        $response = array();
        $displayrecords = Comment::where('postId', $id)->paginate(10);

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
