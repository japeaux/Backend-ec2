<?php
	$bucket="diwoappprofilepics";
	require_once('S3.php');
	//AWS access info
	$awsAccessKey = 'AKIAT6O3EL7VAEEQYQJ3';
	$awsSecretKey = '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';
	//instantiate the class
	$s3 = new S3($awsAccessKey, $awsSecretKey);
	$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);
?>
