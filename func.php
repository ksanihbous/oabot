<?php

class Client{

    public $AccessToken;
    public $channelSecret;
    public $versions;

    //ToDo 外部ファイルからの参照にする
    function __construct($AccessToken,$channelSecret,$versions) {
        $this->AccessToken = "7V/qX3Y43FkVnCU2d/h3GTGwn80Y3kQ1cZcDz3Ls5hKn31ftO7i+0ZHbPvcyOaVoDqM4RpkbHCaveOt36EOX1YSXZSTcCuUAXoKhKRPtTbhcMfiJfdoMVX8O97c/0+kzcooP5Fx6OnimQFWL/FRuygdB04t89/1O/w1cDnyilFU=";
        $this->channelSecret = "a05e5b7c38447c1d51b1a2dafff8b787";
        $this->versions = "0.1";
    }

    //ToDo Meta情報のメソッド名を関連付けたものにする
    public function PostText($reptoken,$mes){
        $data = [
            "replyToken" => $reptoken,
            "messages" => [
                [
                    "type" => "text",
                    "text" => $mes
                ]
            ]
        ];

        return $data;
    }

    public function PostMultiCast($reptoken,$mes,$mids){
        $data = [
            "replyToken" => $reptoken,
            "to" => $mids,
            "messages" => [
                [
                    "type" => "text",
                    "text" => $mes
                ]
            ]
        ];

        return $data;
    }

    //ToDo SDKの作成
    public function ReplyMessage($data){
        $ch = curl_init("https://api.line.me/v2/bot/message/reply");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $this->AccessToken
        )
    );
    $result = curl_exec($ch);
    curl_close($ch);
    }

    public function MultiCastMessage($data){
        $ch = curl_init("https://api.line.me/v2/bot/message/multicast");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $this->AccessToken
        )
    );
    $result = curl_exec($ch);
    curl_close($ch);
    }

    public function SendMessage($data){
        $ch = curl_init("https://api.line.me/v2/bot/message/push");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $this->AccessToken
        )
    );
    $result = curl_exec($ch);
    curl_close($ch);
    }

    //Todo 動かないので動くように
    public function leaveGroup($gid){
        $ch = curl_init("https://api.line.me/v2/bot/group/".$gid."/leave");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $this->AccessToken,
            'X-Line-ChannelSecret: ' . $this->channelSecret
        )
    );
    $result = curl_exec($ch);
    curl_close($ch);
    }

    public function GetContents($mesId){
        $ch = curl_init("https://api.line.me/v2/bot/message/".$mesId."/content");
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $this->AccessToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function getProfile($mid){
        $ch = curl_init("https://api.line.me/v2/bot/profile/".$mid);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $this->AccessToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function getGroup($gid,$mid){
        $ch = curl_init("https://api.line.me/v2/bot/group/".$gid."/member/".$mid);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $this->AccessToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function getMemberIds($gid){
        $ch = curl_init("https://api.line.me/v2/bot/group/".$gid."/members/ids");
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $this->AccessToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    //ToDo データベース化する(予定ではSQlite)
    public function ModeAdd($text){
        $a = fopen("./mode.txt", "w");
        @fwrite($a, $text);
        fclose($a);
    }

    public function ModeGet(){
        $file = './mode.txt';
        $res = file_get_contents($file);
        return $res;
    }

    public function SiritoriAdd($text){
        $a = fopen("./Siritori.txt", "w");
        @fwrite($a, $text);
        fclose($a);
    }

    public function SiritoriGet(){
        $file = './Siritori.txt';
        $res = file_get_contents($file);
        return $res;
    }

    public function RegiAdd($text){
        $a = fopen("./regi.txt", "w");
        @fwrite($a, $text);
        fclose($a);
    }

    public function RegiGet(){
        $file = './regi.txt';
        $res = file_get_contents($file);
        return $res;
    }

    //Todo バージョン管理もSQliteでする
    public function Version(){
        return $this->versions;
    }
}

?>
