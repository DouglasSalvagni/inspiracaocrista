<?php

/**
 * Post types customizados
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

require_once __DIR__ . "/custom-post-types/leads.php";
require_once __DIR__ . "/custom-post-types/teams.php";

/**
 * Cria labels para um custom post type de forma mais ágil.
 * @param string $nameSingular Nome do post type no singular.
 * @param string $namePlural Nome do post type no plural.
 * @param bool $feminino Se o nome do post type é feminino.
 * @return array Array com as labels.
 */
function createLabelsCPT(string $nameSingular, string $namePlural, bool $feminino = false): array
{

	$adicionarNovo = _x('Adicionar Nov' . ($feminino ? 'a ' : 'o '), $nameSingular);
	$adicionarNovoItem =  __('Adicionar Nov' . ($feminino ? 'a ' : 'o ') . $nameSingular);
	$novo =  __('Nov' . ($feminino ? 'a' : 'o') . $nameSingular);
	$todosOs = __('Tod' . ($feminino ? 'as ' : 'os ') . ($feminino ? 'as ' : 'os ') . $namePlural);
	$nanhumEncontrado =  __('Nenhum' . ($feminino ? 'a ' : ' ')  . $nameSingular . ' Encontrad' . ($feminino ? 'a' : 'o'));
	$nanhumLixeira =  __('Nenhum' . ($feminino ? 'a ' : ' ') . $nameSingular . ' na Lixeira');

	$labels = array(
		'name' => _x($namePlural, 'post type general name'),
		'singular_name' => _x($nameSingular, 'post type singular name'),
		'add_new' => $adicionarNovo,
		'add_new_item' => $adicionarNovoItem,
		'edit_item' => __('Editar ' . $nameSingular),
		'new_item' => $novo,
		'all_items' => $todosOs,
		'view_item' => __('Ver ' . $nameSingular),
		'search_items' => __('Pesquisar ' . $nameSingular),
		'not_found' =>  $nanhumEncontrado,
		'not_found_in_trash' => $nanhumLixeira,
		'parent_item_colon' => '',
		'menu_name' => $namePlural
	);

	return $labels;
}
