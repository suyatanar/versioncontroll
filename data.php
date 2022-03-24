<?php 
require_once 'db.php';
date_default_timezone_set('Asia/Singapore');
$db = new Database();

$request_url['query'] = '';

if(isset($_POST['getdata'])){

    $url = explode('/', str_replace(HOME . "/data.php/", "", $_POST['request_url']));

    if ($_POST['method_name'] == 'post'){
        $id = end($url);  

        if (intval($id) == false) {
            $data = $db->getALLVersion();
            echo $data;
        }else{
            if(!empty($_POST['update_data'])) {   
                $data = json_decode($_POST['update_data']);
                $name = (!empty($data->name)) ? $data->name : '';

                $timestamp = (!empty($data->timestamp)) ? $data->timestamp : date('Y-m-d H:i:s');

                $db->createVersionByID($id, $name, $timestamp);
            }else{
                if(!empty($id)){
                    $data = $db->getVersionByID($id);
                    echo ($data == false) ? "Nothing Found!" : $data;
                }
            }
        }             
                
    }else{
        $request_url = parse_url($_POST['request_url']);
        if(!empty($request_url['query'])){
            parse_str($request_url['query'], $result);
            if (is_array($result)) {

                if(array_key_exists('id', $result) && array_key_exists('timestamp', $result)){
                    $data = $db->getVersion($result['id'], $result['timestamp']);
                    echo ($data == false) ? "Nothing Found!" : $data;
                }else{
                    if(array_key_exists('id', $result)){
                        $data = $db->getVersionByID($result['id']);
                        echo ($data == false) ? "Nothing Found!" : $data;
                    }

                    if(array_key_exists('timestamp', $result)){
                        $data = $db->getVersionByTimestamp($result['timestamp']);
                        echo ($data == false) ? "Nothing Found!" : $data;
                    }
                }
                
            }
        }else{
            $data = $db->getALLVersion();
            echo $data;
        } 
    }    

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Version</title>
</head>
<body>
    <a href="<?php echo HOME;?>">Make a new request</a>
</body>
</html>