function showToast(message) {
    var toastContainer = document.getElementById("toast-container");
    console.log(toastContainer);

    // Crear elemento notificación
    var toast = document.createElement('div');
    toast.classList.add('toast');

    // Agregar mensaje
    toast.innerText = message;

    // Botón para cerrar la notificación
    var closeBtn = document.createElement('span');
    closeBtn.classList.add('toast-close');
    closeBtn.innerHTML = '&times;';

    // Evento para cerrar la notificación
    closeBtn.addEventListener('click', function(){
        toast.style.display = 'none';
    });

    toast.appendChild(closeBtn);
    toastContainer.appendChild(toast);

    // Mostrar la notificación
    toast.style.display = 'block'; // Cambiar a block para mostrar

    // Ocultar notificación después de 5 segundos
    setTimeout(function(){
        toast.style.display = 'none';
    }, 5000); // 5000 milisegundos = 5 seg
}
