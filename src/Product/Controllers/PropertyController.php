<?php

namespace AvoRed\Framework\Product\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use AvoRed\Framework\Models\Database\Property as Model;
use AvoRed\Framework\Product\DataGrid\PropertyDataGrid;
use AvoRed\Framework\Product\Requests\PropertyRequest;
use AvoRed\Framework\System\Controllers\Controller;

class PropertyController extends Controller
{
    /**
     * Display a listing of the Property.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $propertyGrid = new PropertyDataGrid(Model::query()->orderBy('id', 'desc'));

        return view('avored-framework::product.property.index')
                    ->with('dataGrid', $propertyGrid->dataGrid);
    }

    /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('avored-framework::product.property.create');
    }

    /**
     * Store a newly created property in database.
     *
     * @param \AvoRed\Framework\Product\Requests\PropertyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        $property = Model::create($request->all());

        $this->_saveDropdownOptions($property, $request);

        return redirect()->route('admin.property.index');
    }

    /**
     * Show the form for editing the specified property.
     *
     * @param \AvoRed\Framework\Models\Database\Property $property
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $property)
    {
        return view('avored-framework::product.property.edit')->with('model', $property);
    }

    /**
     * Update the specified property in database.
     *
     * @param \AvoRed\Framework\Product\Requests\PropertyRequest $request
     * @param \AvoRed\Framework\Models\Database\Property $property
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PropertyRequest $request, Model $property)
    {
        $property->update($request->all());

        $this->_saveDropdownOptions($property, $request);

        return redirect()->route('admin.property.index');
    }

    /**
     * Remove the specified property from storage.
     *
     * @param \AvoRed\Framework\Models\Database\Property $property
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Model $property)
    {
        Model::destroy($id);

        return redirect()->route('admin.property.index');
    }

    /**
     * Get the Element Html in Json Response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getElementHtml(Request $request)
    {
        $properties = Model::whereIn('id', $request->get('property_id'))->get();

        $tmpString = str_random();
        $view = view('avored-framework::product.property.get-element')
                        ->with('properties', $properties)
                        ->with('tmpString', $tmpString);

        $json = new JsonResponse(['success' => true, 'content' => $view->render()]);

        return $json;
    }

    /**
     * Save Property Dropdown Field options
     *
     * @param \AvoRed\Framework\Models\Database\Property $proerty
     * @param \AvoRed\Framework\Product\Request\PropertyRequest $request
     *
     * @return void
     */
    private function _saveDropdownOptions($property, $request)
    {
        if (null !== $request->get('dropdown-options')) {
            $property->propertyDropdownOptions()->delete();

            foreach ($request->get('dropdown-options') as $key => $val) {
                if ($key == '__RANDOM_STRING__') {
                    continue;
                }

                $property->propertyDropdownOptions()->create($val);
            }
        }
    }
}
