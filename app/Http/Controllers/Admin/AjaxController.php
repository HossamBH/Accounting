<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    //return items of selcted category
    public function getItemsByCategory($category_id){
        $items = Item::where('category_id', '=', $category_id)->select('*')->get()->toArray();
        return response()->json($items);
    }



//return item details and the subtotall for item ,subtotal and Total for all items in create sales order
    public function getItem(Request $request,$item_id,$quantity,$invoice){
        
        //dd($total);
        //dd($quantity);
        $subAllTotal=0;
        $alltax=0;
        $total=0;
        $invoiceData=json_decode($invoice);

        foreach ($invoiceData as $key => $value) {
            $item = Item::Find($value[0]);
            $subAllTotal+=$item->price*$value[1];
            $alltax+=$value[1]*$item->category->tax->percentage*$item->price/100;  
        }
        $total=$subAllTotal+$alltax;
        //dd($total);
        //dd(json_decode($invoice));
        $item = Item::FindOrFail($item_id);
        $subtotal=$item->price*1;  
        if($quantity){
          
            $subtotal=$item->price*$quantity; 
        }
        $data['item']=$item;
        $data['subtotal']=$subtotal;
        $data['subAllTotal']=$subAllTotal;
        $data['allTax']=$alltax;
        $data['total']=$total;


        return response()->json($data);
    }



    //return total amount for all items in create purchase order
    
    public function TotalPurchaseOrder(Request $request,$cost,$quantity,$invoice){
        $subAllTotal=0;
        $total=0;
        $invoiceData=json_decode($invoice);

        foreach ($invoiceData as $key => $value) {
            $subAllTotal+=$value[0]*$value[1]; 
        }
        $total=$subAllTotal;
       
        $subtotal=$cost*1;  
        if($quantity){
          
            $subtotal=$cost*$quantity; 
        }
        $data['subtotal']=$subtotal;
        $data['subAllTotal']=$subAllTotal;
        $data['total']=$total;


        return response()->json($data);
    }

    //return the remaining amount of paid in purchase order 

    public function remaining(Request $request,$paid,$total){
        $remaining=$total-$paid;
        $data['remaining']=$remaining;
        return response()->json($data);

    }

    
    public function invoice(Request $request,$invoice){
   $total=json_encode($invoice);
   dd($total);

        return response()->json($data);
    }

    
}
