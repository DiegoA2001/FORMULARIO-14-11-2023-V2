    // Función para validar y convertir a mayúsculas
    function validateAndUpperCase(inputElement) {
        inputElement.value = inputElement.value.toUpperCase(); // Convierte a mayúsculas

        // Utiliza una expresión regular para permitir solo letras en mayúscula
        var regex = /^[A-Z0-9\s]+$/;
        if (!regex.test(inputElement.value)) {
            alert("Solo se permiten letras en mayúscula.");
            inputElement.value = ""; // Borra el valor si no cumple con la regla
        }
    }

    // Función para validar el formulario
    function validateForm() {
        // Obtener los valores de los campos obligatorios
        var date = document.getElementById("date").value;
        var customer = document.getElementById("customer").value;
        var lote = document.getElementById("lote").value;

        // Verificar si alguno de los campos está vacío
        if (date === "" || customer === "" || lote === "") {
            alert("Por favor, complete todos los campos obligatorios.");
            return false; // Evitar el envío del formulario si falta algún dato
        }

        // Si todos los campos obligatorios están completos, se permite el envío
        return true;
    }

    // Agrega oyentes de eventos a los campos de cliente y lote
    var customerInput = document.getElementById("customer");
    var loteInput = document.getElementById("lote");

    customerInput.addEventListener("input", function () {
        validateAndUpperCase(customerInput);
    });

    loteInput.addEventListener("input", function () {
        validateAndUpperCase(loteInput);
    });

    document.getElementById("sendButton").addEventListener("click", function (event) {
        // Verificar si el botón presionado es el de "Registrar Datos"
        if (event.target.name === "send" && event.target.getAttribute("data-action") === "insert") {
            if (!validateForm()) {
                event.preventDefault(); // Evitar el envío del formulario si la validación falla
            }
        }
    });
// Función para validar el formulario al hacer clic en el botón "Registrar Datos"
function validateForm(event) {
    // Obtener el botón que fue clickeado
    var clickedButton = event.target;

    // Verificar si el botón presionado es el de "Registrar Datos"
    if (clickedButton.id === "sendButton" && clickedButton.getAttribute("data-action") === "insert") {
        // Obtener los valores de los campos obligatorios
        var date = document.getElementById("date").value;
        var customer = document.getElementById("customer").value;
        var lote = document.getElementById("lote").value;

        // Verificar si alguno de los campos está vacío
        if (date === "" || customer === "" || lote === "") {
            alert("Por favor, complete todos los campos obligatorios.");
            event.preventDefault(); // Evitar el envío del formulario si falta algún dato
            return false;
        }
    }

    // Si no es el botón de "Registrar Datos", permitir el envío
    return true;
}

       // Evento de clic para el botón de búsqueda
    document.getElementById("buscarButton").addEventListener("click", function (event) {
        // Prevenir el envío del formulario
        event.preventDefault();

        // Obtener el valor de búsqueda
        const searchTerm = document.getElementById("buscar").value;

        // Realizar la solicitud AJAX para buscar los datos en el servidor
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "buscar.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reemplazar el contenido de la tabla con los resultados de la búsqueda
                const resultadoTable = document.querySelector("table.resultados");
                resultadoTable.innerHTML = xhr.responseText;
            }
        };
        xhr.send("buscar=" + searchTerm);
    });
        // Evento de clic para los botones "Editar"
        function editRecord(folio) {
const editButtons = document.querySelectorAll(".edit-button");
editButtons.forEach((editButton) => {
    editButton.addEventListener("click", function () {
        // Obtener el folio asociado a esta fila
        const folio = editButton.getAttribute("data-folio");
        // Redirigir a la página de edición con el folio como parámetro
        window.location.href = `editar.php?folio=${folio}`;
    });
});
}
// Evento de clic para los botones "Eliminar"
function deleteRecord(folio) {
const deleteButtons = document.querySelectorAll(".delete-button");
deleteButtons.forEach((deleteButton) => {
    deleteButton.addEventListener("click", function () {
        // Obtener el folio asociado a esta fila
        const folio = deleteButton.getAttribute("data-folio");
        // Preguntar al usuario si realmente desea eliminar el registro
        if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
            // Redirigir a la página de eliminación con el folio como parámetro
            window.location.href = `eliminar.php?folio=${folio}`;
        }
    });
});
}
// Función para exportar a Excel
function exportToExcel() {
    const table = document.querySelector(".resultados");

    // Crear un libro de Excel
    const wb = XLSX.utils.book_new();
    
    // Crear una nueva hoja de trabajo
    const ws = XLSX.utils.table_to_sheet(table);

    // Agregar la hoja de trabajo al libro
    XLSX.utils.book_append_sheet(wb, ws, "Resultados");

    // Guardar el libro como archivo Excel
    XLSX.writeFile(wb, 'resultados.xlsx');
}

// Función para exportar a PDF
function exportToPDF() {
    const table = document.querySelector(".resultados");

    // Crear un nuevo documento PDF
    const pdf = new jsPDF();

    // Configurar la posición inicial en el documento PDF
    let y = 10;

    // Iterar sobre las filas de la tabla
    table.querySelectorAll("tr").forEach((row) => {
        // Iterar sobre las celdas de la fila
        row.querySelectorAll("th, td").forEach((cell) => {
            // Añadir el contenido de la celda al PDF
            pdf.text(cell.innerText, 10, y);
        });

        // Incrementar la posición Y para la próxima fila
        y += 10;
    });

    // Guardar el documento como archivo PDF
    pdf.save("resultados.pdf");
}

// Asociar la función de exportar a PDF al evento de clic en el botón "Exportar a PDF"
document.getElementById("exportToPDFButton").addEventListener("click", exportToPDF);

// Asociar la función de validación al evento de clic en el botón "Registrar Datos"
document.getElementById("sendButton").addEventListener("click", validateForm);

// Asociar la función de exportar a Excel al evento de clic en el botón "Exportar a Excel"
document.getElementById("exportButton").addEventListener("click", exportToExcel);

// Asociar la función de exportar a PDF al evento de clic en el botón "Exportar a PDF" (debes implementar esta función)
document.getElementById("exportToPDFButton").addEventListener("click", exportToPDF);