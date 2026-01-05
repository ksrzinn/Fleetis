import './bootstrap';
import '../css/app.css';

import { createInertiaBaseApp } from './app.base';


// import BaseCard from './Components/Base/BaseCard.vue';
// import BaseBtn from './Components/Base/BaseBtn.vue';

createInertiaBaseApp({
    name: 'Fleetis',
    // components: [
    //     { name: 'BaseCard', component: BaseCard },
    //     { name: 'BaseBtn', component: BaseBtn },
    // ],
    plugins: [],
});
