<?php
/**
 * OpenIDProvider.php -- Class referring to an individual OpenID provider
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @file
 * @ingroup Extensions
 */
class OpenIDProvider {
	/**
	 * Properties about this provider
	 * @var string
	 */
	protected $id, $name, $label, $url;

	public function __construct( $id, $name, $label, $url ) {
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
		$this->url = $url;
	}

	/**
	 * Get the HTML for the OpenID provider buttons
	 * @param $classSize String Size for the openid_ class, either large or small
	 * @return string
	 */
	private function getButtonHTML( $classSize ) {
		global $wgOpenIDShowProviderIcons, $wgOpenIDIconPath;

		if ( $wgOpenIDShowProviderIcons )
		{
			return '<a id="openid_provider_' . $this->id . '_icon" title="' . $this->name . '"' .
			' href="javascript: openid.show(\'' . $this->id . '\');"' .
			' class="openid_' . $classSize . '_btn' .
			( $this->id == 'openid' ? ' openid_selected' : '' ) . '"></a>';
		}
		else
		{
			return '<a id="openid_provider_' . $this->id . '_link" title="' . $this->name . '"' .
			' href="javascript: openid.show(\'' . $this->id . '\');"' .
			' class="openid_' . $classSize . '_link' .
			( $this->id == 'openid' ? ' openid_selected' : '' ) . '">' . $this->name . '</a>';
		}
	}

	public function getLargeButtonHTML() { return $this->getButtonHTML( 'large' ); }
	public function getSmallButtonHTML() { return $this->getButtonHTML( 'small' ); }

	public function getLoginFormHTML() {
		$html = '<div id="provider_form_' . $this->id . '"' .
			( $this->id == 'openid' ? '' : ' style="display:none"' ) . '>' .
			'<div><label for="openid_url">' . $this->label . '</label></div>';

		if ( $this->id == 'openid' ) {
			global $wgRequest;
			$url = htmlspecialchars( $wgRequest->getCookie( 'OpenID', null, '' ) );
			$html .= '<input type="text" name="openid_url" id="openid_url" size="45" value="' . $url . '" />';
			$html .= Xml::submitButton( wfMsg( 'userlogin' ) );
		} else {
			$html .= '<input type="hidden" id="openid_provider_url_' . $this->id . '" value="' . $this->url . '" />';
			if ( strpos( $this->url, '{' ) === false ) {
				$html .= '<input type="hidden" id="openid_provider_param_' . $this->id . '" size="25" value="" />';
			} else {
				$html .= '<input type="text" id="openid_provider_param_' . $this->id . '" size="25" value="" />';
			}
			$html .= Xml::submitButton( wfMsg( 'userlogin' ) );
		}
		$html .= '</div>';

		return $html;
	}

	/**
	 * Get the list of major OpenID providers
	 * @return array of OpenIDProvider
	 */
	public static function getLargeProviders() {
		return  array(
			new self( 'openid', 'Launchpad', wfMsg( 'openid-provider-label-openid' ), 'https://launchpad.net/~{username}' ),
		);
	}

	/**
	 * Get a list of lesser-known OpenID providers
	 * @return array of OpenIDProvider
	 */
	public static function getSmallProviders() {
		return array(

		);
	}
}
