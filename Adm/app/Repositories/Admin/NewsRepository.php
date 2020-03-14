<?php

 
	namespace App\Repositories\Admin;

	use App\Repositories\CoreRepository;
	use App\Models\Admin\News as Model;
	use App\Models\Admin\News;
	use Illuminate\Support\Facades\DB;
	use Symfony\Component\HttpFoundation\Session;
	/**
	 * 
	 */
	class NewsRepository extends CoreRepository
	{
		public function __construct()
		{
			parent::__construct();
		}

		protected function getModelClass()
		{
			return Model::class;
		}
		/*Get Last News*/
		public function getLastNews($perpage)
		{
			$get = $this->startConditions()
				->orderBy('id','desc')
				->limit($perpage)
				->paginate($perpage);
			return $get;
		}
		/*Get All News*/
		public function getAllNews($perpage)
		{
			$get_all = $this->startConditions()
				->orderBy(\DB::raw('LENGTH(news.title)'))
				->limit($perpage)
				->paginate($perpage);
			return $get_all;
		}
		/*Get News Count*/
		public function getCountNews()
		{
			$count = $this->startConditions()
				->count();
			return $count;
		}
		/*Get News*/
		public function getNews($q){
			$news = \DB::table('news')
				->select('id', 'title')
				->where('title','LIKE', ["%{$q}%"])
				->limit(8)
				->get();
			return $news;
		}
		/*Upload Single Image Ajax*/
		public function uploadImg($name, $wmax, $hmax){
			$uploaddir = 'uploads/single/';
			$ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $name));
			$uploadfile = $uploaddir . $name;
			\Session::put('single', $name);
			self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
		}
		/*Upload Gallery Ajax*/
		public function uploadGallery($name, $wmax, $hmax){
			$uploaddir = 'uploads/gallery/';
			$ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$name]['name']));
			$new_name = md5(time()).".$ext";
			$uploadfile = $uploaddir . $new_name;
			\Session::push('gallery', $new_name);
			if (@move_uploaded_file($_FILES[$name]['tmp_name'],$uploadfile)){
				self::resize ($uploadfile, $uploadfile, $wmax, $hmax, $ext);
				$res = array("file_news" => $new_name);
				echo json_encode($res);
			}
		}

		/**Get Image for new News*/
		public function getImg(News $news){
			clearstatcache();
			if (!empty(\Session::get('single'))){
				$name = \Session::get('single');
				$news->img = $name;
				\Session::forget('single');
				return;
			}
			if (empty(\Session::get('single')) && !is_file(WWW.'/uploads/single/'.$news->img)){
				$news->img = null;
			}
			return;
		}
		/**Save Gallery*/
		public function saveGallery($id){
			if (!empty(\Session::get('gallery'))){
				$sql_part = '';
				foreach (\Session::get('gallery') as $v) {
					$sql_part .="('$v', $id),";
				}
				$sql_part = rtrim($sql_part, ',');
				\DB::insert("insert into news_galleries (img, news_id) VALUES $sql_part");
				\Session::forget('gallery');
			}
		}

		/**Get All info about one News*/
		public function getInfoNews($id){
			$news = $this->startConditions()
				->find($id);
			return $news;
		}

		/**Get Gallery for One News*/
		public function getGallery($id){
			$gallery = \DB::table('news_galleries')
				->where('news_id', $id)
				->pluck('img')
				->all();
			return $gallery;
		}

		/* Turn Status = 1*/
		public function returnStatus($id){
			if (isset($id)){
				$st = \DB::update("UPDATE news SET status = '1' WHERE id = ?", [$id]);
				if ($st){
					return true;
				} else {
					return false;
				}
			}
		}

		/** Turn Status = 0*/
		public function deleteStatusOne($id){
			if (isset($id)){
				$st = \DB::update("UPDATE news SET status = '0' WHERE id = ?", [$id]);
				if ($st){
					return true;
				} else {
					return false;
				}
			}
		}

		/**Delete Gallery after del one news*/
		public function deleteImgGalleryFromPath($id){
			$galleryImg = \DB::table('news_galleries')
				->select('img')
				->where('news_id', $id)
				->pluck('img')
				->all();
			$singleImg = \DB::table('news')
				->select('img')
				->where('id', $id)
				->pluck('img')
				->all();

			if (!empty($galleryImg)){
				foreach ($galleryImg as $img) {
					@unlink("uploads/gallery/$img");
				}
			}

			if (!empty($singleImg)){
				@unlink("uploads/single/" . $singleImg[0]);
			}
		}

		/** Delete from DB*/
		public function deleteFromDB($id){
			if (isset($id)){
				$gallery = \DB::delete('DELETE FROM news_galleries WHERE news_id = ?', [$id]);
				$news = \DB::delete('DELETE FROM news WHERE id = ?', [$id]);

				if ($news) {
					return true;
				}
			}
		}
		/**Resize Images for My need*/
		public static function resize($target, $dest, $wmax, $hmax, $ext)
		{
			list($w_orig, $h_orig) = getimagesize($target);
			$ratio = $w_orig / $h_orig;

			if (($wmax / $hmax) > $ratio) {
				$wmax = $hmax * $ratio;
			} else {
				$hmax = $wmax / $ratio;
			}

			$img = "";
			//imagecreatejpeg | imagecreateformgif | imagecreatefrompng
			switch ($ext)  {
				case ("gif"):
					$img = imagecreatefromgif($target);
					break;
				case("png");
					$img = imagecreatefrompng($target);
					break;
				default:
					$img = imagecreatefromjpeg($target);
			}
			$newImg = imagecreatetruecolor($wmax, $hmax);
			if ($ext == "png") {
				imagesavealpha($newImg, true);
				$transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
				imagefill($newImg, 0, 0, $transPng);
			}
			imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); // копируем и ресайзим изображение
			switch ($ext) {
				case ("gif"):
					imagegif($newImg, $dest);
					break;
				case("png"):
					imagepng($newImg, $dest);
					break;
				default:
					imagejpeg($newImg, $dest);
			}
			imagedestroy($newImg);
		}
	}