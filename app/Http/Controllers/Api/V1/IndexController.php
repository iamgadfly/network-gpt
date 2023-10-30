<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestRequset;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * @return string
     * @lrd:start
     * Hello markdown
     * Free `code` or *text* to write documentation in markdown
     * @lrd:end
     */
    public function test(TestRequset $requset)
    {
        //        dd(322);
        return $requset->all();
    }

}
