<?php
require_once("vendor/autoload.php");
require("form.php");


use Aws\s3\s3Client;
use Aws\Credentials\Credentials;
use Aws\Exception\AwsException;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {


    $credentials = new Credentials(Access_Key,Secret_Key);

    $s3 = new s3Client([
        'version' => 'latest',
        'region' => Buket_Region,
        'credentials' => $credentials
    ]);

    $file_name = $_FILES["file"]["name"];
    $file_info = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = uniqid() . ".$file_info";
    $file_temp = $_FILES['file']['tmp_name'];

    try {
        $result = $s3->putObject([
            'Bucket' => Buket_Name,
            'Key' => $new_file_name,
            'Body' => fopen($file_temp, 'r')
        ]);

        echo ('<center><h1>your file uploaded successfully on ' . $result['ObjectURL'].'</center></h1>');
    } catch (AwsException $e) {
        echo $e->getMessage();
    }
}


