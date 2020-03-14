<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\Admin\ServiceRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminServiceRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Service;
use MetaTag;
use App\SBlog\Core\BlogApp;

class ServiceController extends AdminBaseController
{
    private $serviceRepository;

    public function __construct()
    {
        parent::__construct();
        $this->serviceRepository = app(ServiceRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $getAllServices = $this->serviceRepository->getAllServices($perpage);
        $count = $this->serviceRepository->getCountServices();

        MetaTag::setTags(['title' => 'Список продуктов']);
        return view('blog.admin.service.index', compact('getAllServices', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Service();
        MetaTag::setTags(['title' => "Создание нового сервиса"]);
        return view('blog.admin.service.create', [
            'item' => $item,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AdminServiceRequest $request)
    {
        $data = $request->input();
        $service = (new Service())->create($data);
        $id = $service->id;
        $service->status = $request->status ? '1' : '0';
        $this->serviceRepository->getImg($service);
        $save = $service->save();
        if ($save) {
          $this->serviceRepository->saveGallery($id);
          return redirect()
            ->route('blog.admin.services.create', [$service->id])
            ->with(['success' => 'Успешно сохранено']);
        } else {
          return back()
            ->withErrors(['msg' => 'Ошибка сохранения'])
            ->withInput();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->serviceRepository->getInfoService($id);
        $id = $service->id;
        $images = $this->serviceRepository->getGallery($id);

        MetaTag::setTags(['title' => "Редактирование сервиса № $id"]);
        return view('blog.admin.service.edit', compact('service', 'id', 'images'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminServiceRequest $request, $id)
    {
        $service = $this->serviceRepository->getId($id);
        if (empty($service)) {
            return back()
                ->withErrors(['msg' => "Запись = [{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
        $result = $service->update($data);
        $service->status = $request->status ? '1' : '0';
        $this->serviceRepository->getImg($service);
        $save = $service->save();

        if ($result && $save){
            $this->serviceRepository->saveGallery($id);
            return redirect()
                ->route('blog.admin.services.edit', [$service->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /*Single Image AjaxUpload*/
    public function ajaxImage(Request $request){
        if ($request->isMethod('get')){
            return view('blog.admin.service.include.image_single_edit');
        } else {
            $validator = \Validator::make($request->all(),
                [
                    'file' => 'image|max:5000',
                ],
                [
                    'file.image' => 'Файл должен быть картинкой (jpeg, png, gif, or svg)',
                    'file.max' => 'Ошибка! Максимальный размер картинки -5 мб',
                ]);
            if ($validator->fails()){
                return array (
                    'fail' => true,
                    'errors' => $validator->errors()
                );
            }

            $extension = $request->file('file')->getClientOriginalExtension();
            $dir = 'uploads/single/';
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('file')->move($dir, $filename);
            $wmax = BlogApp::get_instance()->getProperty('img_width');
            $hmax = BlogApp::get_instance()->getProperty('img_height');
            $this->serviceRepository->uploadImg($filename, $wmax, $hmax);
            return $filename;
        }
    }

      /*AjaxUpload Gallery*/
    public function gallery(Request $request){
        $validator = \Validator::make($request->all(),
                [
                    'file' => 'image|max:5000',
                ],
                [
                    'file.image' => 'Файл должен быть картинкой (jpeg, png, gif, or svg)',
                    'file.max' => 'Ошибка! Максимальный размер картинки -5 мб',
                ]
            );
            if ($validator->fails()){
                return array (
                    'fail' => true,
                    'errors' => $validator->errors()
                );
            }

            if (isset($_GET['upload'])){
                $wmax = BlogApp::get_instance()->getProperty('gallery_width');
                $hmax = BlogApp::get_instance()->getProperty('gallery_height');
                $name = $_POST['name'];
                $this->serviceRepository->uploadGallery($name, $wmax,$hmax);
            }
    }


    /*Delete Single Image*/
    public function deleteImage($filename){
        \File::delete('uploads/single/' . $filename);
    }

    /*Delete Gallery Image*/
    public function deletegallery(){
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $src = isset($_POST['src']) ? $_POST['src'] : null;
        if (!$id || !$src) {
            return;
        }
        if (\DB::delete("DELETE FROM service_galleries WHERE service_id = ? AND img = ?", [$id, $src])){
            @unlink("uploads/gallery/$src");
            exit('1');
        }
        return;
    }

    /**Return service status status = 1*/
    public function returnStatus($id){
        if ($id) {
            $st = $this->serviceRepository->returnStatus($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.services.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Return service status = 0 */
    public function deleteStatus($id){
        if ($id) {
            $st = $this->serviceRepository->deleteStatusOne($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.services.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Delete One Service from DB*/
    public function deleteService($id){
         if ($id){
            $gal = $this->serviceRepository->deleteImgGalleryFromPath($id);
            $db = $this->serviceRepository->deleteFromDB($id);

            if ($db) {
                return redirect()
                    ->route('blog.admin.services.index')
                    ->with(['success' => 'Успешно удалено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка удаления'])
                    ->withInput();
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    }
}
