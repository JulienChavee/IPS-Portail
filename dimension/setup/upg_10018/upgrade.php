<?php


namespace IPS\dimension\setup\upg_10018;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * 1.1.1.1 Upgrade Code
 */
class _Upgrade
{
	/**
	 * ...
	 *
	 * @return	array	If returns TRUE, upgrader will proceed to next step. If it returns any other value, it will set this as the value of the 'extra' GET parameter and rerun this step (useful for loops)
	 */
	public function step1()
	{
		
		\IPS\Db::i()->insert( 'dimension_bonus', array( 'name' => "Régénération Critique", 'description' => "A chaque fois qu'un allié occasionne un coup critique, il est soigné de 2% de sa vitalité maximale.", 'portail' => 4 ) );
		\IPS\Db::i()->insert( 'dimension_bonus', array( 'name' => "Roulette Élementaire", 'description' => "A chaque début de tour d'un allié, il gagne aléatoirement 200 de caractéristique dans un élément pour 1 tour.", 'portail' => 4 ) );
		\IPS\Db::i()->insert( 'dimension_bonus', array( 'name' => "Case Bonus", 'description' => "A chaque début de tour d'un allié, des cellules bonus sont posées à 4 cases de distance en ligne avec cet allié. S'il se déplace sur une de ces cellule il gagne 2PA pour le tour en cours (non-cumulable).", 'portail' => 4 ) );
		\IPS\Db::i()->insert( 'dimension_bonus', array( 'name' => "Cible prioritaire", 'description' => "A chaque début de tour d'un ennemi, il y a 10% de chance pour que cet ennemi devienne une cible prioritaire : la première fois qu'il subit des dommages dans le tour, son attaquant gagnera 2PA pour deux tours, non cumulable.", 'portail' => 4 ) );
		\IPS\Db::i()->insert( 'dimension_bonus', array( 'name' => "Bonne distance", 'description' => "Quand un ennemi subit des dommages, 20% de ses dommages soignent les alliés situés à une distance d'exactement 7 cases de la cible.", 'portail' => 4 ) );

		return TRUE;
	}
	
	// You can create as many additional methods (step2, step3, etc.) as is necessary.
	// Each step will be executed in a new HTTP request
}