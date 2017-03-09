<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CompareText\CompareText,
    Illuminate\Contracts\View\View,
    Illuminate\Http\JsonResponse,
    Illuminate\Support\Facades\Input;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * @return View
     */
    public function getIndex():View
    {
       /* $t1 = "1)Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        2)Duis quis pretium justo. 
        3) Proin laoreet sollicitudin mauris, ut semper risus fermentum in. 
        3)Vestibulum imperdiet ex sagittis, porttitor libero consequat, pretium felis.
        4)Nulla facilisi.
         
         5)Praesent dolor ante, suscipit nec eros id, congue suscipit nunc. 
         6)Aliquam bibendum turpis a porta rutrum. Duis dignissim pulvinar aliquet. 
         7)Nullam porta tincidunt justo, et facilisis eros eleifend et.";
        $t2 = "1)Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
         

        3)Vestibulum imperdiet ex sagittis, porttitor libero consequat, pretium felis.
        4)Nulla facilisi.
        new)Cras tristique turpis a neque aliquam molestie. 
        5)Praesent dolor ante, suscipit nec eros id, congue suscipit nunc. 
        6)Aliquam bibendum turpis a porta rutrum. Duis dignissim pulvinar aliquet. 
        7)Nullam porta tincidunt justo, et facilisis eros eleifend et.";
        $compareText = new CompareText($t1, $t2);
        $compareText->getResult();*/
        return view('index');
    }

    /**
     * @return JsonResponse
     */
    public function compareText():JsonResponse
    {
        $compareText = new CompareText(Input::get('originalText'), Input::get('newText'));
        //dd($compareText->getResult());
        return response()->json(['data' => $compareText->getResult()]);
    }
}
