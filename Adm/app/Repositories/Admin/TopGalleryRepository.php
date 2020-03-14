<?php


	namespace App\Repositories\Admin;

	use App\Repositories\CoreRepository;
	use App\Models\Admin\TopGallery as Model;
	use App\Models\Admin\TopGallery;
	use Illuminate\Support\Facades\DB;
	use Symfony\Component\HttpFoundation\Session;
	/**
	 * 
	 */
	class TopGalleryRepository extends CoreRepository
	{
		public function __construct()
		{
			parent::__construct();
		}

		protected function getModelClass()
		{
			return Model::class;
		}
		/*Get Last TopGallery*/
		public function getLastTopgalleries($perpage)
		{
			$get = $this->startConditions()
				->orderBy('id','desc')
				->limit($perpage)
				->paginate($perpage);
			return $get;
		}
		/*Get All TopGallery*/
		public function getAllTopgalleries($perpage)
		{
			$get_all = $this->startConditions()
				->orderBy(\DB::raw('LENGTH(top_galleries.title)','top_galleries.title'))
				->limit($perpage)
				->paginate($perpage);
			return $get_all;
		}
		/*Get TopGallery Count*/
		public function getCountTopGalleries()
		{
			$count = $this->startConditions()
				->count();
			return $count;
		}
		/*Get TopGallery*/
		public function getTopgalleries($q){
			$topgallery = \DB::table('top_galleries')
				->select('id', 'title')
				->where('title','LIKE', ["%{$q}%"])
				->limit(8)
				->get();
			return $topgallery;
		}

		/*Upload Single Image Ajax*/
		public function uploadImg($name, $wmax, $hmax){
			$uploaddir = 'uploads/single/';
			$ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $name));
			$uploadfile = $uploaddir . $name;
			\Session::put('single', $name);
			self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
		}

		/**Get Image for new TopGallery*/
		public function getImg(TopGallery $topgallery){
			clearstatcache();
			if (!empty(\Session::get('single'))){
				$name = \Session::get('single');
				$topgallery->img = $name;
				\Session::forget('single');
				return;
			}
			if (empty(\Session::get('single')) && !is_file(WWW.'/uploads/single/' . $topgallery->img)){
				$topgallery->img = null;
			}
			return;
		}

		/**Get All info about one TopGallery*/
		public function getInfoTopGallery($id){
			$topgallery = $this->startConditions()
				->find($id);
			return $topgallery;
		}

		/* Turn Status = 1*/
		public function returnStatus($id){
			if (isset($id)){
				$st = \DB::update("UPDATE top_galleries SET status = '1' WHERE id = ?", [$id]);
				if ($st){
					return true;
				} else {
					return false;
				}
			}
		}

		/** Turn Status = 0*/
		public function deleteStatus($id){
			if (isset($id)){
				$st = \DB::update("UPDATE top_galleries SET status = '0' WHERE id = ?", [$id]);
				if ($st){
					return true;
				} else {
					return false;
				}
			}
		}

		/** Delete from DB*/
		public function deleteFromDB($id){
			if (isset($id)){
				$gallery = \DB::delete('DELETE FROM top_galleries WHERE id = ?', [$id]);

				if ($gallery) {
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