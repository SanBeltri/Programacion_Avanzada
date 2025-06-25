// assets/app.js
// Lógica global de la aplicación (autenticación, utilidades)

const App = {
    /**
     * Verifica el estado de autenticación del usuario.
     * @returns {Object} Un objeto con isAuthenticated (boolean) y user (Object|null).
     */
    checkAuth: async function () {
        try {
            const response = await fetch('/credito-app/api/auth', { method: 'GET' });
            const data = await response.json();
            return data; // Contiene isAuthenticated y user (si está logueado)
        } catch (error) {
            console.error('Error al verificar autenticación:', error);
            return { isAuthenticated: false, user: null };
        }
    },
   
    /**
     * Cierra la sesión del usuario.
     */
    logout: async function () {
        try {
            await fetch('/credito-app/api/auth', { method: 'DELETE' });
            console.log('Sesión cerrada.');
        } catch (error) {
            console.error('Error al cerrar sesión:', error);
        }
    },

    /**
     * Traduce los estados de los créditos para mostrarlos de forma más legible.
     * @param {string} status El estado del crédito en inglés (ej. 'pending_asesor').
     * @returns {string} El estado traducido al español.
     */
    translateStatus: function (status) {
        switch (status) {
            case 'pending_asesor':
                return 'Pendiente de Asesor';
            case 'pending_subgerente':
                return 'Pendiente de Subgerente';
            case 'pending_gerente':
                return 'Pendiente de Gerente';
            case 'approved':
                return 'Aprobado';
            case 'denied':
                return 'Negado';
            default:
                return status;
        }
    },

    /**
     * Muestra un mensaje en un elemento DOM específico.
     * @param {HTMLElement} element El elemento DOM donde mostrar el mensaje.
     * @param {string} message El texto del mensaje.
     * @param {string} type El tipo de mensaje ('success', 'error', 'info').
     */
    showMessage: function (element, message, type) {
        element.textContent = message;
        element.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700', 'bg-blue-100', 'text-blue-700');
        switch (type) {
            case 'success':
                element.classList.add('bg-green-100', 'text-green-700');
                break;
            case 'error':
                element.classList.add('bg-red-100', 'text-red-700');
                break;
            case 'info':
                element.classList.add('bg-blue-100', 'text-blue-700');
                break;
            default:
                break;
        }
        element.classList.remove('hidden');
        setTimeout(() => {
            element.classList.add('hidden');
        }, 5000); // Ocultar mensaje después de 5 segundos
    }
};

// Exportar App para que sea accesible globalmente o importable si se usa módulos
// Para este setup simple, se asume que App está en el scope global.
// window.App = App; // Esto lo haría global explícitamente si no se usara defer o type="module" en los scripts HTML.

