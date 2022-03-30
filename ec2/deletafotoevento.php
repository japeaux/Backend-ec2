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
    
    $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request = json_decode($postdata);
        $keyName = $request->keyName;

    }
    try {
    // Uploaded:
        $s3->deleteObject([
            'Bucket' => $bucketName,
            'Key'    => $keyName
        ]);
    } catch (S3Exception $e) {
        die('Error:' . $e->getMessage());
    } catch (Exception $e) {
        die('Error:' . $e->getMessage());
    }
    echo  'Diwo';
?>

