/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./src/public/index.php",
		"./src/pages/**/index.php",
		"./src/components/**/*.php",
	],
	theme: {
		extend: {
			fontFamily: {
				poppins: ["Poppins", "sans-serif"],
			},
			colors: {
				tab: {
					active: "#00A1E2",
					inactive: "#ebebeb",
					hover: "#007BB5",
					focus: "#00699F",
				},
			},
			utilities: [
				{
					name: "tab-active",
					properties: ["background-color", "color"],
					values: {
						"": "tab.active",
					},
				},
			],
		},
	},
	plugins: [],
};
