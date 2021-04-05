<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ReflectionClass;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Database\Schema\Table;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Events\BreadDeleted;
use TCG\Voyager\Events\BreadUpdated;
use TCG\Voyager\Facades\Voyager;
use Datatables;
use App\User;
use App\Wallet;

class WalletController extends Controller
{
    public function index()
    {
       return view('wallet.requests');
    }



   
   
}