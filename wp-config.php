<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do banco de dados
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do banco de dados - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'ecommerce' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'zb`w7/X/5W50LU%3 *iRQ;Jw*HK )kAQ7YgeP5Sw>:FS=RieoCfaMXzw]Q.%zsui' );
define( 'SECURE_AUTH_KEY',  ')%/7%8{Lw5*+vK[wH<l&-;c)<uWu&[@yy6eYk[u-ZqkYjqJ?nchh`C 1zQR58)1_' );
define( 'LOGGED_IN_KEY',    '$&ZN;AZX9BG,tQ:9$_z^]DM{pP*W^h%7^,%koFIM{~u&Uhmm=}%e*9?%coE>:W$q' );
define( 'NONCE_KEY',        'Q7)+((>F<+e{$$I>{^nxr_>Z+8UqM5i*,&[n9SgpG3E&.LT(Q qgq;KpO5FxD3<A' );
define( 'AUTH_SALT',        ' &P$f`n{tPXGyspX>R%)y#)`@S9XoH1@=F+BR&Rr8+2I@Ul;&<Zm=pl#WIaKM?:;' );
define( 'SECURE_AUTH_SALT', 'Ai<J^[J5Un!t3tD3lhWU_D@,=K1ae61%|u&n2*@c-. =G=0pl]D2|sxt)^bXV7{>' );
define( 'LOGGED_IN_SALT',   '}0%4W ln|GQdu]5Iy66o`#+S M&:(U<n%SAO1IK0%~NPTZ_Dk&lN=T^f%/aGC_K2' );
define( 'NONCE_SALT',       'HyRAku(FTJ(F20vedB;6Rq0 o<mtF07Zs*46b]r<!1BfS+/cS@+Omg.M.O/Xexor' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Adicione valores personalizados entre esta linha até "Isto é tudo". */



/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
