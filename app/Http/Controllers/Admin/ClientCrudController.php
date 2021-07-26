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
            'name'      => 'firstname',
            'label'     => trans('crud.client.firstname'),
        ]);
        
        $this->crud->addColumn([
            'name'      => 'lastname',
            'label'     => trans('crud.client.lastname'),
        ]);
        
        $this->crud->addColumn([
            'name'      => 'ci',
            'label'     => trans('crud.client.ci'),
        ]);
        
        $this->crud->addColumn([
            'name'      => 'email',
            'label'     => trans('crud.client.email'),
        ]);

        $this->crud->addColumn([
            'name'      => 'phone',
            'label'     => trans('crud.client.phone'),
        ]);

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'firstname',
            'label' => trans('crud.client.firstname')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'firstname', 'LIKE', "%$value%");
        });
        
        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'lastname',
            'label' => trans('crud.client.lastname')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'lastname', 'LIKE', "%$value%");
        });
        
        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'ci',
            'label' => trans('crud.client.ci')
        ], 
        false, 
        function($value) {
            $this->crud->addClause('where', 'ci', 'LIKE', "%$value%");
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
            'name'  => 'firstname',
            'label' => trans('crud.client.firstname'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'lastname',
            'label' => trans('crud.client.lastname'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'ci',
            'label' => trans('crud.client.ci'),
            'type'  => 'text',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'email',
            'label' => trans('crud.client.email'),
            'type'  => 'email',
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
