<?php

namespace app\controller;

use app\model\Migrate as MMigrate;

class Migrate extends Base
{

	public function Migrate()
	{
		(new MMigrate())->migrateLeads();
	}

}