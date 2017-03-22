<?php


namespace IPS\dimension\setup\upg_10023;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * 1.1.3.2 Upgrade Code
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
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[2,10,7,2]" ), array( 'id=?', 1 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[6,8,3,6]" ), array( 'id=?', 2 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[8,6,1,4]" ), array( 'id=?', 3 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[10,2,5,8]" ), array( 'id=?', 4 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[4,4,10,10]" ), array( 'id=?', 5 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,2,-1]" ), array( 'id=?', 6 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,4,-1]" ), array( 'id=?', 7 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,6,-1]" ), array( 'id=?', 8 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,8,-1]" ), array( 'id=?', 9 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,9,-1]" ), array( 'id=?', 10 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,1,-1,-1]" ), array( 'id=?', 11 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,3,-1,-1]" ), array( 'id=?', 12 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,5,-1,-1]" ), array( 'id=?', 13 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,7,-1,-1]" ), array( 'id=?', 14 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,9,-1,-1]" ), array( 'id=?', 15 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[9,-1,-1,-1]" ), array( 'id=?', 16 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[1,-1,-1,-1]" ), array( 'id=?', 17 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[3,-1,-1,-1]" ), array( 'id=?', 18 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[5,-1,-1,-1]" ), array( 'id=?', 19 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[7,-1,-1,-1]" ), array( 'id=?', 20 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,-1,1]" ), array( 'id=?', 21 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,-1,3]" ), array( 'id=?', 22 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,-1,5]" ), array( 'id=?', 23 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,-1,7]" ), array( 'id=?', 24 ) );
		\IPS\Db::i()->update( 'dimension_bonus', array( 'ordre' => "[-1,-1,-1,9]" ), array( 'id=?', 25 ) );


		return TRUE;
	}
	
	// You can create as many additional methods (step2, step3, etc.) as is necessary.
	// Each step will be executed in a new HTTP request
}