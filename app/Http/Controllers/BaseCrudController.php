<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

abstract class BaseCrudController extends Controller
{
    protected string $moduleKey; // must match config/modules.php key

    public function __construct()
    {
        if (!isset($this->moduleKey)) {
            throw new \Exception("moduleKey not set in controller");
        }

        $this->middleware('auth.admin');
        $this->middleware("permission:{$this->moduleKey}.view,admin")->only('index');
        $this->middleware("permission:{$this->moduleKey}.create,admin")->only(['create', 'store']);
        $this->middleware("permission:{$this->moduleKey}.edit,admin")->only(['edit', 'update']);
        // $this->middleware("permission:{$this->moduleKey}.edit,admin")->only(['some-global-edit-if-needed']);
        $this->middleware("permission:{$this->moduleKey}.delete,admin")->only('destroy');
        // $this->middleware("permission:{$this->moduleKey}.delete,admin")->only(['some-global-edit-if-needed']);
    }
}
