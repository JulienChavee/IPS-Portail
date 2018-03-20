<?php


namespace IPS\dimension\modules\front\system;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * ajax
 */
class _ajax extends \IPS\Dispatcher\Controller
{
	/**
	 * Execute
	 *
	 * @return	void
	 */
	public function execute()
	{
		
		parent::execute();
	}

	/**
	 * ...
	 *
	 * @return	void
	 */
	protected function manage()
	{
		// This is the default method if no 'do' parameter is specified
	}
	
	// Create new methods with the same name as the 'do' parameter which should execute it

	public function dimensionPosition()
	{
		$allowed_group = \IPS\Settings::i()->dimension_allowed_group;

		if($allowed_group !== '*') {
			$allowed_group = explode( ',', $allowed_group );
			
			if( !\IPS\Member::loggedIn()->inGroup( $allowed_group ) )
				\IPS\Output::i()->error( 'node_error_no_perm', 'no_perm', 403, '' );
		}

		if ( isset( \IPS\Request::i()->dimension ) )
		{
			$portail = array();

			switch ( \IPS\Request::i()->dimension )
			{
				case 'srambad':
					$portail = $this->_getLastPosition( 2 );
					break;
				case 'enutrosor':
					$portail = $this->_getLastPosition( 3 );
					break;
				case 'xelorium':
					$portail = $this->_getLastPosition( 1 );
					break;
				case 'ecaflipus':
					$portail = $this->_getLastPosition( 4 );
					break;
			}
        }

        $fav = isset( \IPS\Request::i()->cookie['dimension_fav'] ) ? \IPS\Request::i()->cookie['dimension_fav'] : null;
		
		/* Render */
		$output = \IPS\Theme::i()->getTemplate( 'widgets' )->dimensionRow( $portail, $fav );
		if ( \IPS\Request::i()->isAjax() )
		{
			\IPS\Output::i()->sendOutput( $output );
		}
		else
		{
			\IPS\Output::i()->output = $output;
		}
	}

	protected function _getLastPosition( $id ) {
		return \IPS\Db::i()->select( '*', 'dimension_positionPortail', 'idPortail = '.$id, 'id DESC' )->first();
	}

	public function topPoster() {

		$time = \IPS\Request::i()->time;

		switch( $time ) {
			case 'week':
				$interval = 'P1W';
			break;

			case 'month':
				$interval = 'P1M';
			break;

			case 'year':
				$interval = 'P1Y';
			break;

			default:
				$interval = 'P1W';
		}

		$topOuverturePortail = array();
		$pos = array();

		if( $time != 'all' )
			$requete = \IPS\Db::i()->select( array( 'member', 'coordx', 'coordy', 'idPortail' ), 'dimension_positionPortail', array( 'member IS NOT NULL AND date > ?', \IPS\DateTime::create()->sub( new \DateInterval( $interval ) )->strFormat( '%F' ) ) );
		else
			$requete = \IPS\Db::i()->select( array( 'member', 'coordx', 'coordy', 'idPortail' ), 'dimension_positionPortail', array( 'member IS NOT NULL' ) );

		foreach ( $requete as $rep )
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

		$output = \IPS\Theme::i()->getTemplate( 'widgets' )->dimensionTopOuvertureRow( $topOuverturePortail );
		if ( \IPS\Request::i()->isAjax() )
		{
			\IPS\Output::i()->sendOutput( $output );
		} else
		{
			\IPS\Output::i()->output = $output;
		} 
	}

