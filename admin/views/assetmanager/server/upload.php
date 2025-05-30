<?php
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
include_once(dirname(dirname(__FILE__)) . "/config.php");

$path_for_images = '';
require_once $_SESSION['WYSIWYGFileManagerRequirements'];

if (!empty($_FILES)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = WEBSITEROOT_LOCALPATH . $path_for_images . '/';

    $targetFile =  rtrim($targetPath, '/') . '/' . preg_replace('/\s+/', '-', $_FILES['Filedata']['name']);

    $allowedExt = UPLOAD_FILE_TYPES;

    $fileTypes = str_replace('*.', '', $allowedExt);
    $fileTypes  = str_replace(';', '|', $fileTypes);
    $typesArray = explode('|', $fileTypes);
    $fileParts  = pathinfo($_FILES['Filedata']['name']);

    if ($allowedExt == "" || in_array(strtolower($fileParts['extension']), $typesArray)) {
        // Uncomment the following line if you want to make the directory if it doesn't exist
        // mkdir(str_replace('//','/',$targetPath), 0755, true);

        move_uploaded_file($tempFile, $targetFile);
        echo str_replace(WEBSITEROOT_LOCALPATH, '', urlencode($targetFile));
        echo "<script>parent.refresh();</script>";
    } else {
        echo 'Invalid file type.';
    }
}
