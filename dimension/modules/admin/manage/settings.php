<?php


namespace IPS\dimension\modules\admin\manage;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * settings
 */
class _settings extends \IPS\Dispatcher\Controller
{
	/**
	 * Execute
	 *
	 * @return	void
	 */
	public function execute()
	{
		\IPS\Dispatcher::i()->checkAcpPermission( 'settings_manage' );
		parent::execute();
	}

	/**
	 * ...
	 *
	 * @return	void
	 */
	protected function manage()
	{
		\IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack('settings');
		
		
		$form = new \IPS\Helpers\Form;
		$form->addHeader('dimension_setting_permission');

		$form->add( new \IPS\Helpers\Form\Select( 'dimension_allowed_group', ( \IPS\Settings::i()->dimension_allowed_group !== NULL ) ? ( ( \IPS\Settings::i()->dimension_allowed_group ===  '*' ) ? '*' : explode( ',', \IPS\Settings::i()->dimension_allowed_group ) ) : NULL, FALSE, array( 'options' => \IPS\Member\Group::groups(), 'unlimited' => '*', 'multiple' => TRUE, 'sort' => TRUE, 'parse' => 'normal' ) ) );

		if ( $values = $form->values() )
		{
			if($values['dimension_allowed_group'] !== '*')
				$values['dimension_allowed_group'] = implode(',', $values['dimension_allowed_group']);

			$form->saveAsSettings( $values );
			\IPS\Session::i()->log( 'acplogs__dimension_setting_change' );
			\IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=dimension&module=manage&controller=settings' ), 'saved' );
		}

		\IPS\Output::i()->output = $form;

		//dimension_allowed_group
	}
	
	// Create new methods with the same name as the 'do' parameter which should execute it
}