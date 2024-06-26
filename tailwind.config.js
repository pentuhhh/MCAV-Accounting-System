/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./src/public/index.php",
		"./src/pages/**/index.php",
		"./src/components/**/*.php",
	],
	theme: {
		extend: {},
	},
	plugins: [],
};
