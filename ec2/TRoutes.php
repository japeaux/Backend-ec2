<?php
    require 'vendor/autoload.php';
    
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    // AWS Info
    $bucketName = 'diwoapppics';
    // Connect to AWS
    try {
    // You may need to change the region. It will say in the URL when the bucket is open
        // and on creation.
        $s3 = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => $IAM_KEY,
                    'secret' => $IAM_SECRET
                ),
                'version' => 'latest',
                'region'  => 'sa-east-1'
            )
    );
    } catch (Exception $e) {
        // We use a die, so if this fails. It stops here. Typically this is a REST call so this would
        // return a json object.
        die("Error: " . $e->getMessage());
    }

    $data_to_write = 'oi'
    $bucketName = 'diwoapppics';
    $file_Path = __DIR__ . '/js/router.js';
    // $file_handle =  
    
    // fclose($file_handle);
    $key = basename($file_Path);
    $keyName = 'apps/' . $_GET['nomenegocio'] . '/js/' . $key;
    try {
        $result = $s3->putObject([
            'Bucket' => $bucketName,
            'Key'    => $keyName,
            'Body'   => fopen(fwrite(fopen($file_Path, 'rw'), $data_to_write), 'r'),
        ]);
        echo $result->get('ObjectURL');
} catch (S3Exception $e) {
        die('Error:' . $e->getMessage());
    } catch (Exception $e) {
        die('Error:' . $e->getMessage());
    }
?>
