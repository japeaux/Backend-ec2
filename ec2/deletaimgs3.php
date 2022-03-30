<?php

require 'vendor/autoload.php';

	use Aws\S3\S3Client;
 	use Aws\S3\Exception\S3Exception;

 	$bucketName = 'diwoapppics';
    $IAM_KEY = 'AKIARKMVBDBD25H2G4WN';
    $IAM_SECRET = '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';
   echo 'OIII'
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
         $s3->deleteObject([
		    'Bucket' => $bucketName,
		    'Key'    => 'profilepicsbairro/floresgmailcom.jpg'
		]);
         echo 'OIII'
    } catch (Exception $e) {
        // We use a die, so if this fails. It stops here. Typically this is a REST call so this would
        // return a json object.
        die("Error: " . $e->getMessage());
    }

       
    

// Delete an object from the bucket.


?>
