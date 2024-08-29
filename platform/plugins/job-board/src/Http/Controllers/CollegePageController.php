<?php

namespace Botble\JobBoard\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Breadcrumb;
use Botble\Page\Forms\CollegePageForm;
use Botble\Page\Tables\CollegePageTable;
use Botble\Page\Http\Requests\PageRequest;
use Illuminate\Support\Facades\Auth;

class CollegePageController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('Colleges'), route('companies.index'));
    }

    public function index(CollegePageTable $pageTable, $college)
    {      
        $pageTable->setCollege($college);
        $pageTable->setup();
        $this->pageTitle(trans('plugins/job-board::college.name'));

        return $pageTable->renderTable();
    }

    public function create(){
        $this->pageTitle(trans('packages/page::pages.create'));

        return CollegePageForm::create()->renderForm();
    }

    public function store(PageRequest $request, $college)
    {
        $form = CollegePageForm::create()->setRequest($request);

        $form->saving(function (CollegePageForm $form) use ($college) {
            $form
                ->getModel()
                ->fill([...$form->getRequest()->input(), 'user_id' => Auth::guard()->id()])
                ->fill([...$form->getRequest()->input(), 'college_id' => $college])
                ->save();
        });


        return $this
            ->httpResponse()
            ->setPreviousRoute('college.pages.index', ['college' => $college])
            ->setNextRoute('college.pages.index', ['college' => $college])
            ->withCreatedSuccessMessage();
    }
}
