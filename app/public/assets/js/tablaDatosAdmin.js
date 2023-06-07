$(function () {

    $('#tabla_datos').DataTable({
        language: {
            emptyTable: "No se ha encontrado ningún producto",
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        bInfo: false,
        ajax: "/api/datos",
        dataSrc: "data",
        columns: [
            { data: "emailUsuario" },
            { data: "pasos" },
            {
                data: "distancia",
                render: function (data, type, row) {
                    return data.toFixed(2);
                }
            },
            {
                data: "peso",
                render: function (data, type, row) {
                    return data.toFixed(1);
                }
            },
            {
                data: "caloriasQuemadas",
                render: function (data, type, row) {
                    return data.toFixed(2);
                }
            },
            {
                data: "fecha",
                render: function (data, type, row) {
                    fecha = new Date(data.date);
                    strFecha = fecha.getDate()+"/"+(fecha.getMonth()+1)+"/"+(fecha.getYear()+1900);
                    return strFecha;
                }
            }
        ]
    });

})