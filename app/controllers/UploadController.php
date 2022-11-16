<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 23/09/2018
 * Time: 22:59
 */

class UploadController extends Controller {
	protected $msgicon="error";
	protected $uploadResult="Upload failed! (unknown reason)";


	public function __construct() {
		parent::__construct();
	}

	function beforeroute() {

	}

	function imageUpload($file,$maxsize) {
		$tempFile=$file['tmp_name'];
		$dir='uploads/'.$_SESSION['user'][2].'/';
		$filename=basename($file["name"]);
		$targetFile=$dir.$filename;
		$uploadOk=1;
		$imageFileType=strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

		if (!file_exists($dir)) {
			mkdir($dir,0777,TRUE);
		}

		if ($file) {
			// Check if image file is a actual image or fake image
			if (!empty($tempFile)) {
				$check=getimagesize($tempFile);
				if ($check!==FALSE) {
					$this->msgicon='success';
					$this->uploadResult="File is an image - ".$check["mime"].".";
					$uploadOk=1;
				} else {
					$this->msgicon='error';
					$this->uploadResult='File is not an image.';
					$uploadOk=0;
				}

				// Check if file already exists
				if (file_exists($targetFile)) {
					unlink($targetFile);
					$uploadOk=1;
				}

				// Check file size
				if ($file["size"]>$maxsize) {
					$this->msgicon='error';
					$this->uploadResult='Sorry, your file is too large.';
					$uploadOk=0;
				}

				// Allow certain file formats
				if ($imageFileType!="jpg" && $imageFileType!="png" &&
					$imageFileType!="jpeg"
					&& $imageFileType!="gif") {
					$this->msgicon='error';
					$this->uploadResult=
						'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
					$uploadOk=0;
				}

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk==1) {
					if (move_uploaded_file($tempFile,$targetFile)) {
						$this->msgicon='success';
						$this->uploadResult=
							"The file ".htmlspecialchars($filename)." has been uploaded.";
					} else {
						$this->msgicon='error';
						$this->uploadResult=
							'Sorry, there was an error uploading your file.';
					}
				} else {
					$this->msgicon='error';
				}
				$this->f3->set('SESSION.'.$this->msgicon,$this->uploadResult);
			}
		}
	}
}
