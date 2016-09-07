<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\QuestionAndAnswerRequest;
use Tamkeen\Ajeer\Models\RatingModels;
use Tamkeen\Ajeer\Http\Requests\RatingModelsRequest;
use Tamkeen\Ajeer\Models\TaqyeemDegrees;
use Tamkeen\Ajeer\Models\TaqyeemItems;

class RatingModelsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratingModels = RatingModels::latest()->paginate(20);

        return view("admin.rating_models.index", compact("ratingModels"));
    }

    /**
     * remove any Questions saved on session before
     *
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->forget('full');

        return view("admin.rating_models.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RatingModelsRequest $ratingModelsRequest
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(RatingModelsRequest $ratingModelsRequest)
    {
        $data = $ratingModelsRequest->only(array_keys($ratingModelsRequest->rules()));
        $createdTemplate = RatingModels::create($data);
        $question = $ratingModelsRequest->get("question");
        $answers = $ratingModelsRequest->get("answer");
        if ($ratingModelsRequest->session()->has("full")) {
            $full = $ratingModelsRequest->session()->get("full");
        }
        if ($question && $answers) {
            $full[] = [
                "q" => $question,
                "a" => $answers
            ];
            $ratingModelsRequest->session()->put("full", $full);
        }
        $questionAndAnswerSession = $ratingModelsRequest->session()->get("full");
        foreach ($questionAndAnswerSession as $key => $value) {
            $createdQuestion = new TaqyeemItems;
            $createdQuestion->name = $value['q'];
            $createdQuestion->save();
            foreach ($value['a'] as $answer) {
                $createdAnswer = new TaqyeemDegrees(["name" => $answer]);
                $createdQuestion->degrees()->save($createdAnswer);
            }
            $createdQuestionArray[] = $createdQuestion->id;
        }
        $createdTemplate->items()->attach($createdQuestionArray,
            ['created_by' => auth()->id(), 'updated_by' => auth()->id()]);
        
        return trans("ratingmodels.sumbitedsucc");
    }

    /**
     * @param  int $id
     *
     *  redirect show method to edit method
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ratingModels = RatingModels::byId($id)->firstOrFail();
        Session::forget('full');
        if (count($ratingModels->items) > 0) {
            foreach ($ratingModels->items as $deleteId => $item) {
                $question = $item->name;
                $answers = json_decode($item->degrees);
                foreach ($answers as $answer) {
                    $newAnswer[] = $answer->name;
                }
                $full[$item->id] = [
                    "q"      => $question,
                    "a"      => $newAnswer,
                    "status" => "old"
                ];
                $newAnswer = [];
            }
            Session::put("full", $full);
        }

        return View("admin.rating_models.edit", compact("ratingModels"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RatingModelsRequest $ratingModelsRequest
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RatingModelsRequest $ratingModelsRequest, $id)
    {
        $questions = $ratingModelsRequest->session()->get('full');
        if (count($questions) > 0) {
            foreach ($questions as $questionId => $question) {
                $taqyeemItems = new TaqyeemItems;
                if ($question['status'] == "new") {
                    $taqyeemItems->name = $question['q'];
                    $taqyeemItems->save();
                    $insertedId = $taqyeemItems->orderBy('id', 'desc')->first();
                    $questionsArray[] = $insertedId->id;
                    foreach ($question['a'] as $answer) {
                        $createdAnswer = new TaqyeemDegrees(["name" => $answer]);
                        $taqyeemItems->degrees()->save($createdAnswer);
                    }
                } else {
                    $questionsArray[] = $questionId;
                }
            }
        } else {
            $questionsArray = [];
        }
        $ratingModels = RatingModels::byId($id)->firstOrFail();
        $data = $ratingModelsRequest->only(array_keys($ratingModelsRequest->rules()));
        $ratingModels->update($data);
        $ratingModels->items()->sync($questionsArray,
            ['created_by' => auth()->id(), 'updated_by' => auth()->id()]);

        return trans("ratingmodels.updated");
    }

    /**
     * check child Rows
     * return error if has any childs
     * if not soft delete resource
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $taqyeemTemplateItemsData = RatingModels::byId($id)->with('taqyeemTemplateItems', 'taqyeemDtl', 'taqyeems',
            'taqyeemTemplatePermission')
            ->firstOrFail();
        if (count($taqyeemTemplateItemsData->taqyeemTemplateItems) || count($taqyeemTemplateItemsData->taqyeemDtl) || count($taqyeemTemplateItemsData->taqyeems) || count($taqyeemTemplateItemsData->taqyeemTemplatePermission)) {
            return response()->json(['error' => trans('ratingmodels.error_delete')], 422);
        }
        $taqyeemTemplateItemsData->delete();

        return trans("ratingmodels.deleted");
    }

    /**
     * Method To activate or disactivate contact natures
     * get id of the contract nature request
     * toggle status
     * @param Request $request
     *
     * @return activated or disactivated message
     */
    public function approve(Request $request)
    {
        $status = RatingModels::byId($request->get("id"))->firstOrFail();
        if ($request->get('type') == "approve") {
            $status->status = "1";
            $returned = trans("ratingmodels.activated");
        } else {
            $status->status = "0";
            $returned = trans("ratingmodels.stopactivated");
        }
        $status->save();

        return $returned;
    }

    /**
     * Method to add question and its answers to the session
     * @param Request $request
     * $question get question from the form
     * $answers get all answers from the form
     * $full[] make an array mixed between answers and Question
     * The make all related answers to the question is one array element
     * make session and push the question and answer element to it
     *
     *return view Question and answers list to ajax request
     */
    public function addSession(QuestionAndAnswerRequest $request)
    {
        $question = $request->get("question");
        $answers = $request->get("answers");
        if ($request->session()->has("full")) {
            $full = $request->session()->get("full");
        }
        $full[] = [
            "q"      => $question,
            "a"      => $answers,
            "status" => "new"
        ];
        $request->session()->put("full", $full);

        return view("admin.rating_models.questions");
    }

    /**
     * method to remove question and its answers from session
     * @param Request $request
     * @param $id
     * $sessionArray get all questions and answers session
     * $newArray remove element of array that we need to remove
     * rest session
     * put new session values
     *
     * return labels of removed
     */
    public function removeFromSession(Request $request, $id)
    {
        $sessionArray = $request->session()->get('full');
        $arrayToForget = $sessionArray;
        $newArray = array_forget($arrayToForget, $id);
        $full = $arrayToForget;
        $request->session()->forget('full');
        $request->session()->put("full", $full);

        return view("admin.rating_models.questions");
    }

}
