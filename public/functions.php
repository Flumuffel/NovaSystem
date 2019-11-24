<?php


function getUserData($username)
{

    $cacheFile = "./cache/" . md5($username) . ".user.cache";



    if (!file_exists($cacheFile) || filemtime($cacheFile) < (time() - 120)) {
        $get_data = file_get_contents('https://api.roblox.com/users/get-by-username?username=' . $username);
        $data = json_decode($get_data, true);


        $get_group_infos = file_get_contents('https://api.roblox.com/users/' . $data['Id'] . '/groups');
        $data["Groups"] = json_decode($get_group_infos, true);

        file_put_contents($cacheFile, serialize($data));
    } else {
        $get_data = file_get_contents($cacheFile);
        $data = unserialize($get_data);
    }
    return $data;
}
