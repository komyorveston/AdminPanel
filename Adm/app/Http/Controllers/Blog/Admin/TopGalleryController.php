<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\Admin\TopGalleryRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminTopGalleryAddRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\TopGallery;
use MetaTag;
use App\SBlog\Core\BlogApp;

class TopGalleryController extends AdminBaseController
{
    private $topgalleryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->topgalleryRepository = app(TopGalleryRepository::class);
    }
    /**
     * Display a listing of the resource.
     **
     **@return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $getAllTopgalleries = $this->topgalleryRepository->getAllTopgalleries($perpage);
        $count = $this->topgalleryRepository->getCountTopgalleries();
        MetaTag::setTags(['title' => 'Список продуктов']);
        return view('blog.admin.topgallery.index', compact('getAllTopgalleries', 'count'));
    }

    /**
     ** Show the form for creating a new resource.
     **
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new TopGallery();
        MetaTag::setTags(['title' => "Создание новой галереи"]);
        return view('blog.admin.topgallery.create', [
            'item' => $item,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AdminTopGalleryAddRequest $request)
    {
        $data = $request->input();
        $topgallery = (new TopGallery())->create($data);
        $id = $topgallery->id;
        $topgallery->status = $request->status ? '1' : '0';
        $this->topgalleryRepository->getImg($topgallery);
        $save = $topgallery->save();
        if ($save) {
          return redirect()
            ->route('blog.admin.topgalleries.create', [$topgallery->id])
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
        $topgallery = $this->topgalleryRepository->getInfoTopgallery($id);
        $id = $topgallery->id;
        MetaTag::setTags(['title' => "Редактирование Галлереи № $id"]);
        return view('blog.admin.topgallery.edit', compact('topgallery', 'id'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminTopGalleryAddRequest $request, $id)
    {
        $topgallery = $this->topgalleryRepository->getId($id);
        if (empty($topgallery)) {
            return back()
                ->withErrors(['msg' => "Запись = [{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
        $result = $topgallery->update($data);
        $topgallery->status = $request->status ? '1' : '0';
        $this->topgalleryRepository->getImg($topgallery);
        $save = $topgallery->save();
        if ($result && $save){
            return redirect()
                ->route('blog.admin.topgalleries.edit', [$topgallery->id])
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
            return view('blog.admin.topgallery.include.image_single_edit');
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
            $this->topgalleryRepository->uploadImg($filename, $wmax, $hmax);
            return $filename;
        }
    }

    /*Delete Single Image*/
    public function deleteImage($filename){
        \File::delete('uploads/single/' . $filename);
    }

    /**Return topgallery status status = 1*/
    public function returnStatus($id){
        if ($id) {
            $st = $this->topgalleryRepository->returnStatus($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.topgalleries.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Return topgallery status = 0 */
    public function deleteStatus($id){
        if ($id) {
            $st = $this->topgalleryRepository->deleteStatus($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.topgalleries.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Delete One Topgallery from DB*/
    public function deleteTopGallery($id){
         if ($id){
            $db = $this->topgalleryRepository->deleteFromDB($id);

            if ($db) {
                return redirect()
                    ->route('blog.admin.topgalleries.index')
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
