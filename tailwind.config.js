/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"

    ],
    theme: {
        extend: {
            colors: {
                'hitam': '#030906',
                'hijautuaatas': '#0C1B20',
                'hijautua': '#0E1F23',
                'hijaufresh': '#C7F662',
                'warning': '#FFA500',
            },
            spacing: {
                '17': '66px',
                '502px': '502px',
                '1000px': '1000px',
                '475px': '475px',
                '474px': '474px',
                '473px': '473px',
                '472px': '472px',
                '471px': '471px',
                '470px': '470px',
                '469px': '469px',
                '4px': '4px',
                '5px': '5px',
                '20px': '20px',
                '22px': '22px',
                '18px': '18px',
                '17px': '17px',
                '15px': '15px',
                '14px': '14px',
                '13px': '13px',
                '12px': '12px',
                '11px': '11px',
                '10px': '10px',
                '9px': '9px',

            },
            fontFamily: {
                intregular: ['Lato_Regular', 'sans-serif'],
                intbold: ['Lato_Bold', 'sans-serif'],
                intsemibold: ['Lato_Black', 'sans-serif'],
                intmedium: ['Lato_Medium', 'sans-serif'],
                intlight: ['Lato_Light', 'sans-serif'],
                intextralight: ['Lato_ExtraLight', 'sans-serif'],
                intthin: ['Lato_Thin', 'sans-serif'],
                intitalic: ['Lato_Italic', 'sans-serif'],
                autumn: ['Autumn', 'cursive'],
                agdasima: ['Agdasima', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
    ],
}

