<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\Admin\StaticPageRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminStaticPageCreateRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\StaticPage;
use MetaTag;
use App\SBlog\Core\BlogApp;

class StaticPageController extends AdminBaseController
{
    private $staticpageRepository;

    public function __construct()
    {
        parent::__construct();
        $this->staticpageRepository = app(StaticPageRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $getAllStaticPages = $this->staticpageRepository->getAllStaticPages($perpage);
        $count = $this->staticpageRepository->getCountStaticPages();

        MetaTag::setTags(['title' => 'Список страниц']);
        return view('blog.admin.staticpage.index', compact('getAllStaticPages', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new StaticPage();
        MetaTag::setTags(['title' => "Создание новой страницы"]);
        return view('blog.admin.staticpage.create', [
            'item' => $item,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AdminStaticPageCreateRequest $request)
    {
        $data = $request->input();
        $static_page = (new StaticPage())->create($data);
        $id = $static_page->id;
        $static_page->status = $request->status ? '1' : '0';
        $this->staticpageRepository->getImg($static_page);
        $save = $static_page->save();
        if ($save) {
          $this->staticpageRepository->saveGallery($id);
          return redirect()
            ->route('blog.admin.staticpages.create', [$static_page->id])
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
        $staticpage = $this->staticpageRepository->getInfoStaticPage($id);
        $id = $staticpage->id;
        $images = $this->staticpageRepository->getGallery($id);
        MetaTag::setTags(['title' => "Редактирование страницы № $id"]);
        return view('blog.admin.staticpage.edit', compact('staticpage', 'id', 'images'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminStaticPageCreateRequest $request, $id)
    {
        $static_page = $this->staticpageRepository->getId($id);
        if (empty($static_page)) {
            return back()
                ->withErrors(['msg' => "Запись = [{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
        $result = $static_page->update($data);
        $static_page->status = $request->status ? '1' : '0';
        $this->staticpageRepository->getImg($static_page);
        $save = $static_page->save();
        if ($result && $save){
            $this->staticpageRepository->saveGallery($id);
            return redirect()
                ->route('blog.admin.staticpages.edit', [$static_page->id])
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
            return view('blog.admin.staticpage.include.image_single_edit');
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
            $this->staticpageRepository->uploadImg($filename, $wmax, $hmax);
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
                $this->staticpageRepository->uploadGallery($name, $wmax,$hmax);
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
        if (\DB::delete("DELETE FROM staticpage_galleries WHERE staticpage_id = ? AND img = ?", [$id, $src])){
            @unlink("uploads/gallery/$src");
            exit('1');
        }
        return;
    }

    /**Return staticpage status status = 1*/
    public function returnStatus($id){
        if ($id) {
            $st = $this->staticpageRepository->returnStatus($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.staticpages.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Return staticpage status = 0 */
    public function deleteStatus($id){
        if ($id) {
            $st = $this->staticpageRepository->deleteStatusOne($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.staticpages.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Delete One staticpage from DB*/
    public function deleteStaticPage($id){
         if ($id){
            $gal = $this->staticpageRepository->deleteImgGalleryFromPath($id);
            $db = $this->staticpageRepository->deleteFromDB($id);

            if ($db) {
                return redirect()
                    ->route('blog.admin.staticpages.index')
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
