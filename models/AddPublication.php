<?php 	
class AddPublication
{
 	public static function Add($postArr, $authorId)
	{
	if (isset($postArr['go_publicate']))
	{
		if (strlen(trim($postArr["my_publication"])) != 0)
		{
		$publication = R::dispense('publications');
		$publication->author_identeficator = $authorId;
		$publication->publicate_content = $postArr["my_publication"];
		$publication->publication_time = time();
		R::store ($publication);
		header("Location: my_publications");
		}
	}
 		
	}
}
 ?>