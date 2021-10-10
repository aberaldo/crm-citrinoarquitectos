<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Client::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client');
        CRUD::setEntityNameStrings(trans('crud.client.client'), trans('crud.client.clients'));
        $this->crud->enableExportButtons();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->denyAccess('show');
        
        $this->crud->addColumn([
            'name'      => 'name',
            'label'     => trans('crud.client.name'),
        ]);
        
        $this->crud->addColumn([
            'name'      => 'created_at',
            'label'     => trans('crud.client.date'),
            'type'  => 'date',
            'format' => 'DD/MM/YYYY'
        ]);
        
        $this->crud->addColumn([
            'name'      => 'address',
            'label'     => trans('crud.client.address'),
        ]);
        
        $this->crud->addColumn([
            'name'      => 'email',
            'label'     => trans('crud.client.email'),
        ]);

        $this->crud->addColumn([
            'name'      => 'phone',
            'label'     => trans('crud.client.phone'),
        ]);
        
        $this->crud->addColumn([
            'name'      => 'company',
            'label'     => trans('crud.client.company'),
        ]);
        
        $this->crud->addColumn([
            'name'      => 'rut',
            'label'     => trans('crud.client.rut'),
        ]);
        
        $this->crud->addColumn([
            'name'      => 'fiscal_address',
            'label'     => trans('crud.client.fiscal_address'),
        ]);

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'name',
            'label' => trans('crud.client.name')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
        });
        
        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'address',
            'label' => trans('crud.client.address')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'address', 'LIKE', "%$value%");
        });
        
        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'email',
            'label' => trans('crud.client.email')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'email', 'LIKE', "%$value%");
        });
        
        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'phone',
            'label' => trans('crud.client.phone')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'phone', 'LIKE', "%$value%");
        });
        
        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'company',
            'label' => trans('crud.client.company')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'company', 'LIKE', "%$value%");
        });
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientRequest::class);

        $this->crud->addField([
            'name'  => 'name',
            'label' => trans('crud.client.name'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'address',
            'label' => trans('crud.client.address'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'email',
            'label' => trans('crud.client.email'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'phone',
            'label' => trans('crud.client.phone'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'company',
            'label' => trans('crud.client.company'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'rut',
            'label' => trans('crud.client.rut'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'fiscal_address',
            'label' => trans('crud.client.fiscal_address'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
