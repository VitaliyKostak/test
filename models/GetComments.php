<?php 	
class GetComments
{
 	public static function Get($publicationId)
	{
			return R::find( 'comments', "publication_identeficator = ? ORDER BY publication_time DESC", array($publicationId));
	}
}