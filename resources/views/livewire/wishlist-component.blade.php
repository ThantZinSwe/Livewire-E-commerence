<div>
     <!--main area-->
	<main id="main" class="main-site left-sidebar">
		<div class="container">
			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="/" class="link">home</a></li>
					<li class="item-link"><span>Wishlist</span></li>
				</ul>
			</div>

            <style>
                .product-wish{
                    position: absolute;
                    left: 0;
                    top: 10%;
                    z-index: 99;
                    right: 30px;
                    text-align: right;
                    padding-top: 0
                }

                .product-wish .fa{
                    color: #cbcbcb;
                    font-size: 32px;
                }
                .product-wish .fa:hover{
                    color: #ff7007;
                }
                .fill-heart{
                    color: #ff7007 !important;
                }
            </style>
            <div class="row">
                @if (Session::has('success_message'))
                    <div class="alert alert-success">
                        {{Session::get('success_message')}}
                    </div>
                @endif

                @if (Cart::instance('wishlist')->content()->count() > 0)
                @php
                    $c_items = Cart::instance('cart')->content()->pluck('id');
                @endphp
                <ul class="product-list grid-products equal-container">
                    @foreach (Cart::instance('wishlist')->content() as $item)
                        @if (!$c_items->contains($item->id))
                            <li class="col-lg-3 col-md-6 col-sm-6 col-xs-6 ">
                                <div class="product product-style-3 equal-elem ">
                                    <div class="product-thumnail">
                                        <a href="{{route('product.details',['slug'=>$item->model->slug])}}" title="{{$item->model->name}}">
                                            <figure><img src="{{asset('assets/images/products/'.$item->model->image)}}" alt="{{$item->model->name}}"></figure>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <a href="{{route('product.details',['slug'=>$item->model->slug])}}" class="product-name"><span>{{$item->model->name}}</span></a>
                                        @if ($item->model->sale_price != null && $item->model->sale_price > 0 && $sale->status == 1 && $sale->sale_date > Carbon\Carbon::now())
                                            <div class="wrap-price"><ins><p class="product-price">${{$item->model->sale_price}}</p></ins> <del><p class="product-price">${{$item->model->regular_price}}</p></del></div>
                                            <a href="#" class="btn add-to-cart" wire:click.prevent="moveToCart({{$item->model->id}},'{{$item->model->name}}',{{$item->model->sale_price}})">Move To Cart</a>
                                            <div class="product-wish">
                                                <a href="#" wire:click.prevent="removeToWishlist({{$item->model->id}})"><i class="fa fa-heart fill-heart"></i></a>
                                            </div>
                                        @else
                                            <div class="wrap-price"><span class="product-price">${{$item->model->regular_price}}</span></div>
                                            <a href="#" class="btn add-to-cart" wire:click.prevent="moveToCart({{$item->model->id}},'{{$item->model->name}}',{{$item->model->regular_price}})">Move To Cart</a>
                                            <div class="product-wish">
                                                <a href="#" wire:click.prevent="removeToWishlist({{$item->model->id}})"><i class="fa fa-heart fill-heart"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @else
                        <p>No items in wishlist.</p>
                        @endif
                    @endforeach
                </ul>
            </div>
            @else
            <p>No items in wishlist.</p>
            @endif
        </div>
    </main>
</div>
