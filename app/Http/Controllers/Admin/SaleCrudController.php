<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\Product;
use App\Http\Requests\SaleRequest;
use App\Models\Purchase;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SaleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SaleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Sale::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sale');
        CRUD::setEntityNameStrings('sale', 'sales');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {       

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        CRUD::column('product_id')
            ->type('select')
            ->entity('product')
            ->attribute('name')
            ->model("app\Models\Product")
            ->wrapper([
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('product/'.$related_key.'/show');
                },
        ]);
        CRUD::column('quantity');
        CRUD::column('cash');
    }

   

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SaleRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
        CRUD::addField([  
            'label'     => 'Product',
            'type'      => 'select2',
            'model' =>  'app\Models\Product',
            'name'      => 'product_id', // the db column for the foreign key
            'entity'    => 'product', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
        ]);
        
        CRUD::addField([  
            'name'  => 'quantity',
            'label' => 'Quantity',
            'type'  => 'number',
        ]);
    }

    public function store(SaleRequest $request){
        $purchase = Product::findOrFail($request->product_id)->purchase[0];
        $sale_unit = Product::findOrFail($request->product_id)->unit['value'];
        $purchase_quantity = $purchase['quantity'];
        $new_quantity = $purchase_quantity - $request->quantity;
        $cash = $request->quantity * $sale_unit;
        if(($purchase_quantity >= 0)){
            $purchase->update([
                'product_id' => $request->product_id,
                'quantity' => $new_quantity,
            ]); 
            Sale::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'cash' => $cash,
            ]);   
            return redirect()->route('sale.index');     
        }else{
            return redirect()->route('sale.index')->withErrors(['error','product quantity is low.']);
        }
        
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
