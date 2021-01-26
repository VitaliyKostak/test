<?php 
class GeneratePageViewController
{
	public static function GeneratePageView($PageName)
	{
		if ($PageName == '') 
	    {
		    require('views/Main.php');
	    }
	    else
	    {
		require('views/'.$PageName.'.php');
		}
	}
}


 ?>