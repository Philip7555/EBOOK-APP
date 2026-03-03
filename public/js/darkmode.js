document.addEventListener("DOMContentLoaded", () => {
    const toggles = document.querySelectorAll("#darkmode-toggle");

    // Načtení uloženého režimu
    const saved = localStorage.getItem("darkmode");
    if (saved === "enabled") {
        document.documentElement.classList.add("dark");
    }

    // Přepínání režimu
    toggles.forEach(toggle => {
        toggle.addEventListener("click", () => {
            document.documentElement.classList.toggle("dark");

            if (document.documentElement.classList.contains("dark")) {
                localStorage.setItem("darkmode", "enabled");
            } else {
                localStorage.setItem("darkmode", "disabled");
            }
        });
    });
});
