<?php


namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\Admin\VacancyRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminVacancyCreateRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Vacancy;
use App\Models\Admin\Category;
use MetaTag;
use App\SBlog\Core\BlogApp;

class VacancyController extends AdminBaseController
{
    private $vacancyRepository;

    public function __construct()
    {
        parent::__construct();
        $this->vacancyRepository = app(VacancyRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $getAllVacancies = $this->vacancyRepository->getAllVacancies($perpage);
        $count = $this->vacancyRepository->getCountVacancies();

        MetaTag::setTags(['title' => 'Список вакансий']);
        return view('blog.admin.vacancy.index', compact('getAllVacancies', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Vacancy();
        MetaTag::setTags(['title' => "Создание новой вакансии"]);
        return view('blog.admin.vacancy.create', [
            'item' => $item,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AdminVacancyCreateRequest $request)
    {
        $data = $request->input();
        $vacancy = (new Vacancy())->create($data);
        $id = $vacancy->id;
        $vacancy->status = $request->status ? '1' : '0';
        $this->vacancyRepository->getImg($vacancy);
        $save = $vacancy->save();
        if ($save) {
          return redirect()
            ->route('blog.admin.vacancies.create', [$vacancy->id])
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
        $vacancy = $this->vacancyRepository->getInfoVacancy($id);
        $id = $vacancy->id;

        MetaTag::setTags(['title' => "Редактирование вакансии № $id"]);
        return view('blog.admin.vacancy.edit', compact('vacancy', 'id', ));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminVacancyCreateRequest $request, $id)
    {
        $vacancy = $this->vacancyRepository->getId($id);
        if (empty($vacancy)) {
            return back()
                ->withErrors(['msg' => "Запись = [{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
        $result = $vacancy->update($data);
        $vacancy->status = $request->status ? '1' : '0';
        $this->vacancyRepository->getImg($vacancy);
        $save = $vacancy->save();
        if ($result && $save){
            return redirect()
                ->route('blog.admin.vacancies.edit', [$vacancy->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /*Single Image AjaxUpload */
    public function ajaxImage(Request $request){
        if ($request->isMethod('get')){
            return view('blog.admin.vacancy.include.image_single_edit');
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
            $this->vacancyRepository->uploadImg($filename, $wmax, $hmax);
            return $filename;
        }
    }

    /*Delete Single Image*/
    public function deleteImage($filename){
        \File::delete('uploads/single/' . $filename);
    }

    /**Return vacancy status status = 1*/
    public function returnStatus($id){
        if ($id) {
            $st = $this->vacancyRepository->returnStatus($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.vacancies.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Return vacancy status = 0 */
    public function deleteStatus($id){
        if ($id) {
            $st = $this->vacancyRepository->deleteStatusOne($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.vacancies.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Delete One Vacancy from DB*/
    public function deleteVacancy($id){
         if ($id){
            $db = $this->vacancyRepository->deleteFromDB($id);

            if ($db) {
                return redirect()
                    ->route('blog.admin.vacancies.index')
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
