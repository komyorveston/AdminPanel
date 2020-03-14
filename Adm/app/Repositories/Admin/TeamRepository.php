<?php


	namespace App\Repositories\Admin;

	use App\Repositories\CoreRepository;
	use App\Models\Admin\Team as Model;
	use App\Models\Admin\Team;
	use Illuminate\Support\Facades\DB;
	use Symfony\Component\HttpFoundation\Session;
	/**
	 * 
	 */
	class TeamRepository extends CoreRepository
	{
		public function __construct()
		{
			parent::__construct();
		}

		protected function getModelClass()
		{
			return Model::class;
		}
		/*Get Last Team*/
		public function getLastTeam($perpage)
		{
			$get = $this->startConditions()
				->orderBy('id','desc')
				->limit($perpage)
				->paginate($perpage);
			return $get;
		}
		/*Get All Team*/
		public function getAllTeams($perpage)
		{
			$get_all = $this->startConditions()
				->orderBy(\DB::raw('LENGTH(teams.name)','teams.name'))
				->limit($perpage)
				->paginate($perpage);
			return $get_all;
		}
		/*Get Team Count*/
		public function getCountTeams()
		{
			$count = $this->startConditions()
				->count();
			return $count;
		}
		/*Get Team*/
		public function getTeams($q){
			$teams = \DB::table('teams')
				->select('id', 'name')
				->where('name','LIKE', ["%{$q}%"])
				->limit(8)
				->get();
			return $teams;
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

		/**Get Image for new Team*/
		public function getImg(Team $team){
			clearstatcache();
			if (!empty(\Session::get('single'))){
				$name = \Session::get('single');
				$team->img = $name;
				\Session::forget('single');
				return;
			}
			if (empty(\Session::get('single')) && !is_file(WWW.'/uploads/single/'.$team->img)){
				$team->img = null;
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
				\DB::insert("insert into galleries (img, product_id) VALUES $sql_part");
				\Session::forget('gallery');
			}
		}

		/**Get All info about one Team*/
		public function getInfoTeam($id){
			$team = $this->startConditions()
				->find($id);
			return $team;
		}

		/**Get Gallery for One Team*/
		public function getGallery($id){
			$gallery = \DB::table('galleries')
				->where('product_id', $id)
				->pluck('img')
				->all();
			return $gallery;
		}

		/* Turn Status = 1*/
		public function returnStatus($id){
			if (isset($id)){
				$st = \DB::update("UPDATE teams SET status = '1' WHERE id = ?", [$id]);
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
				$st = \DB::update("UPDATE teams SET status = '0' WHERE id = ?", [$id]);
				if ($st){
					return true;
				} else {
					return false;
				}
			}
		}

		/**Delete Gallery after del one Team*/
		public function deleteImgGalleryFromPath($id){
			$galleryImg = \DB::table('galleries')
				->select('img')
				->where('product_id', $id)
				->pluck('img')
				->all();
			$singleImg = \DB::table('teams')
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
				$gallery = \DB::delete('DELETE FROM galleries WHERE product_id = ?', [$id]);
				$team = \DB::delete('DELETE FROM teams WHERE id = ?', [$id]);

				if ($team) {
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