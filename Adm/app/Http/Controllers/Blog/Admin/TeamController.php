<?php


namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\Admin\TeamRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminTeamCreateRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Team;
use MetaTag;
use App\SBlog\Core\BlogApp;

class TeamController extends AdminBaseController
{
    private $teamRepository;

    public function __construct()
    {
        parent::__construct();
        $this->teamRepository = app(TeamRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $getAllTeams = $this->teamRepository->getAllTeams($perpage);
        $count = $this->teamRepository->getCountTeams();
        MetaTag::setTags(['title' => 'Список сотрудников']);
        return view('blog.admin.team.index', compact('getAllTeams', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Team();
        MetaTag::setTags(['title' => "Создание нового сотрудника"]);
        return view('blog.admin.team.create', [
            'item' => $item,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AdminTeamCreateRequest $request)
    {
        $data = $request->input();
        $team = (new Team())->create($data);
        $id = $team->id;
        $team->status = $request->status ? '1' : '0';
        $this->teamRepository->getImg($team);
        $save = $team->save();
        if ($save) {
          return redirect()
            ->route('blog.admin.teams.create', [$team->id])
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
        $team = $this->teamRepository->getInfoTeam($id);
        $id = $team->id;
        MetaTag::setTags(['title' => "Редактирование сотрудника № $id"]);
        return view('blog.admin.team.edit', compact('team', 'id'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminTeamCreateRequest $request, $id)
    {
        $team = $this->teamRepository->getId($id);
        if (empty($team)) {
            return back()
                ->withErrors(['msg' => "Запись = [{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
        $result = $team->update($data);
        $team->status = $request->status ? '1' : '0';
        $this->teamRepository->getImg($team);
        $save = $team->save();
        if ($result && $save){
            return redirect()
                ->route('blog.admin.teams.edit', [$team->id])
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
            return view('blog.admin.team.include.image_single_edit');
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
            $this->teamRepository->uploadImg($filename, $wmax, $hmax);
            return $filename;
        }
    }

    /*Delete Single Image*/
    public function deleteImage($filename){
        \File::delete('uploads/single/' . $filename);
    }

    /**Return team status status = 1*/
    public function returnStatus($id){
        if ($id) {
            $st = $this->teamRepository->returnStatus($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.teams.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Return team status = 0 */
    public function deleteStatus($id){
        if ($id) {
            $st = $this->teamRepository->deleteStatusOne($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.teams.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Delete One Team from DB*/
    public function deleteTeam($id){
         if ($id){
            $db = $this->teamRepository->deleteFromDB($id);
            if ($db) {
                return redirect()
                    ->route('blog.admin.teams.index')
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
