@extends(backpack_view('blank'))

@php
	// ---------------------
	// JUMBOTRON widget demo
	// ---------------------
	

	// -------------------------
	// FLUENT SYNTAX for widgets
	// -------------------------
	// Using the progress_white widget
	// 
	// Obviously, you should NOT do any big queries directly in the view.
	// In fact, it can be argued that you shouldn't add Widgets from blade files when you
	// need them to show information from the DB.
	// 
	// But you do whatever you think it's best. Who am I, your mom?
	$userCount = App\User::count();
	$purchaseCount = App\Models\Purchase::count();
 	$salesCount = App\Models\Sale::count();
	$supplierCount = App\Models\Supplier::count();
	$productCount = App\Models\Product::count();

	 Widget::add()->to('before_content')->type('div')->class('row')->content([
		// notice we use Widget::make() to add widgets as content (not in a group)
		Widget::make()
			->type('progress')
			->class('card border-0 text-white bg-primary')
			->progressClass('progress-bar')
			->value($userCount)
			->description('Registered users.')
			->progress(100*(int)$userCount/1000),
		// alternatively, to use widgets as content, we can use the same add() method,
		// but we need to use onlyHere() or remove() at the end
		Widget::add()
		    ->type('progress')
		    ->class('card border-0 text-white bg-success')
		    ->progressClass('progress-bar')
		    ->value($purchaseCount)
		    ->description('Purchases.')
		    ->progress(80)
		    ->onlyHere(), 
		// alternatively, you can just push the widget to a "hidden" group
		Widget::make()
			->group('hidden')
		    ->type('progress')
		    ->class('card border-0 text-white bg-warning')
		    ->value($supplierCount)
		    ->progressClass('progress-bar')
		    ->description('Suppliers.')
		    ->progress(30),
		
		Widget::make()
			->group('hidden')
		    ->type('progress')
		    ->class('card border-0 text-white bg-dark')
		    ->value($productCount)
		    ->progressClass('progress-bar')
		    ->description('Products.')
		    ->progress(90),
		
	]);

    $widgets['before_content'][] = [
	  'type' => 'div',
	  'class' => 'row',
	  'content' => [ // widgets 
		  	[ 
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-6',
		        // 'class' => 'col-md-6',
		        'controller' => \App\Http\Controllers\Admin\Charts\LatestUsersChartController::class,
				'content' => [
				    'header' => 'New Users Past 7 Days', // optional
				    // 'body' => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>', // optional
					
		    	]
	    	],
	    	[ 
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-6',
		        // 'class' => 'col-md-6',
		        'controller' => \App\Http\Controllers\Admin\Charts\LatestPurchaseChartController::class,
				'content' => [
				    'header' => 'Past 7 Days Purchases', // optional
				    // 'body' => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>', // optional
		    	]
	    	],
    	]
	];
	$widgets['before_content'][] = [
	  'type' => 'div',
	  'class' => 'row',
	  'content' => [ // widgets 
	    	[ 
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-6',
		        // 'class' => 'col-md-6',
		        'controller' => \App\Http\Controllers\Admin\Charts\LatestSalesChartController::class,
				'content' => [
				    'header' => 'Sales for the past 7 days', // optional
				    // 'body' => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>', // optional
		    	]
	    	],
    	]
	];

    
    
@endphp

@section('content')
	{{-- In case widgets have been added to a 'content' group, show those widgets. --}}
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('group', 'content')->toArray() ])
@endsection
