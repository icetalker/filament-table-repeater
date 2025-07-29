module.exports = {
    content: ["./resources/views/**/*.blade.php", "./src/**/*.php"],
    darkMode: "class",
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],  
}