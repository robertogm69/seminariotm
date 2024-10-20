// const btnEnviar = document.querySelector('boton--primario');
// btnEnviar.addEventListener('click', function(event){
//     event.preventDefault();


//     console.log('enviando formulario');
// });

const datos = {
    nombre: '',
    apellido1: '',
    apellido2: '',
    email: '',
    password: ''
}

const nombre = document.querySelector('#nombre');
const apellido1 = document.querySelector('#apellido1');
const apellido2 = document.querySelector('#apellido2');
const email = document.querySelector('#email');
const password = document.querySelector('#password');
const formulario = document.querySelector('.formulario');

nombre.addEventListener('input', leerTexto);
apellido1.addEventListener('input', leerTexto);
apellido2.addEventListener('input', leerTexto);
email.addEventListener('input', leerTexto);
password.addEventListener('input', leerTexto);

// Evento submit
formulario.addEventListener('submit', function(evento) {
    evento.preventDefault();

    // Validar el formulario

    const { nombre, apellido1, apellido2, email, password } = datos;

    if(nombre === '' || apellido1 === '' || apellido2 === '' || email === ''  || password === '') {
        mostrarError('Todos los campos son obligatorios');

        return;  // Corta la ejecución del código
    }

    // Crear alerta de enviar correctamente
    mostrarMensaje('Formulario enviado correctamente');
});

function leerTexto(e) {
    datos[e.target.id] = e.target.value;

   // console.log(datos);
}


// Refactorizar alertas
// function mostrarAlerta(mensaje, error = null) {
//     const alerta = document.createElement('P');
//     alerta.textContent = mensaje;
    
//     if(error) {
//         alerta.classList.add('error');
//     } else {
//         alerta.classList.add('correcto');
//     }
    
//     formulario.appendChild(alerta);

//      // Desaparezca despues de 5 segundos
//      setTimeout(() => {
//         alerta.remove();
//     }, 5000);

// }



//Muestra una alerta de que se envío correctamente
function mostrarMensaje(mensaje) {
    const alerta = document.createElement('P');
    alerta.textContent = mensaje;
    alerta.classList.add('correcto');

    formulario.appendChild(alerta);

    // Desaparezca despues de 5 segundos
    setTimeout(() => {
        alerta.remove();
    }, 5000);
}


// Mostrar un error en pantalla
function mostrarError(mensaje) {
    const error = document.createElement('P');
    error.textContent = mensaje;
    error.classList.add('error');

    formulario.appendChild(error);

    // Desaparecer mensaje depues de 5 segundos
    setTimeout(() => {
        error.remove();
    }, 5000);
}


    



