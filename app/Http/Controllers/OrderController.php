<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\BookRequests;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{ 
    /**
     * @var OrderRepository
     */
    private $orders;

     /**
   *
   * @param OrderRepository $orders
   */
    public function __construct(OrderRepository $orders){
        $this->orders = $orders;
    }

    public function show($id=null): View
    {
        if($id){
            return $this->ordersView($id);
        }
        else {
            return $this->orderListsView();
        }
    }

    public function user(string $id): View{
        return view('user-orders', [
            'request' => $this->orders->getUserRequests($id),
        ]);
    }

    public function store(OrderUpdateRequest $request, string $id) {
        $user = $request->user();
        $newOrder = Orders::create([
            'user_id' => $user->id,
            'class_id' => $id
        ]);
        foreach($request->all() as $key => $value){
            $data = json_decode($value);
            foreach ($data as $item){
                BookRequests::create([
                    'book_id'=> $item->id,
                    'order_id'=> $newOrder->id,
                    'quantity'=> $item->quantity,
                ]);
            }
        }
    }

    /**
     * Update the order information.
     */
    public function update(OrderUpdateRequest $request, string $id)
    {
        foreach($request->all() as $key => $value){
            $data = json_decode($value);
            $order = Orders::find($id);
            
            $data->status ? $order->status = $data->status : null;
            $order->save();

            $data->notes ? $this->orders->updateNotes($id, $data->notes) : null;
            
        }
    }

    /**
     * Delete the order.
     */
    public function destroy(Request $request){
        $order = $request->order();

        $order->delete();
    }

    private function ordersView($id): View{
        return view('request', [
            'request' => $this->orders->getOrder($id),
            'books' => $this->orders->getBooks($id),
        ]);
    }

    private function orderListsView(): View {
        return view('orders', [
            'openList'=> $this->orders->getOpenOrders(),
            'pendingList'=> $this->orders->getPendingOrders(),
            'completedList'=> $this->orders->getCompletedOrders(),
        ]);
    }
}
