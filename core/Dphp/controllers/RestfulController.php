<?php
/**
 *
 * RestfulController.php on Dphp
 *
 * Code By ch4o5.
 * on 五月 21th/2020 at 14:29
 *
 * Powered By PhpStorm
 */

namespace Controllers;

use Services\ResponseService;

/**
 * RestApi基类（M-C模型，没有View层）
 * Class RestfulController
 *
 * @package Controllers
 *
 * @author  ch4o5.
 * create on 2020/5/21
 */
class RestfulController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->response = new ResponseService();
    }
}