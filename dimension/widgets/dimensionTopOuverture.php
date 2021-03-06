<?php
/**
 * @brief		dimensionTopOuverture Widget
 * @author		<a href='http://www.invisionpower.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) 2001 - SVN_YYYY Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/legal/standards/
 * @package		IPS Social Suite
 * @subpackage	dimension
 * @since		05 Sep 2015
 * @version		SVN_VERSION_NUMBER
 */

namespace IPS\dimension\widgets;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * dimensionTopOuverture Widget
 */
class _dimensionTopOuverture extends \IPS\Widget\StaticCache
{
	/**
	 * @brief	Widget Key
	 */
	public $key = 'dimensionTopOuverture';
	
	/**
	 * @brief	App
	 */
	public $app = 'dimension';
		
	/**
	 * @brief	Plugin
	 */
	public $plugin = '';
	
	/**
	 * Initialise this widget
	 *
	 * @return void
	 */ 
	public function init()
	{
		// Use this to perform any set up and to assign a template that is not in the following format:
		// $this->template( array( \IPS\Theme::i()->getTemplate( 'widgets', $this->app, 'front' ), $this->key ) );
		// If you are creating a plugin, uncomment this line:
		// $this->template( array( \IPS\Theme::i()->getTemplate( 'plugins', 'core', 'global' ), $this->key ) );
		// And then create your template at located at plugins/<your plugin>/dev/html/dimensionTopOuverture.phtml
		
		
		parent::init();
	}
	
	/**
	 * Specify widget configuration
	 *
	 * @param	null|\IPS\Helpers\Form	$form	Form object
	 * @return	null|\IPS\Helpers\Form
	 */
	public function configuration( &$form=null )
	{
 		if ( $form === null )
		{
	 		$form = new \IPS\Helpers\Form;
 		}

 		// $$form->add( new \IPS\Helpers\Form\XXXX( .... ) );
 		// return $form;
 	} 
 	
 	 /**
 	 * Ran before saving widget configuration
 	 *
 	 * @param	array	$values	Values from form
 	 * @return	array
 	 */
 	public function preConfig( $values )
 	{
 		return $values;
 	}

	/**
	 * Render a widget
	 *
	 * @return	string
	 */
	public function render()
	{
		$allowed_group = \IPS\Settings::i()->dimension_allowed_group;

		if($allowed_group !== '*') {
			$allowed_group = explode( ',', $allowed_group );
			
			if( !\IPS\Member::loggedIn()->inGroup( $allowed_group ) )
				return '';
		}

		$topOuverturePortail = array();
		foreach ( \IPS\Db::i()->select( array( 'member', 'coordx', 'coordy', 'idPortail' ), 'dimension_positionPortail', array( 'member IS NOT NULL AND date > ?', \IPS\DateTime::create()->sub( new \DateInterval( 'P1W' ) )->strFormat( '%F' ) ) ) as $rep )
		{
			if( empty( $pos[ $rep['idPortail'] ] ) || $pos[ $rep['idPortail'] ]['x'] != $rep['coordx'] || $pos[ $rep['idPortail'] ]['y'] != $rep['coordy'] )
			{
				$pos[ $rep['idPortail'] ]['x'] = $rep['coordx'];
				$pos[ $rep['idPortail'] ]['y'] = $rep['coordy'];

				if ( !isset( $topOuverturePortail[ $rep['member'] ] ) )
				{
					$topOuverturePortail[ $rep['member'] ] = 1;
				}
				else
				{
					$topOuverturePortail[ $rep['member'] ] ++;
				}
			}
		}
		arsort( $topOuverturePortail );
		$topOuverturePortail = array_slice( $topOuverturePortail, 0, 5, TRUE );

		return $this->output( $topOuverturePortail );

		// Use $this->output( $foo, $bar ); to return a string generated by the template set in init() or manually added via $widget->template( $callback );
		// Note you MUST route output through $this->output() rather than calling \IPS\Theme::i()->getTemplate() because of the way widgets are cached
	}
}