<?php
    require 'vendor/autoload.php';
    
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    // AWS Info
    $bucketName = 'diwoapppics';
    $IAM_KEY = 'AKIARKMVBDBD25H2G4WN';
    $IAM_SECRET = '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';
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
    
    // For this, I would generate a unqiue random string for the key name. But you can do whatever.
    $keyName = 'eventopicsdiwo/' . basename($_FILES["file"]['name']);
    $pathInS3 = 'https://s3.sa-east-1.amazonaws.com/' . $bucketName . '/' . $keyName;
//	$pathInS3 = 'https://diwoapppics.s3-sa-east-1/'  . $keyName;  
  // Add it to S3
        echo $keyName;
    try {
    // Uploaded:
        $file = $_FILES["file"]['tmp_name'];
        $s3->putObject(
            array(
                'Bucket'=>$bucketName,
                'Key' =>  $keyName,
                'SourceFile' => $file,
                'ContentType' =>'image/jpeg',
            )
    );
    } catch (S3Exception $e) {
        die('Error:' . $e->getMessage());
    } catch (Exception $e) {
        die('Error:' . $e->getMessage());
    }
    echo  'Diwo';
?>

