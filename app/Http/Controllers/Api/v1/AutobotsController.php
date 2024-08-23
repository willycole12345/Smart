<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\RecordUpdateNotification;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\AutobotResources;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Faker\Generator as Faker;



class AutobotsController extends Controller
{
    public function create($i)
    {

        $request_param = "";
        $req = "GET";
        $server = "https://jsonplaceholder.typicode.com/users";

       $response =  $this->sendAPIPOSTRequest($request_param, $req, $server, $payload = '', $custom_hdr = array());
        $autobots = json_decode($response);
    //   dd( $autobots);
         //$response = Http::connectTimeout(300)->get('https://jsonplaceholder.typicode.com/users');
        //$response = Http::connectTimeout(300)->get('https://jsonplaceholder.com/users');
       // $autobot = $response->json();
        // dd( $autobot);
      // foreach ($autobots as $autobot) {
            $record = User::create([
                'name' => ((empty($autobots[$i]->name)) ? fake()->name() : $autobots[$i]->name),
                'username' => ((empty($autobots[$i]->username)) ? fake()->username() : $autobots[$i]->username),
                'email' => ((empty($autobots[$i]->email)) ? fake()->unique()->safeEmail() : $autobots[$i]->email),
                'password' => "password",
                'phone' => ((empty($autobots[$i]->phone)) ? fake()->phoneNumber() : $autobots[$i]->phone),
                'website' => ((empty($autobots[$i]->website)) ? fake()->domainName() : $autobots[$i]->website),
            ]);
    //    foreach ($autobots as $autobot) {
    //         $record = User::create([
    //             'name' => ((empty($autobot[$i]->name)) ? fake()->name() : $autobot[$i]->name),
    //             'username' => ((empty($autobot[$i]->username)) ? fake()->username() : $autobot[$i]->username),
    //             'email' => ((empty($autobot[$i]->email)) ? fake()->unique()->safeEmail() : $autobot[$i]->email),
    //             'password' => "password",
    //             'phone' => ((empty($autobot[$i]->phone)) ? fake()->phoneNumber() : $autobot[$i]->phone),
    //             'website' => ((empty($autobot[$i]->website)) ? fake()->domainName() : $autobot[$i]->website),
    //         ]);
            $users = User::count();
            event(new RecordUpdateNotification($users));
            return $record->id;
       // }
    }


    public function autocreation()
    {

        for ($i = 0; $i < 500; $i++) {
        
           $creatingbot = $this->create($i);
        }
        $this->autoocreatepost();
        $this->autocreatecomment();
    }

    public function autoocreatepost()
    {
        $selects = User::all();

        foreach ($selects as $select) {
            $check_if_exist = Post::where('userid', $select->id)->get();
            if (!$check_if_exist) {

            } else {
                for ($j = 0; $j < 10; $j++) {
                    $post = (new PostController)->create($select->id);
                    //(new CommentController)->create($post );
                }
            }

        }
    }

    public function autocreatecomment(){
        $selects = Post::all();
        foreach ($selects as $select) {
            $check_if_exist = Comment::where('postId', $select->id)->get();
            if (!$check_if_exist) {

            } else {
                for ($j = 0; $j < 10; $j++) {
                    $post = (new CommentController)->create($select->id);
                    //(new CommentController)->create($post );
                }
            }

        }
    }

    public function totalUsersCreated()
    {
        $users = User::count();
      //  dd($users);
      //  event(new RecordUpdateNotification('welcome'));
        event(new RecordUpdateNotification($users));
    }

    public function view()
    {

        $response = array();
        $displayrecords = User::paginate(10);

        if (empty($displayrecords)) {
            $response['massage'] = "Record is empty";
            $response['status'] = "failed";
        } else {

            $response['massage'] = $displayrecords;
            $response['status'] = "success";
        }

        return new AutobotResources($response);
    }


       
    public function sendAPIPOSTRequest($request_param, $req, $server, $payload = '', $custom_hdr = array())
    {
        // echo '<br>'.'URL Called: '.$server.'<br>' ;
        // echo '<br>'.'Sha1: '.sha1('sa123').'<br>' ;
        ini_set('max_execution_time', 18000);

        $post_vars = '';

        if ((!empty($request_param))  && is_array($request_param)) {
            $post_vars = http_build_query($request_param);
        }

        //var_dump($post_vars) ;

        $headers = array(
            //"Content-length: ".(strlen($request_param)+strlen($payload)),
            "Accept: application/json",
            "Connection: open",
           // "Authorization: Bearer sk_test_d72d0d8626e2f7be6ead4f90f980b9034996fe13",
           // "Authorization: Bearer sk_live_b678e1239c19f63106f837aa154f345b5e18dab6",
        );

        if ($req == 'POST') {

            $contenttype = ((!$payload) ? ' application/x-www-form-urlencoded' :  ' application/json');

            $headers = array(
                "Content-length: " . (strlen($payload) + strlen($post_vars)),
                "Content-Type:" . $contenttype,
                  //"Authorization: Bearer sk_live_b678e1239c19f63106f837aa154f345b5e18dab6",
                 // "Authorization: Bearer sk_test_d72d0d8626e2f7be6ead4f90f980b9034996fe13",
            );
            
        }

        $headers = ((empty($custom_hdr)) ? $headers : $custom_hdr);

      	//var_dump($headers) ;

        $ch = curl_init();

        //$ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);     // Not needed and counter productive
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 4000);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 100);

        $posteds = ($req  === 'POST') ? true : false;
        curl_setopt($ch, CURLOPT_POST, $posteds);
        if ($posteds) curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        $bodyofreq = ((($payload !== '') || ($post_vars !== '')) ? true : false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($bodyofreq) curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars . $payload);

        $arr_logs =  [];
        $return_dumps  = '';
        $return_stat  = '';
        $dataout = [];

        $yy = false;

        //var_dump('where is this coming from ');
        $data = curl_exec($ch);

        if (curl_errno($ch)) {
            // print curl_error($ch);

            // echo "  something went wrong..... try later";
            $error_arr = array(
                'status' => false,
                'errormecode' => '99',
                'errormessage' => curl_error($ch),
                'url' => $server
            );

            $data = json_encode($error_arr);
            $return_stat  = 'Socket Error: Failed';
            $return_dumps = $data;          // json_encode($dataout) ;

            curl_close($ch);
        } else {


            $yy = true;
            $return_stat  = 'completed successfully';
            $return_dumps =  $data;

            curl_close($ch);
        }

        $data_out = $data;

        return $data_out;
    }



}
