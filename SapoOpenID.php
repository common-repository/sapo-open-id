<?php
/*
Plugin Name: Sapo OpenID Header
Plugin URI: http://antoniocampos.no-ip.com/2008/12/24/sapo-openid-wordpress-plugin/
Description: Acrescenta as Meta Tags do OPENID do sapo no header do Blog, para permitir usar o url do blog wordpress como provider OpenId, para ver o plugin em ac&ccedil;&atilde;o visitem o meu blog e espreitem o codigo fonte (http:/antoniocampos.no-ip.com)
Author: Antonio Campos
Version: 1.2
Author URI: http://antoniocampos.no-ip.com
*/
/*  Copyright 2008  Antonio Campos aka CriticalError  (email : jantoniofcampos@sapo.pt)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_action('wp_head','OpenIdSapoHeader');
add_action('admin_menu', 'OpenIdSapoAdminMenu');

function OpenIdSapoAdminMenu()
{
	add_options_page('Opcoes OpenIdSapo', 'OpenID Sapo', 8, __FILE__, 'OpenIdSapoOpcoes');
}

if (get_option('OpenIdSapo') == "")
{
	add_action('admin_notices', 'OpenIdSapoAdminMsg');
}

function OpenIdSapoAdminMsg()
{
	echo "<div id='SapoOpenId-Warning' class='updated fade'><strong>SapoOpenId.</strong>  Ainda nao configurou o nome da persona a usar como OpenID no seu blog!!<br />Enquanto nao o fizer nao pode usar o URL do seu blog como URL OpenID</div>";
}

function OpenIdSapoOpcoes() {
	$blogUrl = get_bloginfo('url');
	echo '<div class="wrap"><h2>OpenID Sapo</h2>';
	echo "<img src=\"$blogUrl/wp-content/plugins/sapo-open-id/logo.gif\" alt = \"\"/>";
	if ((isset($_POST['OpenIdSapo'])) && ($_POST['OpenIdSapo'] != "") )
	{
		add_option('OpenIdSapo', $_POST['OpenIdSapo']);
		update_option('OpenIdSapo', $_POST['OpenIdSapo']);
	}
	$idActual = get_option('OpenIdSapo');
	echo '<form method="POST" action="">';
	echo '<p class="submit">';
	echo 'Nome da Persona: ';
	echo "<input type=\"text\" name=\"OpenIdSapo\" value=\"$idActual\">";
	echo '<input type="submit" name="Submit" value="Gravar"/>';
	echo '</p>';
	echo '</form>';	
	echo '</div>';
}

function OpenIdSapoHeader()
{
$NomePersona = get_option('OpenIdSapo');
if ($NomePersona != "")
{
echo "<!-- SapoOpenID -->
<link rel=\"openid.server\" href=\"https://openid.sapo.pt/endpoint/\">
<link rel=\"openid.delegate\" href=\"http://openid.sapo.pt/user/$NomePersona\">
<link rel=\"openid2.provider\" href=\"https://openid.sapo.pt/endpoint/\">
<link rel=\"openid2.local_id\" href=\"http://openid.sapo.pt/user/$NomePersona\">
<!-- /SapoOpenID -->\n";
}
}
?>