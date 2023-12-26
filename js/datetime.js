document.addEventListener("DOMContentLoaded", function () {
    // Obtener la fecha actual
    var fechaActual = new Date();

    // Configurar la zona horaria a la de Perú (UTC-5)
    fechaActual.setHours(fechaActual.getHours() - 5);

    // Obtener partes de la fecha
    var dia = fechaActual.getDate();
    var mes = fechaActual.toLocaleString('es-PE', { month: 'long' });
    var anio = fechaActual.getFullYear();

    // Formatear la fecha como "20 de diciembre del 2023"
    var fechaFormateada = dia + ' de ' + mes + ' del ' + anio;

    // Mostrar la fecha en el elemento HTML
    document.getElementById("fechaActual").textContent =  fechaFormateada;
});