	public function updatePortail()
	{
		$allowed_group = \IPS\Settings::i()->dimension_allowed_group;

		if($allowed_group !== '*') {
			$allowed_group = explode( ',', $allowed_group );
			
			if( !\IPS\Member::loggedIn()->inGroup( $allowed_group ) )
				\IPS\Output::i()->error( 'node_error_no_perm', 'no_perm', 403, '' );
		}

		if( isset( \IPS\Request::i()->id ) ) {
			/* Sélection et traitement des bonus */
			$bonusDb = \IPS\Db::i()->select( 'id, name', 'dimension_bonus', array( 'portail=? OR portail=?', -1, \IPS\Request::i()->id ) );

			$bonus = array();
			$bonus[-1] = 'Inconnu';
			foreach($bonusDb as $v) {
				$bonus[$v['id']] = $v['name'];
			}

			/* Form */
			$form = new \IPS\Helpers\Form( 'dimension_popup_updatePortail', 'save' );
			$form->class = 'ipsForm_vertical';
			$form->add( new \IPS\Helpers\Form\Select( 'dimension_updateForm_portail', (int) \IPS\Request::i()->id, true, array( 'options' => array( 1 => 'dimension_xelorium', 2 => 'dimension_srambad', 3 => 'dimension_enutrosor', 4 => 'dimension_ecaflipus' ) ) ) );
			$form->add( new \IPS\Helpers\Form\Number( 'dimension_updateForm_position_x', (int) \IPS\Request::i()->coordx, true, array( 
					'min' => -99,
					'max' => 99
				)
			) );
			$form->add( new \IPS\Helpers\Form\Number( 'dimension_updateForm_position_y', (int) \IPS\Request::i()->coordy, true, array(
					'min' => -99,
					'max' => 99
				)
			) );

			$form->add( new \IPS\Helpers\Form\YesNo( 'dimension_updateForm_arbre_hakam', (int) \IPS\Request::i()->arbre, true ) );

			$form->add( new \IPS\Helpers\Form\Number( 'dimension_updateForm_utilisation', (int) \IPS\Request::i()->nbUtilisation, true, array( 'min' => 0, 'max' => 130 ) ) );
			$form->add( new \IPS\Helpers\Form\Select( 'dimension_updateForm_bonus', (int) \IPS\Request::i()->idBonus, true, array( 'options' => $bonus, 'parse' => 'normal' ) ) );

			if ( $values = $form->values() )
			{
				$portail = $this->_getLastPosition( $values['dimension_updateForm_portail'] );

				if( $values['dimension_updateForm_position_x'] != $portail['coordx'] || $values['dimension_updateForm_position_y'] != $portail['coordy'] || $values['dimension_updateForm_utilisation'] != $portail['utilisation'] || $values['dimension_updateForm_bonus'] != $portail['bonus'] || $values['dimension_updateForm_arbre_hakam'] != $portail['arbre_hakam']) {

					\IPS\Db::i()->insert( 'dimension_positionPortail', array( 'coordx' => $values['dimension_updateForm_position_x'], 'coordy' => $values['dimension_updateForm_position_y'], 'arbre_hakam' => $values['dimension_updateForm_arbre_hakam'], 'utilisation' => $values['dimension_updateForm_utilisation'], 'idPortail' => $values['dimension_updateForm_portail'], 'date' => \IPS\DateTime::create()->strFormat( "%F %T" ), 'member' => \IPS\Member::loggedIn()->member_id, 'bonus' => $values['dimension_updateForm_bonus'] ) );
					\IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'returnPortail='.\IPS\Request::i()->id ), 'saved' );
				} else
					\IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'returnPortail='.\IPS\Request::i()->id ), 'dimension_update_noModificationFound' );
			}
			
			\IPS\Output::i()->title			= \IPS\Member::loggedIn()->language()->addToStack( 'dimension_popup_updatePortail' );
			//\IPS\Output::i()->output		= \IPS\Theme::i()->getTemplate( 'widgets' )->updateForm( $form );
			\IPS\Output::i()->output = $form->customTemplate( array( call_user_func_array( array( \IPS\Theme::i(), 'getTemplate' ), array( 'forms', 'dimension' ) ), 'updateFormPopup' ) );
		} else {
			// TODO
		}
	}

	public function history()
	{
		$allowed_group = \IPS\Settings::i()->dimension_allowed_group;

		if($allowed_group !== '*') {
			$allowed_group = explode( ',', $allowed_group );
			
			if( !\IPS\Member::loggedIn()->inGroup( $allowed_group ) )
				\IPS\Output::i()->error( 'node_error_no_perm', 'no_perm', 403, '' );
		}

		if( isset( \IPS\Request::i()->id ) ) {
			
			$data = \IPS\Db::i()->select( '*', 'dimension_positionPortail', array( 'idPortail=?', \IPS\Request::i()->id ), 'id DESC', 5 );
			
			\IPS\Output::i()->title			= \IPS\Member::loggedIn()->language()->addToStack( 'dimension_popup_history' );
			\IPS\Output::i()->output		= \IPS\Theme::i()->getTemplate( 'widgets' )->history( $data );
		} else {
			// TODO
		}
	}

	public function getBonus()
	{
		$res = array();
		if( isset( \IPS\Request::i()->dimension ) ) {
			$bonusDb = \IPS\Db::i()->select( 'id, name', 'dimension_bonus', array( 'portail=? OR portail=?', -1, \IPS\Request::i()->dimension ) );

			$bonus = '<option value="-1">Inconnu</option>';
			foreach($bonusDb as $v) {
				$bonus .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
			}

			$res['bonusHTML'] = $bonus;
		}

		\IPS\Output::i()->json( $res );
	}

	public function fav()
	{
		$expire = new \IPS\DateTime;
		$expire->add( new \DateInterval( 'P10Y' ) );
		\IPS\Request::i()->setCookie( 'dimension_fav', \IPS\Request::i()->id, $expire );

		\IPS\Output::i()->redirect( \IPS\Http\Url::internal( '' ), 'dimension_fav_saved' );
	}

	protected function _calculBonus( $id, $bonus ) {
		$res = array();
		foreach( $bonus as $k => $v ) {
			if( $v['bonus']['id'] == $id ) {
				$res['next'] = ($k + 1) < 10 ? ($k + 1) : 0;
				$res['prec'] = ($k - 1) >= 0  ? ($k - 1) : 9;
				$res['actuel'] = $k;

				return $res;
			}
		}

		return $res;
	}

	public function hovercard() 
	{
		$bonus = \IPS\Db::i()->select( 'id, name, ordre', 'dimension_bonus', array( 'portail=? OR portail=?', -1, \IPS\Request::i()->id ) );

		$array_bonus = array();
		foreach($bonus as $k => $v) {		
			$b = json_decode( $v['ordre'] );
			$array_bonus[] = array( 'code' => $b[\IPS\Request::i()->id - 1], 'bonus' => $v );
		}

		$portail = $this->_getLastPosition( \IPS\Request::i()->id );

		sort( $array_bonus );

		$bonus = $this->_calculBonus( $portail['bonus'], $array_bonus );

		\IPS\Output::i()->sendOutput( \IPS\Theme::i()->getTemplate( 'widgets' )->hovercard( $array_bonus, $bonus ) );
	}
}
