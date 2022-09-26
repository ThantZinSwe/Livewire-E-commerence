<?php

namespace App\Http\Livewire\User\Review;

use App\Models\OrderItem;
use App\Models\Review;
use Livewire\Component;

class UserReviewComponent extends Component {

    public $order_item_id;
    public $rating;
    public $comment;

    protected $rules = array(
        'rating'  => 'required',
        'comment' => 'required',
    );

    public function mount( $order_item_id ) {
        $this->order_item_id = $order_item_id;
    }

    public function addReview() {
        $this->validate();

        $order_item = OrderItem::findOrFail( $this->order_item_id );

        if ( $order_item->rstatus == true ) {
            $review = Review::where( 'order_item_id', $this->order_item_id )->first();
            $review->update( array(
                $review->rating = $this->rating,
                $review->comment = $this->comment,
            ) );
        } else {
            $review = new Review();
            $review->order_item_id = $this->order_item_id;
            $review->rating = $this->rating;
            $review->comment = $this->comment;
            $review->save();

            $order_item->rstatus = true;
            $order_item->save();
        }

        session()->flash( 'message', 'Thank you for your review.' );
    }

    public function render() {

        $order_item = OrderItem::findOrFail( $this->order_item_id );

        return view( 'livewire.user.review.user-review-component', array( 'order_item' => $order_item ) )
            ->layout( 'layouts.base' );
    }

}
