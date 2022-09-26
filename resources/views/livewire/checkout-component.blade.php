<div>
    <style>
        .summary-item .row-in-form input[type="password"], .summary-item .row-in-form input[type="text"], .summary-item .row-in-form input[type="tel"] {
            font-size: 13px;
            line-height: 19px;
            display: inline-block;
            height: 43px;
            padding: 2px 20px;
            max-width: 300px;
            width: 100%;
            border: 1px solid #e6e6e6;
        }
    </style>
    <!--main area-->
     <main id="main" class="main-site">

         <div class="container">

             <div class="wrap-breadcrumb">
                 <ul>
                     <li class="item-link"><a href="/" class="link">home</a></li>
                     <li class="item-link"><span>Checkout</span></li>
                 </ul>
             </div>
             <div class=" main-content-area">
                <form wire:submit.prevent="placeOrder" onsubmit="$('#processing').show();">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="wrap-address-billing">
                                <h3 class="box-title">Billing Address</h3>
                                <div class="billing-address">
                                    <p class="row-in-form">
                                        <label for="fname">first name<span>*</span></label>
                                        <input type="text" placeholder="Your name" wire:model="firstname">
                                        @error('firstname') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="lname">last name<span>*</span></label>
                                        <input type="text" placeholder="Your last name" wire:model="lastname">
                                        @error('lastname') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="email">Email Addreess:</label>
                                        <input type="email" placeholder="Type your email" wire:model="email">
                                        @error('email') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="phone">Phone number<span>*</span></label>
                                        <input type="number" placeholder="10 digits format" wire:model="mobile">
                                        @error('mobile') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="add">Line1:</label>
                                        <input type="text" placeholder="Street at apartment number" wire:model="line1">
                                        @error('line1') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="add">Line2:</label>
                                        <input type="text" placeholder="Street at apartment number" wire:model="line2">
                                    </p>
                                    <p class="row-in-form">
                                        <label for="country">Country<span>*</span></label>
                                        <input type="text" placeholder="United States" wire:model="country">
                                        @error('country') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="province">Province<span>*</span></label>
                                        <input type="text" placeholder="Province" wire:model="province">
                                        @error('province') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="city">Town / City<span>*</span></label>
                                        <input type="text" placeholder="City name" wire:model='city'>
                                        @error('city') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="zip-code">Postcode / ZIP:</label>
                                        <input type="number" placeholder="Your postal code" wire:model="zipcode">
                                        @error('zipcode') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form fill-wife">
                                        <label class="checkbox-field">
                                            <input name="different-add" id="different-add" value="1" type="checkbox" wire:model="shipping_different">
                                            <span>Ship to a different address?</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($shipping_different)
                            <div class="col-md-12">
                                <div class="wrap-address-billing">
                                    <h3 class="box-title">Shipping Address</h3>
                                    <div class="shipping-address">
                                        <p class="row-in-form">
                                            <label for="fname">first name<span>*</span></label>
                                            <input type="text" placeholder="Your name" wire:model="s_firstname">
                                            @error('s_firstname') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                        <p class="row-in-form">
                                            <label for="lname">last name<span>*</span></label>
                                            <input type="text" placeholder="Your last name" wire:model="s_lastname">
                                            @error('s_lastname') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                        <p class="row-in-form">
                                            <label for="email">Email Addreess:</label>
                                            <input type="email" placeholder="Type your email" wire:model="s_email">
                                            @error('s_email') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                        <p class="row-in-form">
                                            <label for="phone">Phone number<span>*</span></label>
                                            <input type="number" placeholder="10 digits format" wire:model="s_mobile">
                                            @error('s_mobile') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                        <p class="row-in-form">
                                            <label for="add">Line1:</label>
                                            <input type="text" placeholder="Street at apartment number" wire:model="s_line1">
                                            @error('s_line1') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                        <p class="row-in-form">
                                            <label for="add">Line2:</label>
                                            <input type="text" placeholder="Street at apartment number" wire:model="s_line2">
                                        </p>
                                        <p class="row-in-form">
                                            <label for="country">Country<span>*</span></label>
                                            <input type="text" placeholder="United States" wire:model="s_country">
                                            @error('s_country') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                        <p class="row-in-form">
                                            <label for="province">Province<span>*</span></label>
                                            <input type="text" placeholder="Province" wire:model="s_province">
                                            @error('s_province') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                        <p class="row-in-form">
                                            <label for="city">Town / City<span>*</span></label>
                                            <input type="text" placeholder="City name" wire:model='s_city'>
                                            @error('s_city') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                        <p class="row-in-form">
                                            <label for="zip-code">Postcode / ZIP:</label>
                                            <input type="number" placeholder="Your postal code" wire:model="s_zipcode">
                                            @error('s_zipcode') <span class="text-red-600">{{$message}}</span> @enderror
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                     <div class="summary summary-checkout">
                         <div class="summary-item payment-method">
                             <h4 class="title-box">Payment Method</h4>
                             @if ($payment_method == 'card')
                                <div class="wrap-address-billing">
                                    @if (Session::has('stripe_error'))
                                        <div class="alert alert-danger">
                                            {{Session::get('stripe_error')}}
                                        </div>
                                    @endif
                                    <p class="row-in-form">
                                        <label for="card-number">Card Number:<span>*</span></label>
                                        <input type="text" placeholder="Card Number" wire:model="card_number">
                                        @error('card_number') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>

                                    <p class="row-in-form">
                                        <label for="expiry-month">Expiry Month:<span>*</span></label>
                                        <input type="text" placeholder="MM" wire:model="expiry_month">
                                        @error('expiry_month') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>

                                    <p class="row-in-form">
                                        <label for="expiry-year">Expiry Year:<span>*</span></label>
                                        <input type="text" placeholder="YYYY" wire:model="expiry_year">
                                        @error('expiry_year') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>

                                    <p class="row-in-form">
                                        <label for="cvc">CVC:<span>*</span></label>
                                        <input type="password" placeholder="CVC" wire:model="cvc">
                                        @error('cvc') <span class="text-red-600">{{$message}}</span> @enderror
                                    </p>
                                </div>
                             @endif
                             <div class="choose-payment-methods">
                                 <label class="payment-method">
                                     <input name="payment-method" id="payment-method-bank" value="cod" type="radio" wire:model="payment_method">
                                     <span>Cash On Delivery</span>
                                     <span class="payment-desc">Order Now Pay on Delivery</span>
                                 </label>
                                 <label class="payment-method">
                                     <input name="payment-method" id="payment-method-visa" value="card" type="radio" wire:model="payment_method">
                                     <span>Debit / Credit Card</span>
                                     <span class="payment-desc">There are many variations of passages of Lorem Ipsum available</span>
                                 </label>
                                 <label class="payment-method">
                                     <input name="payment-method" id="payment-method-paypal" value="paypal" type="radio" wire:model="payment_method">
                                     <span>Paypal</span>
                                     <span class="payment-desc">You can pay with your credit</span>
                                     <span class="payment-desc">card if you don't have a paypal account</span>
                                 </label>
                                 @error('payment_method')
                                    <span class="text-red-600">{{$message}}</span>
                                 @enderror
                             </div>
                             @if (Session::has('checkout'))
                                <p class="summary-info grand-total"><span>Grand Total</span> <span class="grand-total-price">${{Session::get('checkout')['total']}}</span></p>
                             @endif

                             @if (!$errors->isEmpty())
                                <div wire:ignore id="processing" style="font-size: 22px; margin-bottom:20px;padding-left:37px;color:green;display:none;">
                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    <span>Processing...</span>
                                </div>
                             @endif

                             <button type="submit" class="btn btn-medium">Place order now</button>
                         </div>
                         <div class="summary-item shipping-method">
                             <h4 class="title-box f-title">Shipping method</h4>
                             <p class="summary-info"><span class="title">Flat Rate</span></p>
                             <p class="summary-info"><span class="title">Fixed $00.00</span></p>
                         </div>
                     </div>
                </form>
             </div><!--end main content area-->
         </div><!--end container-->

     </main>
     <!--main area-->
 </div>
