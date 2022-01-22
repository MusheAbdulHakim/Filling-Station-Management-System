<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Unit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        CRUD::column('name');
        CRUD::column('image')
            ->type('image');
        CRUD::column('unit_id')
            ->type('select')
            ->entity('unit')
            ->attribute('name')
            ->model("app\Models\Unit")
            ->wrapper([
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('unit/'.$related_key.'/show');
                },
            ]);
        CRUD::column('cost_price')
            ->type('decimal');
        CRUD::column('sale_price')
            ->type('decimal');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        // CRUD::setFromDb(); // fields
        CRUD::addField([   
            'name'  => 'name',
            'label' => 'Product Name',
            'type'  => 'text',
        ]);
        CRUD::addField([  // Select2
            'label'     => 'unit',
            'type'      => 'select2',
            'model' =>  'app\Models\Unit',
            'name'      => 'unit_id', // the db column for the foreign key
            'entity'    => 'unit', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            // 'wrapperAttributes' => [
            //     'class' => 'form-group col-md-6'
            //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields
        ]);
        
        CRUD::addField([   
            'name'  => 'cost_price',
            'label' => 'Cost Price',
            'type'  => 'number',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            // 'prefix' => '$',
            'suffix' => '.00',
            // 'wrapperAttributes' => [
            //    'class' => 'form-group col-md-6'
            //  ], // extra HTML attributes for the field wrapper - mostly for resizing fields
        ]);
        CRUD::addField([   
            'name'  => 'sale_price',
            'label' => 'Sale Price',
            'type'  => 'number',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            // 'prefix' => '$',
            'suffix' => '.00',
            // 'wrapperAttributes' => [
            //    'class' => 'form-group col-md-6'
            //  ], // extra HTML attributes for the field wrapper - mostly for resizing fields
        ]);
        CRUD::field('image')
                ->type('image')
                ->label('Product Image')
                ->upload(true)
                ->crop(true)
                ->aspect_ratio(1)
                ->src(null);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
