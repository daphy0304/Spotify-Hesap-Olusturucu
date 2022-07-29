<?php

set_time_limit(0);

function random($minlength = 20, $maxlength = 20, $uselower = true, $useupper = true, $usenumbers = true, $usespecial = false)
{
    $charset = '';
    if ($uselower) {
        $charset .= "abcdefghijklmnopqrstuvwxyz";
    }
    if ($useupper) {
        $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }
    if ($usenumbers) {
        $charset .= "123456789";
    }
    if ($usespecial) {
        $charset .= "~@#$%^*()_+-={}|][";
    }
    if ($minlength > $maxlength) {
        $length = mt_rand($maxlength, $minlength);
    } else {
        $length = mt_rand($minlength, $maxlength);
    }
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $charset[(mt_rand(0, strlen($charset) - 1))];
    }
    return $key;
}

if (!empty($_GET['rep'])) {
    $get_value = $_GET['rep']; // Kaç adet hesap oluşturulsun

    for ($i = 1; $i <= $get_value; $i++) {
        $username = random(8, 19, true, true, false, false);
        $email = random(11, 22, true, true, true, false);
        $password = random(11, 22, true, true, true, true);

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://spclient.wg.spotify.com/signup/public/v1/account/',
            CURLOPT_POST => 1,
            CURLOPT_HEADER => true,
            CURLOPT_POSTFIELDS => [
                "displayname" => $username,
                "creation_point" => "https://login.app.spotify.com?utm_source=spotify&utm_medium=desktop-win32&utm_campaign=organic",
                "birth_month" => "12",
                "email" => "$email@gmail.com",
                "password" => $password,
                "creation_flow" => "desktop",
                "platform" => "desktop",
                "birth_year" => "1991",
                "iagree" => "1",
                "key" => "a2d4b979dc624757b4fb47de483f3505",
                "birth_day" => "17",
                "gender" => "male",
                "password_repeat" => $password,
                "referrer" => ""
            ],
            CURLOPT_FOLLOWLOCATION => 1,
        ));

        $resp = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $data["acco$i"]['status'] = "$status";
        $data["acco$i"]['username'] = "$username";
        $data["acco$i"]['email'] = "$email@gmail.com";
        $data["acco$i"]['pass'] = "$password";
    }
    echo json_encode($data);
}
