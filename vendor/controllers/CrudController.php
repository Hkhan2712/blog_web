<?php 
class CrudController extends MainController {
    public function __construct()
    {
        global $app;
        $this->controller = $app['ctl'];
        if (isset($app['act'])) $this->action = $app['ctl'];
        else $app['act'] = $this->action;

        if (method_exists($this, $this->action)) {
            if($this->action=='view' || $this->action=='edit' || $this->action=='del') {
				$id='';
				if(isset($app['prs'][1]))	$id=$app['prs'][1];
				$this->{$this->action}($id);
			} else {
				if(isset($app['prs']) && count($app['prs'])) {
					$this->{$this->action}($app['prs']);
				} else $this->{$this->action}();
			}
        } else {
            include_once "views/".$app['areaPath']."staticpages/error.php";
        }
    }
}