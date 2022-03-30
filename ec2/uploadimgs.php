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
    $keyName = 'teste/' . basename($_FILES["fileToUpload"]['name']);
    //$pathInS3 = 'https://s3.sa-east-1.amazonaws.com/' . $bucketName . '/' . $keyName;
    $pathInS3 = 'https://diwoapppics.s3-sa-east-1.amazonaws.com/'  . $keyName;
    
    // Add it to S3
    //echo $keyName;
        
    try {
    // Uploaded:
        $total_files = count($_FILES['fileToUpload']['tmp_name']);
         echo $total_files;
          for($key = 0; $key < $total_files; $key++) {
            
            // Check if file is selected
            if(isset($_FILES['fileToUpload']['name'][$key]) 
                              && $_FILES['fileToUpload']['size'][$key] > 0) {
              
              $original_filename = 'teste/' . basename($_FILES['fileToUpload']['name'][$key]);
                echo $original_filename;
              $target = $target_dir . basename($original_filename);
              //echo $target;
              $tmp  = $_FILES['fileToUpload']['tmp_name'][$key];
              
                    $s3->putObject(
                        array(
                            'Bucket'=>$bucketName,
                            'Key' =>  $original_filename,
                            'SourceFile' => $tmp,
                            'ContentType' =>'image/jpeg',
                        )
                );
            }
            
          }
       
    } catch (S3Exception $e) {
        die('Error:' . $e->getMessage());
    } catch (Exception $e) {
        die('Error:' . $e->getMessage());
    }
    //echo  'Diwo';
?>

