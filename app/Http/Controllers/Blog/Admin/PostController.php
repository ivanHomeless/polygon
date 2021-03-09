<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogPostUpdateRequest;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PostController extends BaseController
{
    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            abort(404);;
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view(
            'blog.admin.posts.edit',
            compact('item', 'categoryList')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogPostUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id={$id} не найдена."])
                ->withInput();
        }

        $data = $request->all();

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
