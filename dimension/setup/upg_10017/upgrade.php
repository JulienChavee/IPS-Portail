<?php


namespace IPS\dimension\setup\upg_10017;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * 1.1.1 Upgrade Code
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
		
		\IPS\Db::i()->insert( 'dimension_positionPortail', array( 'coordx' => 0, 'coordy' => 0, 'utilisation' => 0, 'idPortail' => 4, 'date' => \IPS\DateTime::create()->strFormat( "%F %T" ), 'member' => 0, 'bonus' => -1 ) );
		
		return TRUE;
	}
	
	// You can create as many additional methods (step2, step3, etc.) as is necessary.
	// Each step will be executed in a new HTTP request
}