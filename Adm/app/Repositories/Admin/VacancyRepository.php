<?php


	namespace App\Repositories\Admin;

	use App\Repositories\CoreRepository;
	use App\Models\Admin\Vacancy as Model;
	use App\Models\Admin\Vacancy;
	use Illuminate\Support\Facades\DB;
	use Symfony\Component\HttpFoundation\Session;
	/**
	 * 
	 */
	class VacancyRepository extends CoreRepository
	{
		public function __construct()
		{
			parent::__construct();
		}

		protected function getModelClass()
		{
			return Model::class;
		}
		/*Get Last Vacancy*/
		public function getLastVacancies($perpage)
		{
			$get = $this->startConditions()
				->orderBy('id','desc')
				->limit($perpage)
				->paginate($perpage);
			return $get;
		}
		/*Get All Vacancy*/
		public function getAllVacancies($perpage)
		{
			$get_all = $this->startConditions()
				->orderBy(\DB::raw('LENGTH(vacancies.title)','vacancies.title'))
				->limit($perpage)
				->paginate($perpage);
			return $get_all;
		}
		/*Get Vacancy Count*/
		public function getCountVacancies()
		{
			$count = $this->startConditions()
				->count();
			return $count;
		}
		/*Get Vacancy*/
		public function getVacancies($q){
			$vacancies = \DB::table('vacancies')
				->select('id', 'title')
				->where('title','LIKE', ["%{$q}%"])
				->limit(8)
				->get();
			return $vacancies;
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
				$res = array("file" => $new_name);
				echo json_encode($res);
			}
		}

		/**Get Image for new Vacancy*/
		public function getImg(Vacancy $vacancy){
			clearstatcache();
			if (!empty(\Session::get('single'))){
				$name = \Session::get('single');
				$vacancy->img = $name;
				\Session::forget('single');
				return;
			}
			if (empty(\Session::get('single')) && !is_file(WWW.'/uploads/single/'.$vacancy->img)){
				$vacancy->img = null;
			}
			return;
		}
		
		/**Get All info about one Vacancy*/
		public function getInfoVacancy($id){
			$vacancy = $this->startConditions()
				->find($id);
			return $vacancy;
		}

		/* Turn Status = 1*/
		public function returnStatus($id){
			if (isset($id)){
				$st = \DB::update("UPDATE vacancies SET status = '1' WHERE id = ?", [$id]);
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
				$st = \DB::update("UPDATE vacancies SET status = '0' WHERE id = ?", [$id]);
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
				$vacancy = \DB::delete('DELETE FROM vacancies WHERE id = ?', [$id]);

				if ($vacancy) {
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