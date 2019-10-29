/**
 * WordPress dependencies
 */
const { getCategories, setCategories } = wp.blocks;

/**
 * Internal dependencies
 */
import icons from './icons';

/**
 * Internal dependencies
 */

setCategories( [
	// Add a tecut block category
	{
		slug: 'tecut',
		title: 'tecut',
		icon: icons.tecut,
	},
	...getCategories().filter( ( { slug } ) => slug !== 'tecut' ),
] );
