/**
 * WordPress dependencies
 */
const {
	__,
} = wp.i18n;

/**
 * Internal dependencies
 */
import edit from './edit';
import icons from '../../blocks-helper/icons';
import metadata from './block.json';
import save from './save';

const { name } = metadata;

export { metadata, name };

export const settings = {
	title: __( 'Hello tecut', 'tecut' ),
	description: __( 'Sample block of the wp-plugin-boilerplate by Luehrsen // Heinrich.', 'tecut' ),
	icon: icons.hello,
	keywords: [
		__( 'hello', 'tecut' ),
		__( 'tecut', 'tecut' ),
	],
	supports: {
		align: true,
		alignWide: false,
	},
	edit,
	save,
};
