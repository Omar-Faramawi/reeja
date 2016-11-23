<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Database;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\BundlesRequest;
use Tamkeen\Ajeer\Models\Bundle;
use Vinkla\Hashids\Facades\Hashids;

class BundlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bundles = Bundle::active()->paid()->paginate(20);

        return view('admin.taqawel.bundles.index', compact('bundles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.taqawel.bundles.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BundlesRequest $request
     *
     * @return string
     */
    public function store(BundlesRequest $request)
    {
        $betweenBundlesMin = Bundle::where('min_of_num_ishaar', '<=', $request->min_of_num_ishaar)
            ->where('max_of_num_ishaar', '>=', $request->min_of_num_ishaar)
            ->active()
            ->count();
        if ($betweenBundlesMin) {
            return response()->json(['min_of_num_ishaar' => trans('bundles.error_of_between_min')], 422);
        }
        $betweenBundlesMax = Bundle::where('min_of_num_ishaar', '<=', $request->max_of_num_ishaar)
            ->where('max_of_num_ishaar', '>=', $request->max_of_num_ishaar)
            ->active()
            ->count();
        if ($betweenBundlesMax) {
            return response()->json(['max_of_num_ishaar' => trans('bundles.error_of_between_max')], 422);
        }
        $data = $request->only(array_keys($request->rules()));
        $data['status'] = 1;
        Bundle::create($data);

        return trans('bundles.bundleadded');
    }

    /**
     * Display the specified resource.
     *
     * @param  Bundle $bundle
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Bundle $bundle)
    {
        return $this->edit($bundle);
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
        $bundle = Bundle::byId($id)->firstOrFail();

        return view('admin.taqawel.bundles.edit', compact('bundle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BundlesRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BundlesRequest $request, $id)
    {
        $betweenBundlesMin = Bundle::where('min_of_num_ishaar', '<=', $request->min_of_num_ishaar)
            ->where('max_of_num_ishaar', '>=', $request->min_of_num_ishaar)
            ->where('id', '<>', Hashids::decode($id))
            ->active()
            ->count();
        if ($betweenBundlesMin) {
            return response()->json(['min_of_num_ishaar' => trans('bundles.error_of_between_min')], 422);
        }
        $betweenBundlesMax = Bundle::where('min_of_num_ishaar', '<=', $request->max_of_num_ishaar)
            ->where('max_of_num_ishaar', '>=', $request->max_of_num_ishaar)
            ->where('id', '<>', Hashids::decode($id))
            ->active()
            ->count();
        if ($betweenBundlesMax) {
            return response()->json(['max_of_num_ishaar' => trans('bundles.error_of_between_max')], 422);
        }
        $bundle = Bundle::byId($id)->firstOrFail();
        $data = $request->only(array_keys($request->rules()));
        $bundle->fill($data);
        $bundle->save();

        return trans('bundles.bundleupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bundle = Bundle::byId($id)->firstOrFail();
        $bundle->update(['status' => 0]);

        return trans('bundles.bundledeleted');
    }
}
