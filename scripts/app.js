
const cargarApi = async () => {
    document.getElementById('formPersona').addEventListener('submit', function (e) {
        e.preventDefault();  // Prevenir la recarga de la página

        // Obtener los valores de los campos del formulario
        const apellido = document.getElementById('apellido').value;
        const nombre = document.getElementById('nombre').value;
        const celular = document.getElementById('celular').value;
        const latitudGrados = document.getElementById('latitudGrados').value;
        const latitudMinutos = document.getElementById('latitudMinutos').value;
        const latitudSegundos = document.getElementById('latitudSegundos').value;
        const longitudGrados = document.getElementById('longitudGrados').value;
        const longitudMinutos = document.getElementById('longitudMinutos').value;
        const longitudSegundos = document.getElementById('longitudSegundos').value;
        const disponible = document.getElementById('disponible').value;
        
        const latitud = convertirGrados(latitudGrados, latitudMinutos, latitudSegundos);
        const longitud = convertirGrados(longitudGrados, longitudMinutos, longitudSegundos);

        // Crear objeto con los datos
        const personaData = {
            apellido: apellido,
            nombre: nombre,
            celular: "54"+celular,
            latitud: latitud,
            longitud: longitud,
            disponible: disponible
        };  

        // Enviar los datos a la API
        fetch('http://localhost/Recuperatorio2023web/cordenate/guardar_persona.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(personaData)
        })
        .then(response => {
            // Verificar si la respuesta es JSON válida
            return response.text().then(text => {
                try {
                    return JSON.parse(text); // Intentar parsear la respuesta como JSON
                } catch (error) {
                    console.error("La respuesta no es JSON válido:", text);
                    throw new Error("La respuesta del servidor no es JSON válido");
                }
            });
        })
        .then(data => {
            console.log('Éxito:', data);
            alert('Datos guardados correctamente');
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Hubo un error al guardar los datos');
        });
    });
  };


function convertirGrados(grados, minutos, segundos) {
    return (-1 * (parseFloat(grados) + (parseFloat(minutos) / 60) + (parseFloat(segundos) / 3600))).toFixed(6);
}


cargarApi();