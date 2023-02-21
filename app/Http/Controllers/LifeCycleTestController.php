<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{

    // 追記
    // サービスプロバイダー
    public function showServiceProviderTest(){
        $encrypt = app()->make("encrypter");
        $password = $encrypt->encrypt("password");
        $sample =app()->make("serviceProviderTest");

        dd($sample ,$password, $encrypt->decrypt($password));
    }

    public function showServiceContainerTest() {
        // サービス登録
        app()->bind("lifeCycleTest", function(){
            return "ライフサークル";
        });

        // サービス取り出し
        $test = app()->make("lifeCycleTest");

        // サービスなしのパターン
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();

        // サービスコンテナapp()ありのパターン
        // newでインスタンス化しなくても使える
        app()->bind("sample", Sample::class);
        $sample = app()->make("sample");
        $sample->run();

        dd($test, app());
    }
}

class sample{
    public $message;
    public function __construct(Message $message) {
        $this->message = $message;
    }
    public function run(){
        $this->message->send();
    }
}

class Message
{
    public function send(){
        echo("メッセージ");
    }
}
