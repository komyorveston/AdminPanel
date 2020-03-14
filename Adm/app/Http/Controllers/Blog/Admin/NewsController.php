<?php
 

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\Admin\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminNewsCreateRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\News;
use MetaTag;
use App\SBlog\Core\BlogApp;

class NewsController extends AdminBaseController
{
    private $newsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->newsRepository = app(NewsRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $getAllNews = $this->newsRepository->getAllNews($perpage);
        $count = $this->newsRepository->getCountNews();

        MetaTag::setTags(['title' => 'Список новостей']);
        return view('blog.admin.news.index', compact('getAllNews', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new News();

        MetaTag::setTags(['title' => "Создание новости"]);
        return view('blog.admin.news.create', [
            'item' => $item,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AdminNewsCreateRequest $request)
    {
        $data = $request->input();
        $news = (new News())->create($data);
        $id = $news->id;
        $news->status = $request->status ? '1' : '0';
        $this->newsRepository->getImg($news);
        $save = $news->save();
        if ($save) {
          $this->newsRepository->saveGallery($id);
          return redirect()
            ->route('blog.admin.news.create', [$news->id])
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
        $news = $this->newsRepository->getInfoNews($id);
        $id = $news->id;
        $images = $this->newsRepository->getGallery($id);
        MetaTag::setTags(['title' => "Редактирование новости № $id"]);
        return view('blog.admin.news.edit', compact('news', 'id', 'images'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminNewsCreateRequest $request, $id)
    {
        $news = $this->newsRepository->getId($id);
        if (empty($news)) {
            return back()
                ->withErrors(['msg' => "Запись = [{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
        $result = $news->update($data);
        $news->status = $request->status ? '1' : '0';
        $this->newsRepository->getImg($news);
        $save = $news->save();
        if ($result && $save){
            $this->newsRepository->saveGallery($id);
            return redirect()
                ->route('blog.admin.news.edit', [$news->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /*Single Image AjaxUpload  */
    public function ajaxImage(Request $request){
        if ($request->isMethod('get')){
            return view('blog.admin.news.include.image_single_edit');
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
            $this->newsRepository->uploadImg($filename, $wmax, $hmax);
            return $filename;
        }
    }

      /*AjaxUpload Gallery*/
    public function gallery(Request $request){
        $validator = \Validator::make($request->all(),
                [
                    'file_news' => 'image|max:5000',
                ],
                [
                    'file_news.image' => 'Файл должен быть картинкой (jpeg, png, gif, or svg)',
                    'file_news.max' => 'Ошибка! Максимальный размер картинки -5 мб',
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
                $this->newsRepository->uploadGallery($name, $wmax,$hmax);
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
        if (\DB::delete("DELETE FROM news_galleries WHERE news_id = ? AND img = ?", [$id, $src])){
            @unlink("uploads/gallery/$src");
            exit('1');
        }
        return;
    }

    /**Return news status status = 1*/
    public function returnStatus($id){
        if ($id) {
            $st = $this->newsRepository->returnStatus($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.news.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Return news status = 0 */
    public function deleteStatus($id){
        if ($id) {
            $st = $this->newsRepository->deleteStatusOne($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.news.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Delete One News fro DB*/
    public function deleteNews($id){
         if ($id){
            $gal = $this->newsRepository->deleteImgGalleryFromPath($id);
            $db = $this->newsRepository->deleteFromDB($id);
            if ($db) {
                return redirect()
                    ->route('blog.admin.news.index')
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
