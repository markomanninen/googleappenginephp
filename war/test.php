<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$is_google_app_engine = TRUE;

/*
Title

http://www.article-spin-service.com/premuim-article-write-and-spin-service/

http://www.blackhatworld.com/blackhat-seo/associated-content-writing-articles/362282-advanced-spinning-sites.html

http://www.articull.com mmstud@gmail.com:78VHcHkVuL

https://www.odesk.com/ to hire workers

http://www.articlemanager.us/
- paragraph counter
- 
- 

ZIP files

$zip = new ZipArchive;
$zip->addFromString('test.txt', 'file content goes here');
$zip->file();

# OR
#$zip->close();
# repeat for each file then put headers like:
#header('Content-Type: application/zip');
#header('Content-Length: '.filesize($file)); #content length
#header('Content-Disposition: attachment; filename="'.$slug.'.zip"');

*/

function multipart_attachments($attachments, &$body, &$headers, $html = '') {
	$random_hash = md5(date('r', time()));
	$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
	
	if ($html) {
		$html = "
 
--PHP-alt-$random_hash
Content-Type: text/html; charset='iso-8859-1'
Content-Transfer-Encoding: 7bit
 
$html
 
--PHP-alt-$random_hash--";
	}
	
	$body = "
--PHP-mixed-$random_hash;
Content-Type: multipart/alternative; boundary='PHP-alt-$random_hash'
--PHP-alt-$random_hash
Content-Type: text/plain; charset='iso-8859-1'
Content-Transfer-Encoding: 7bit
 
$body".$html;
	# attachments needs to be base64 encoded
	foreach ($attachments as $filename => $attachment) {
		# TODO: detect correct mime type
		$mime_type = 'application/zip';
		$body .= "

--PHP-mixed-$random_hash
Content-Type: $mime_type; name=$filename
Content-Transfer-Encoding: base64
Content-Disposition: attachment
 
".chunk_split($attachment)."
--PHP-mixed-$random_hash--";
	}
}

/*
public static byte[] zipBytes(String filename, byte[] input) throws IOException {
        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        ZipOutputStream zos = new ZipOutputStream(baos);
        ZipEntry entry = new ZipEntry(filename);
        entry.setSize(input.length);
        zos.putNextEntry(entry);
        zos.write(input);
        zos.closeEntry();
        zos.close();
        return baos.toByteArray();
}
*/

function get_zip_file_from_contents($contents, $dummy_zip_file = 'tmpz.zip') {
	global $is_google_app_engine;
	if ($is_google_app_engine) {
		$baos = new Java('java.io.ByteArrayOutputStream');
		$zos = new Java('java.util.zip.ZipOutputStream', $baos);
		foreach ($contents as $file => $content) {
			$entry = new Java('java.util.zip.ZipEntry', $file);
	        $entry->setSize(strlen($content));
	        $zos->putNextEntry($entry);
		    $zos->write($content);
	        $zos->closeEntry();
		}	
	    $zos->close();
		return $baos->toByteArray(); 
	} else {
		$zip = new ZipArchive;
		if ($zip->open($dummy_zip_file, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE)) {
			foreach ($contents as $file => $content) {
				$zip->addFromString($file, $content);
			}
		}
		$zip->close();
		return file_get_contents($dummy_zip_file);
	}
}

$zip_file = 'tmpz.zip';
$contents = array('test1.txt' => 'file content goes here 1', 'test2.txt' => 'file content goes here 2');
$zip_content = get_zip_file_from_contents($contents, $zip_file);
$zip_base64_content = base64_encode($zip_content);

$attachments['geekology1.zip'] = $zip_base64_content;
$attachments['geekology2.zip'] = $zip_base64_content;

$to = "mmstud@gmail.com";
$subject = "A test email with attachment";
$body = "Hello World!\r\nThis is the simple text version of the email message.";
$html = '<h2>Hello World!</h2>
<p>This is the <b>HTML</b> version of the email message.</p>';

$headers = "From: $to\r\nReply-To: $to";
multipart_attachments($attachments, $body, $headers, $html);

if (FALSE) {
	header('Content-Type: application/zip');
	header('Content-Length: '.strlen($zip_content));
	header('Content-Disposition: attachment; filename="'.$zip_file.'"');
	echo $zip_content;
	exit;
}

#echo "$to, $subject, $body, $headers";
echo 'sending mail: '.mail($to, $subject, $body, $headers);

?>