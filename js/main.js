document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("formCategoria");
    const errorMsg = document.getElementById("errorMsg");

    form.addEventListener("submit", function(e) {
        errorMsg.classList.add("d-none");
        errorMsg.textContent = "";

        const action = e.submitter.getAttribute("formaction");
        const selectCategoria = document.getElementById("id_categoria").value.trim();
        const nombre = document.getElementById("categoria").value.trim();
        const orden = document.getElementById("orden").value.trim();
        const activa = document.getElementById("activa").value.trim();

        if (action === "modificarCategoria") {
            if (!selectCategoria || !nombre || !orden || !activa) {
                e.preventDefault();
                errorMsg.textContent = "Completa todos los campos para modificar.";
                errorMsg.classList.remove("d-none");
            }
        } else if (action === "eliminarCategoria") {
            if (!selectCategoria) {
                e.preventDefault();
                errorMsg.textContent = "Selecciona una categoría para eliminar.";
                errorMsg.classList.remove("d-none");
            }
        } else if (action === "agregarCategoria") {
            if (!nombre || !orden || !activa) {
                e.preventDefault();
                errorMsg.textContent = "Completa todos los campos para agregar.";
                errorMsg.classList.remove("d-none");
            }
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("authForm");
    const errorMsg = document.getElementById("errorMsg");

    form.addEventListener("submit", function (e) {
        errorMsg?.classList.add("d-none");
        errorMsg.textContent = "";

        const action = e.submitter.getAttribute("formaction");
        const user = form.querySelector('input[name="user"]').value.trim();
        const password = form.querySelector('input[name="password"]').value.trim();

        if (!user || !password) {
            e.preventDefault();
            errorMsg.textContent = "Completá usuario y contraseña.";
            errorMsg.classList.remove("d-none");
        }

        // ❌ NO uses form.submit()
        // ✅ Dejá que el navegador haga el submit con el formaction
    });
});


