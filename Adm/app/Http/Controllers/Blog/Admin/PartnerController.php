<?php


namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\Admin\PartnerRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminPartnersCreateRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Partner;
use App\Models\Admin\Category;
use MetaTag;
use App\SBlog\Core\BlogApp;

class PartnerController extends AdminBaseController
{
    private $partnerRepository;

    public function __construct()
    {
        parent::__construct();
        $this->partnerRepository = app(PartnerRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $getAllPartners = $this->partnerRepository->getAllPartners($perpage);
        $count = $this->partnerRepository->getCountPartners();

        MetaTag::setTags(['title' => 'Список партнеров']);
        return view('blog.admin.partner.index', compact('getAllPartners', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Partner();
        MetaTag::setTags(['title' => "Создание нового партнера"]);
        return view('blog.admin.partner.create', [
            'item' => $item,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AdminPartnersCreateRequest $request)
    {
        $data = $request->input();
        $partner = (new Partner())->create($data);
        $id = $partner->id;
        $partner->status = $request->status ? '1' : '0';
        $this->partnerRepository->getImg($partner);
        $save = $partner->save();
        if ($save) {
          return redirect()
            ->route('blog.admin.partners.create', [$partner->id])
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
        $partner = $this->partnerRepository->getInfoPartner($id);
        $id = $partner->id;

        MetaTag::setTags(['title' => "Редактирование партнёра № $id"]);
        return view('blog.admin.partner.edit', compact('partner', 'id'), [
            'item' => $partner,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPartnersCreateRequest $request, $id)
    {
        $partner = $this->partnerRepository->getId($id);
        if (empty($partner)) {
            return back()
                ->withErrors(['msg' => "Запись = [{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
        $result = $partner->update($data);
        $partner->status = $request->status ? '1' : '0';
        $this->partnerRepository->getImg($partner);
        $save = $partner->save();

        if ($result && $save){
            return redirect()
                ->route('blog.admin.partners.edit', [$partner->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /*Single Image AaxUpload */
    public function ajaxImage(Request $request){
        if ($request->isMethod('get')){
            return view('blog.admin.partner.include.image_single_edit');
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
            $this->partnerRepository->uploadImg($filename, $wmax, $hmax);
            return $filename;
        }
    }

    /*Delete Single Image*/
    public function deleteImage($filename){
        \File::delete('uploads/single/' . $filename);
    }

    /**Return partner status status = 1*/
    public function returnStatus($id){
        if ($id) {
            $st = $this->partnerRepository->returnStatus($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.partners.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Return partner status = 0 */
    public function deleteStatus($id){
        if ($id) {
            $st = $this->partnerRepository->deleteStatusOne($id);
            if ($st) {
                return redirect()
                    ->route('blog.admin.partners.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
            }
        }
    }

    /** Delete One partner from DB*/
    public function deletePartner($id){
         if ($id){
            $db = $this->partnerRepository->deleteFromDB($id);

            if ($db) {
                return redirect()
                    ->route('blog.admin.partners.index')
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
