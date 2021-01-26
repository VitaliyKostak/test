<?php 	
class GetAllUsers
{
 	public static function Get()
	{
			return R::findAll( 'users', "ORDER by `id` DESC");
	}
}