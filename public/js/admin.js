document.addEventListener("DOMContentLoaded", () => {

    window.confirmDelete = function (id) {
        if (!id || isNaN(id)) return;

        const form = document.getElementById('deleteForm');
        const input = document.getElementById('deleteId');

        if (!form || !input) return;

        if (confirm("Opravdu chcete smazat tuto knihu?")) {
            input.value = id;
            form.submit();
        }
    };

});
