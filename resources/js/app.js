import './bootstrap';

// /* Alpine */
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// /* Flowbite */
import 'flowbite';

/* Tom Select */
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

/* Init Tom Select */
document.querySelectorAll('.tom-select:not(.ts-initialized)')
    .forEach((el) => {
        el.classList.add('ts-initialized');

        new TomSelect(el, {
            plugins: ['remove_button'],
            persist: false,
            create: false,
            maxItems: null,
            maxOptions: 100,
            sortField: {
                field: 'text',
                direction: 'asc',
            },
        });
    });
