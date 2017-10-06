<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class TagController extends Controller{

	public static function writeTags($file, $data){
		$TextEncoding = 'UTF-8';
		$getID3       = new \getID3;
		$getID3->setOption(array('encoding' => $TextEncoding));
		$tagwriter             = new \getid3_writetags();
		$TagData               = array(
			'title'     => array($file->title),
			'year'      => array(date('Y')),
			'artist'    => array($data['artist']),
			'album'     => array($data['album']),
			'genre'     => array($data['genre']),
			'publisher' => array($data['publisher']),
			'comment'   => array($data['comment']),
			'composer'  => array($data['composer']),

			/*'track'                  => array('04/16'),
			'popularimeter'          => array('email' => 'user@example.net', 'rating' => 128, 'data' => 0),
			'unique_file_identifier' => array('ownerid' => 'user@example.net', 'data' => md5(time())),*/
		);
		$tagwriter->filename   = Storage::disk('upload')->path($file->path);
		$tagwriter->tagformats = array('id3v2.3');

		$tagwriter->overwrite_tags    = true;
		$tagwriter->remove_other_tags = false;
		$tagwriter->tag_encoding      = $TextEncoding;
		$tagwriter->remove_other_tags = true;

		$thumb                                           = $file->thumb;
		$TagData['attached_picture'][0]['data']          = file_get_contents(Storage::disk('public')->path($thumb->path));
		$TagData['attached_picture'][0]['picturetypeid'] = 3;
		$TagData['attached_picture'][0]['description']   = 'Picture';
		$TagData['attached_picture'][0]['mime']          = 'image/png';//Storage::disk('public')->mimeType($thumb->path);

		$tagwriter->tag_data = $TagData;
		$tagwriter->WriteTags();
	}
}
