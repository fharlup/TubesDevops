import * as bootstrap from 'bootstrap';


function setupKetersediaanModal() {
    const modalElement = document.getElementById('ketersediaanModal');
    if (!modalElement) {
        return;
    }

    const ketersediaanModal = new bootstrap.Modal(modalElement);

    const errorContainer = document.getElementById('modal-errors');

    if (errorContainer && !errorContainer.classList.contains('d-none')) {
        ketersediaanModal.show();
    }
}

document.addEventListener('DOMContentLoaded', setupKetersediaanModal);
